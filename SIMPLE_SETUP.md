# Simple Railway Management System - For Beginners

This is a **very simple** Laravel project for learning purposes. No complex Models, Seeders, or database relationships.

## What's Inside:

### ✅ **Simple Files:**
- **Routes:** `routes/web.php` - Just basic routes, no complex controllers
- **Views:** Simple HTML pages with basic PHP
- **Database:** Basic user table only (for login)
- **Authentication:** Simple login/logout

### ✅ **Pages:**
1. **Login Page:** `login` → Login with demo account: `partha@gmail.com` / `partha`
2. **Home Page:** Search form with static options
3. **Search Results:** Shows 3 static trains (no database)
4. **Booking Page:** Simple form (no real database storage)  
5. **Payment Page:** Success message (no real payment)

### ✅ **How It Works:**
- **No Complex Models** - Just User model for login
- **No Seeders** - Just one demo user created automatically
- **No Database Relations** - Very simple
- **Static Data** - Train info is just HTML, not from database

### ✅ **File Structure:**
```
├── routes/web.php              # Simple routes
├── resources/views/
│   ├── home.blade.php         # Homepage with search form
│   ├── search-results.blade.php  # Static train results
│   ├── booking/create.blade.php   # Simple booking form
│   ├── booking/payment.blade.php  # Success message
│   └── auth/login.blade.php   # Login form
├── app/Http/Controllers/
│   └── AuthController.php     # Only login/logout
└── database/migrations/       # Only user table
```

### ✅ **Features:**
- ✅ User login/logout (demo user included)
- ✅ Train search (static results)
- ✅ Booking form (just frontend)
- ✅ Payment success page
- ❌ No user registration needed
- ❌ No seeders needed
- ❌ No complex relationships
- ❌ No real payment processing

### ✅ **For Students:**
This is perfect for learning:
- Basic Laravel routes
- Simple Blade templates  
- Form handling
- Basic authentication
- HTML/CSS styling

**No advanced Laravel concepts** - just the basics your teacher wants to show!

### 🚀 **How to Use:**
1. **Login:** Use the demo account: `partha@gmail.com` / `partha`
2. **If demo user doesn't exist:** Visit `/create-demo-user` to create it
3. **Then login:** Go to `/login` and enter the credentials

**Super simple** - just login with the demo user and start exploring!
