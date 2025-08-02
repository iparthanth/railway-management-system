<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Exception;

class SmsService
{
    protected $driver;
    
    public function __construct()
    {
        $this->driver = config('services.sms.driver', 'log');
    }

    /**
     * Send SMS message
     */
    public function sendSms(string $mobile, string $message): bool
    {
        try {
            switch ($this->driver) {
                case 'twilio':
                    return $this->sendViaTwilio($mobile, $message);
                case 'local_api':
                    return $this->sendViaLocalApi($mobile, $message);
                case 'log':
                default:
                    return $this->sendViaLog($mobile, $message);
            }
        } catch (Exception $e) {
            Log::error("SMS sending failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send OTP (backward compatibility)
     */
    public function sendOtp($mobile, $otp)
    {
        $message = "Your Bangladesh Railway OTP is: {$otp}. Valid for 5 minutes.";
        return $this->sendSms($mobile, $message);
    }

    /**
     * Send via Twilio
     */
    protected function sendViaTwilio(string $mobile, string $message): bool
    {
        $accountSid = config('services.twilio.account_sid');
        $authToken = config('services.twilio.auth_token');
        $fromNumber = config('services.twilio.from_number');
        
        if (!$accountSid || !$authToken || !$fromNumber) {
            Log::error('Twilio configuration missing');
            return false;
        }
        
        $response = Http::withBasicAuth($accountSid, $authToken)
            ->asForm()
            ->post("https://api.twilio.com/2010-04-01/Accounts/{$accountSid}/Messages.json", [
                'From' => $fromNumber,
                'To' => $this->formatMobileNumber($mobile),
                'Body' => $message
            ]);
        
        if ($response->successful()) {
            Log::info("SMS sent via Twilio to {$mobile}");
            return true;
        }
        
        Log::error("Twilio SMS failed: " . $response->body());
        return false;
    }

    /**
     * Send via local SMS API
     */
    protected function sendViaLocalApi(string $mobile, string $message): bool
    {
        $apiUrl = config('services.sms.api_url');
        $apiKey = config('services.sms.api_key');
        $senderId = config('services.sms.sender_id');
        
        if (!$apiUrl || !$apiKey) {
            Log::error('Local SMS API configuration missing');
            return false;
        }
        
        $response = Http::post($apiUrl, [
            'api_key' => $apiKey,
            'to' => $mobile,
            'message' => $message,
            'sender_id' => $senderId,
            'type' => 'text'
        ]);
        
        if ($response->successful()) {
            $responseData = $response->json();
            if (isset($responseData['status']) && $responseData['status'] === 'success') {
                Log::info("SMS sent via local API to {$mobile}");
                return true;
            }
        }
        
        Log::error("Local SMS API failed: " . $response->body());
        return false;
    }

    /**
     * Send via log (for development)
     */
    protected function sendViaLog(string $mobile, string $message): bool
    {
        Log::info("SMS sent to {$mobile}: {$message}");
        return true;
    }

    /**
     * Format mobile number for international format
     */
    protected function formatMobileNumber(string $mobile): string
    {
        // Remove any non-digit characters
        $mobile = preg_replace('/[^0-9]/', '', $mobile);
        
        // Add country code for Bangladesh if not present
        if (strlen($mobile) === 11 && substr($mobile, 0, 2) === '01') {
            $mobile = '+880' . substr($mobile, 1);
        } elseif (strlen($mobile) === 10 && substr($mobile, 0, 1) === '1') {
            $mobile = '+880' . $mobile;
        } elseif (!str_starts_with($mobile, '+')) {
            $mobile = '+880' . ltrim($mobile, '0');
        }
        
        return $mobile;
    }

    /**
     * Send booking confirmation
     */
    public function sendBookingConfirmation($mobile, $pnr, $trainName, $journeyDate)
    {
        $message = "Booking confirmed! PNR: {$pnr}, Train: {$trainName}, Date: {$journeyDate}. Have a safe journey!";
        return $this->sendSms($mobile, $message);
    }

    /**
     * Send password reset notification
     */
    public function sendPasswordResetNotification(string $mobile): bool
    {
        $message = "Your Bangladesh Railway account password has been reset successfully. If this wasn't you, please contact support immediately.";
        return $this->sendSms($mobile, $message);
    }

    /**
     * Send account verification notification
     */
    public function sendAccountVerificationSuccess(string $mobile): bool
    {
        $message = "Welcome to Bangladesh Railway! Your account has been verified successfully. You can now book tickets online.";
        return $this->sendSms($mobile, $message);
    }
}
