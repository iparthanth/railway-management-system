<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class OtpService
{
    protected $smsService;
    
    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * Generate OTP for user
     */
    public function generateOtp(User $user, string $purpose = 'verification'): string
    {
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = now()->addMinutes(5);
        
        // Store OTP in user model
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => $expiresAt
        ]);
        
        // Also cache for additional security
        $cacheKey = "otp:{$user->id}:{$purpose}";
        Cache::put($cacheKey, [
            'code' => $otp,
            'expires_at' => $expiresAt,
            'attempts' => 0
        ], $expiresAt);
        
        Log::info("OTP generated for user {$user->id} for purpose: {$purpose}");
        
        return $otp;
    }

    /**
     * Verify OTP for user
     */
    public function verifyOtp(User $user, string $otp, string $purpose = 'verification'): bool
    {
        $cacheKey = "otp:{$user->id}:{$purpose}";
        $cachedOtp = Cache::get($cacheKey);
        
        // Check rate limiting
        if ($cachedOtp && $cachedOtp['attempts'] >= 3) {
            Log::warning("Too many OTP attempts for user {$user->id}");
            return false;
        }
        
        // Verify against database first
        $isValidDatabase = $user->otp_code === $otp && 
                          $user->otp_expires_at && 
                          $user->otp_expires_at->gt(now());
        
        // Verify against cache as secondary check
        $isValidCache = $cachedOtp && 
                       $cachedOtp['code'] === $otp && 
                       $cachedOtp['expires_at']->gt(now());
        
        if ($isValidDatabase && $isValidCache) {
            // Clear OTP data
            $user->update([
                'otp_code' => null,
                'otp_expires_at' => null,
                'mobile_verified' => true
            ]);
            
            Cache::forget($cacheKey);
            
            Log::info("OTP verified successfully for user {$user->id}");
            return true;
        }
        
        // Increment attempts
        if ($cachedOtp) {
            $cachedOtp['attempts']++;
            Cache::put($cacheKey, $cachedOtp, $cachedOtp['expires_at']);
        }
        
        Log::warning("Invalid OTP attempt for user {$user->id}");
        return false;
    }

    /**
     * Send OTP via SMS
     */
    public function sendOtp(User $user, string $purpose = 'verification'): bool
    {
        $otp = $this->generateOtp($user, $purpose);
        
        $message = $this->getOtpMessage($otp, $purpose);
        
        return $this->smsService->sendSms($user->mobile, $message);
    }

    /**
     * Get OTP message based on purpose
     */
    protected function getOtpMessage(string $otp, string $purpose): string
    {
        $messages = [
            'verification' => "Your Bangladesh Railway verification OTP is: {$otp}. Valid for 5 minutes.",
            'password_reset' => "Your Bangladesh Railway password reset OTP is: {$otp}. Valid for 5 minutes.",
            'login' => "Your Bangladesh Railway login OTP is: {$otp}. Valid for 5 minutes.",
            'profile_update' => "Your Bangladesh Railway profile update OTP is: {$otp}. Valid for 5 minutes."
        ];
        
        return $messages[$purpose] ?? "Your Bangladesh Railway OTP is: {$otp}. Valid for 5 minutes.";
    }

    /**
     * Check if user can request new OTP (rate limiting)
     */
    public function canRequestOtp(User $user, string $purpose = 'verification'): bool
    {
        $rateLimitKey = "otp_rate_limit:{$user->id}:{$purpose}";
        
        if (Cache::has($rateLimitKey)) {
            return false;
        }
        
        // Allow new OTP request every 60 seconds
        Cache::put($rateLimitKey, true, 60);
        return true;
    }

    /**
     * Clear OTP data for user
     */
    public function clearOtp(User $user, string $purpose = 'verification'): void
    {
        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null
        ]);
        
        $cacheKey = "otp:{$user->id}:{$purpose}";
        Cache::forget($cacheKey);
        
        Log::info("OTP cleared for user {$user->id}");
    }

    /**
     * Get remaining time for OTP expiry
     */
    public function getOtpRemainingTime(User $user): ?int
    {
        if (!$user->otp_expires_at) {
            return null;
        }
        
        $remaining = $user->otp_expires_at->diffInSeconds(now());
        return $remaining > 0 ? $remaining : null;
    }
}
