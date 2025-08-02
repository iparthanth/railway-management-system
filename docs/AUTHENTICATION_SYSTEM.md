# Railway Management System - Authentication System

## Overview

This document describes the comprehensive authentication system implemented for the Bangladesh Railway Management System, featuring mobile OTP verification, password reset functionality, remember me capability, and user profile management.

## Features Implemented

### 1. OTP Generation and Verification Service (`OtpService`)

**Location**: `app/Services/OtpService.php`

**Features**:
- 6-digit OTP generation with 5-minute expiry
- Multiple purposes support (verification, password_reset, login, profile_update)
- Rate limiting (60 seconds between requests)
- Attempt tracking (max 3 attempts per OTP)
- Dual storage (database + cache) for enhanced security

**Methods**:
- `generateOtp(User $user, string $purpose)`: Generate OTP for specific purpose
- `verifyOtp(User $user, string $otp, string $purpose)`: Verify OTP with attempt tracking
- `sendOtp(User $user, string $purpose)`: Generate and send OTP via SMS
- `canRequestOtp(User $user, string $purpose)`: Check rate limiting
- `clearOtp(User $user, string $purpose)`: Clear OTP data
- `getOtpRemainingTime(User $user)`: Get remaining expiry time

### 2. Enhanced SMS Service (`SmsService`)

**Location**: `app/Services/SmsService.php`

**Features**:
- Multiple SMS drivers: Log, Twilio, Local API
- International number formatting for Bangladesh (+880)
- Configurable sender ID and API credentials
- Error handling and logging

**Supported Drivers**:
- **Log**: Development mode, logs messages
- **Twilio**: Production SMS via Twilio API
- **Local API**: Custom SMS gateway integration

**Configuration** (in `config/services.php`):
```php
'sms' => [
    'driver' => env('SMS_DRIVER', 'log'),
    'api_url' => env('SMS_API_URL'),
    'api_key' => env('SMS_API_KEY'),
    'sender_id' => env('SMS_SENDER_ID', 'RAILWAY'),
],
'twilio' => [
    'account_sid' => env('TWILIO_ACCOUNT_SID'),
    'auth_token' => env('TWILIO_AUTH_TOKEN'),
    'from_number' => env('TWILIO_FROM_NUMBER'),
],
```

### 3. Enhanced User Model

**Location**: `app/Models/User.php`

**New Fields**:
- `profile_image`: User profile picture path
- `otp_code`: Current OTP code
- `otp_expires_at`: OTP expiration timestamp

**New Methods**:
- `getProfileImageUrlAttribute()`: Get profile image URL with fallback
- `isFullyVerified()`: Check if both mobile and NID are verified
- `hasActiveOtp()`: Check if user has valid unexpired OTP
- `getOtpRemainingTime()`: Get OTP expiry countdown
- `canRequestNewOtp()`: Check if user can request new OTP
- `getFormattedDateOfBirthAttribute()`: Formatted birth date
- `getAgeAttribute()`: Calculate user age

### 4. VerifiedUser Middleware

**Location**: `app/Http/Middleware/VerifiedUser.php`

**Purpose**: Ensure users have verified their mobile number before accessing protected routes

**Features**:
- Redirects unverified users to mobile verification page
- Optional NID verification for sensitive operations (booking, payment)
- Configurable route-based verification requirements

**Usage**:
```php
Route::group(['middleware' => ['auth', 'verified.user']], function () {
    // Protected routes that require verified users
});
```

### 5. Enhanced AuthController

**Location**: `app/Http/Controllers/AuthController.php`

**New Features**:

#### Remember Me Functionality
- Extended session lifetime when "Remember Me" is checked
- Persistent login across browser sessions

#### Password Reset with OTP
- Mobile-based password reset (no email required)
- 6-digit OTP verification
- Secure token-based password reset flow
- SMS notifications for successful reset

**Password Reset Flow**:
1. User enters mobile number
2. OTP sent to mobile
3. User verifies OTP
4. User sets new password
5. SMS confirmation sent

#### Profile Image Upload
- Image validation (JPEG, PNG, GIF, max 2MB)
- Automatic old image cleanup
- Secure storage in `storage/app/public/profile-images`
- Default avatar fallback

#### Mobile Verification
- Mandatory mobile verification for new users
- OTP-based verification process
- Rate limiting and attempt tracking
- Automatic redirect for unverified users

### 6. Database Changes

**Migration**: `database/migrations/2025_08_03_015151_add_profile_image_to_users_table.php`

Added `profile_image` column to users table for storing profile picture paths.

## Authentication Flow

### Registration Flow
1. User enters basic info (name, mobile, NID, DOB)
2. User completes profile (email, address, password)
3. OTP sent to mobile number
4. User verifies OTP
5. Account activated and user logged in

### Login Flow
1. User enters mobile and password
2. Optional "Remember Me" checkbox
3. Authentication attempt
4. If successful, check if mobile is verified
5. Redirect to dashboard or verification page

### Password Reset Flow
1. User clicks "Forgot Password"
2. Enters registered mobile number
3. OTP sent to mobile
4. User verifies OTP
5. User sets new password
6. Confirmation SMS sent
7. Redirect to login

### Mobile Verification Flow
1. Unverified users redirected to verification page
2. OTP sent to mobile number
3. User enters OTP
4. Mobile marked as verified
5. Welcome SMS sent
6. Access to full system granted

## Configuration

### Environment Variables

Add to your `.env` file:

```env
# SMS Configuration
SMS_DRIVER=log
SMS_API_URL=https://your-sms-api.com/send
SMS_API_KEY=your-api-key-here
SMS_SENDER_ID=RAILWAY

# Twilio Configuration (if using Twilio)
TWILIO_ACCOUNT_SID=your-twilio-account-sid
TWILIO_AUTH_TOKEN=your-twilio-auth-token
TWILIO_FROM_NUMBER=+1234567890

# Cache Settings
CACHE_DRIVER=file
CACHE_PREFIX=railway_

# Session Settings
SESSION_LIFETIME=120
SESSION_EXPIRE_ON_CLOSE=false
```

### Storage Setup

Create storage link for profile images:
```bash
php artisan storage:link
```

Create default avatar image at `public/images/default-avatar.png`

## Views Created

1. `resources/views/auth/forgot-password.blade.php` - Password reset request
2. `resources/views/auth/reset-password-otp.blade.php` - OTP verification for password reset
3. `resources/views/auth/new-password.blade.php` - New password form
4. `resources/views/auth/verify-mobile.blade.php` - Mobile verification page

## Routes

Add these routes to your `web.php`:

```php
// Password Reset Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot.password');
Route::post('/forgot-password', [AuthController::class, 'sendPasswordResetOtp'])->name('password.send-otp');
Route::post('/verify-password-reset-otp', [AuthController::class, 'verifyPasswordResetOtp'])->name('password.verify-otp');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');
Route::post('/resend-password-reset-otp', [AuthController::class, 'resendPasswordResetOtp'])->name('password.resend-otp');

// Mobile Verification Routes
Route::middleware('auth')->group(function () {
    Route::get('/verify-mobile', [AuthController::class, 'showVerifyMobile'])->name('auth.verify-mobile');
    Route::post('/send-mobile-otp', [AuthController::class, 'sendMobileVerificationOtp'])->name('auth.send-mobile-otp');
    Route::post('/verify-mobile-otp', [AuthController::class, 'verifyMobileOtp'])->name('auth.verify-mobile-otp');
    Route::post('/resend-mobile-otp', [AuthController::class, 'resendMobileVerificationOtp'])->name('auth.resend-mobile-otp');
    
    // Profile Image Routes
    Route::post('/profile/upload-image', [AuthController::class, 'uploadProfileImage'])->name('profile.upload-image');
    Route::delete('/profile/delete-image', [AuthController::class, 'deleteProfileImage'])->name('profile.delete-image');
});

// Protected Routes (require verified users)
Route::middleware(['auth', 'verified.user'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    // ... other protected routes
});
```

## Security Features

1. **Rate Limiting**: OTP requests limited to 1 per minute
2. **Attempt Tracking**: Maximum 3 OTP verification attempts
3. **Token Validation**: Secure tokens for password reset
4. **Input Validation**: Comprehensive validation rules
5. **CSRF Protection**: All forms protected against CSRF
6. **Image Validation**: Profile images validated for type and size
7. **Mobile Format Validation**: Bangladesh mobile number regex validation

## Error Handling

- User-friendly error messages
- Logging of all authentication events
- Graceful fallback for SMS delivery failures
- Automatic cleanup of expired OTPs

## Testing

To test the system:

1. Set `SMS_DRIVER=log` in `.env`
2. Check Laravel logs for OTP codes
3. Use the logged OTP codes for verification
4. Monitor `storage/logs/laravel.log` for authentication events

## Production Deployment

1. Configure proper SMS gateway (Twilio or local API)
2. Set up proper caching (Redis recommended)
3. Configure file storage for profile images
4. Set up proper session handling
5. Enable HTTPS for security
6. Set up proper backup for user data

## Troubleshooting

### OTP Not Received
1. Check SMS driver configuration
2. Verify API credentials
3. Check Laravel logs for errors
4. Ensure mobile number format is correct

### Image Upload Issues
1. Verify storage link exists
2. Check file permissions
3. Ensure `storage/app/public` is writable
4. Verify image validation rules

### Session Issues
1. Check session driver configuration
2. Verify session lifetime settings
3. Clear session storage if needed
4. Check CSRF token validity

This comprehensive authentication system provides a secure, user-friendly experience while meeting all the requirements for mobile OTP verification, password reset, and profile management.
