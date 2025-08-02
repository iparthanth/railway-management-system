<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'nid_number',
        'date_of_birth',
        'mobile',
        'address',
        'post_code',
        'profile_image',
        'nid_verified',
        'mobile_verified',
        'otp_code',
        'otp_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp_code',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'nid_verified' => 'boolean',
        'mobile_verified' => 'boolean',
        'otp_expires_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function generateOtp()
    {
        $this->otp_code = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        $this->otp_expires_at = now()->addMinutes(5);
        $this->save();
        
        return $this->otp_code;
    }

    public function verifyOtp($code)
    {
        if ($this->otp_code === $code && $this->otp_expires_at > now()) {
            $this->mobile_verified = true;
            $this->otp_code = null;
            $this->otp_expires_at = null;
            $this->save();
            return true;
        }
        return false;
    }

    public function getMaskedMobileAttribute()
    {
        if (!$this->mobile) return null;
        return substr($this->mobile, 0, 3) . ' ** *** ' . substr($this->mobile, -3);
    }

    public function getProfileImageUrlAttribute()
    {
        if (!$this->profile_image) {
            return asset('images/default-avatar.png');
        }
        
        return asset('storage/' . $this->profile_image);
    }

    public function isFullyVerified()
    {
        return $this->mobile_verified && $this->nid_verified;
    }

    public function hasActiveOtp()
    {
        return $this->otp_code && $this->otp_expires_at && $this->otp_expires_at->gt(now());
    }

    public function getOtpRemainingTime()
    {
        if (!$this->hasActiveOtp()) {
            return 0;
        }
        
        return $this->otp_expires_at->diffInSeconds(now());
    }

    public function canRequestNewOtp()
    {
        // Allow new OTP request if no active OTP or if current one is about to expire (< 30 seconds)
        if (!$this->hasActiveOtp()) {
            return true;
        }
        
        return $this->getOtpRemainingTime() < 30;
    }

    public function getFormattedDateOfBirthAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->format('d/m/Y') : null;
    }

    public function getAgeAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }
}
