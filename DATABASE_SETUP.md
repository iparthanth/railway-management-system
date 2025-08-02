# Railway Management System - Database Setup

This document provides instructions for setting up the database schema for the Railway Management System.

## Database Schema Overview

The railway management system consists of 11 core tables:

### Core Tables

1. **Users** - User information with NID, date of birth, address, and profile image
2. **Trains** - Train details including name, number, type, running days, and available classes
3. **Stations** - Railway station information with codes and locations
4. **Routes** - Train routes with arrival/departure times and distances
5. **Train_classes** - Different classes available on trains with pricing
6. **Seats** - Individual seat information for each train class
7. **Bookings** - Passenger booking records
8. **Booking_seats** - Mapping between bookings and seats with passenger details
9. **Payments** - Payment transaction records
10. **Contact_messages** - Customer support messages
11. **OTP_verifications** - OTP codes for mobile verification

## Files Structure

```
/
├── railway_management_schema.sql          # Basic schema (simple version)
├── migrations/
│   ├── 001_create_initial_tables.sql     # Complete schema with constraints and indexes
│   ├── 002_insert_sample_data.sql        # Sample data for testing
│   └── rollback_001_drop_tables.sql      # Rollback script to drop all tables
└── DATABASE_SETUP.md                     # This file
```

## Installation Instructions

### Option 1: Using the Simple Schema

For a quick setup, run the basic schema:

```sql
-- Run this file in your PostgreSQL database
\i railway_management_schema.sql
```

### Option 2: Using Migration Files (Recommended)

For a production-ready setup with proper constraints, indexes, and triggers:

1. **Create the initial tables:**
   ```sql
   \i migrations/001_create_initial_tables.sql
   ```

2. **Insert sample data (optional):**
   ```sql
   \i migrations/002_insert_sample_data.sql
   ```

3. **To rollback/reset (if needed):**
   ```sql
   \i migrations/rollback_001_drop_tables.sql
   ```

## Database Requirements

- **Database Engine:** PostgreSQL 12+
- **Extensions:** None required (uses built-in functions)
- **Privileges:** CREATE, ALTER, INSERT, UPDATE, DELETE, SELECT

## Key Features Implemented

### 1. Data Integrity
- Foreign key constraints maintain referential integrity
- Check constraints ensure valid data (e.g., positive ages, different source/destination stations)
- Unique constraints prevent duplicate records
- NOT NULL constraints for essential fields

### 2. Performance Optimization
- Strategic indexes on frequently queried columns
- Composite indexes for multi-column searches
- Foreign key indexes for join operations

### 3. Audit Trail
- `created_at` and `updated_at` timestamps on all tables
- Automatic trigger-based timestamp updates
- OTP tracking with expiration and usage status

### 4. Business Logic Constraints
- Prevents booking same seat multiple times
- Ensures different origin and destination stations
- Validates passenger age ranges (1-120 years)
- Enforces positive values for fares and distances

## Sample Data Included

The sample data includes:
- 5 test users with different profiles
- 10 railway stations across Bangladesh
- 10 express trains with different configurations
- Multiple train classes (AC_B, AC_S, S_Chair, Shulov)
- Sample routes for major train connections
- Seat layouts for different classes
- Booking examples with different statuses
- Payment records with various methods
- Contact messages with different statuses
- OTP verification examples

## Database Schema Relationships

```
Users (1) ←→ (M) Bookings (M) ←→ (1) Trains
                ↓
            Booking_seats (M) ←→ (1) Seats (M) ←→ (1) Train_classes (M) ←→ (1) Trains
                ↓
            Payments (M) ←→ (1) Bookings

Routes (M) ←→ (1) Trains
Routes (M) ←→ (1) Stations

Bookings (M) ←→ (1) Stations (from_station)
Bookings (M) ←→ (1) Stations (to_station)
```

## Common Queries Examples

### Find available trains between stations:
```sql
SELECT DISTINCT t.name, t.number, t.type
FROM Trains t
JOIN Routes r1 ON t.id = r1.train_id
JOIN Routes r2 ON t.id = r2.train_id
WHERE r1.station_id = 1 -- From station
  AND r2.station_id = 2 -- To station
  AND r1.stop_order < r2.stop_order
  AND t.is_active = TRUE;
```

### Check seat availability:
```sql
SELECT s.seat_number, s.row, s.column
FROM Seats s
JOIN Train_classes tc ON s.train_class_id = tc.id
WHERE tc.train_id = 1
  AND tc.class_type = 'AC_B'
  AND s.is_available = TRUE;
```

### Get booking details:
```sql
SELECT b.id, u.NID, t.name, t.number,
       fs.name as from_station, ts.name as to_station,
       b.journey_date, b.status, b.total_fare, b.payment_status
FROM Bookings b
JOIN Users u ON b.user_id = u.id
JOIN Trains t ON b.train_id = t.id
JOIN Stations fs ON b.from_station_id = fs.id
JOIN Stations ts ON b.to_station_id = ts.id
WHERE b.id = 1;
```

## Security Considerations

1. **Sensitive Data:** NID numbers and personal information should be encrypted in production
2. **OTP Storage:** OTP codes should be hashed before storage
3. **User Access:** Implement proper role-based access control
4. **Audit Logging:** Consider adding audit tables for sensitive operations
5. **Data Retention:** Implement policies for old booking and OTP data cleanup

## Maintenance Tasks

### Regular Cleanup:
```sql
-- Clean expired OTPs (run daily)
DELETE FROM OTP_verifications 
WHERE expires_at < CURRENT_TIMESTAMP - INTERVAL '1 day';

-- Archive old bookings (run monthly)
-- Move bookings older than 1 year to archive table
```

### Performance Monitoring:
```sql
-- Check table sizes
SELECT schemaname, tablename, 
       pg_total_relation_size(schemaname||'.'||tablename) as size_bytes
FROM pg_tables 
WHERE schemaname = 'public'
ORDER BY size_bytes DESC;

-- Check index usage
SELECT schemaname, tablename, indexname, idx_scan, idx_tup_read, idx_tup_fetch
FROM pg_stat_user_indexes
ORDER BY idx_scan DESC;
```

## Troubleshooting

### Common Issues:

1. **Foreign Key Constraint Errors:**
   - Ensure referenced records exist before inserting
   - Check the order of data insertion

2. **Unique Constraint Violations:**
   - Verify NID, train numbers, station codes are unique
   - Check for duplicate bookings

3. **Check Constraint Failures:**
   - Validate age ranges (1-120)
   - Ensure positive values for fares and distances
   - Verify different origin/destination stations

4. **Migration Issues:**
   - Run rollback script if migration fails midway
   - Check database permissions
   - Verify PostgreSQL version compatibility

For additional support or questions, please refer to the project documentation or contact the development team.
