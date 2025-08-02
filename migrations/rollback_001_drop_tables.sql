-- Rollback Migration: rollback_001_drop_tables.sql
-- Description: Drop all tables created in migration 001_create_initial_tables.sql
-- Date: Created

-- ======================================
-- Drop all triggers first
-- ======================================
DROP TRIGGER IF EXISTS update_contact_messages_updated_at ON Contact_messages;
DROP TRIGGER IF EXISTS update_payments_updated_at ON Payments;
DROP TRIGGER IF EXISTS update_booking_seats_updated_at ON Booking_seats;
DROP TRIGGER IF EXISTS update_bookings_updated_at ON Bookings;
DROP TRIGGER IF EXISTS update_seats_updated_at ON Seats;
DROP TRIGGER IF EXISTS update_train_classes_updated_at ON Train_classes;
DROP TRIGGER IF EXISTS update_routes_updated_at ON Routes;
DROP TRIGGER IF EXISTS update_stations_updated_at ON Stations;
DROP TRIGGER IF EXISTS update_trains_updated_at ON Trains;
DROP TRIGGER IF EXISTS update_users_updated_at ON Users;

-- ======================================
-- Drop the update function
-- ======================================
DROP FUNCTION IF EXISTS update_updated_at_column();

-- ======================================
-- Drop tables in reverse order of creation (to handle foreign key constraints)
-- ======================================

-- Drop OTP_verifications table
DROP TABLE IF EXISTS OTP_verifications;

-- Drop Contact_messages table
DROP TABLE IF EXISTS Contact_messages;

-- Drop Payments table
DROP TABLE IF EXISTS Payments;

-- Drop Booking_seats table
DROP TABLE IF EXISTS Booking_seats;

-- Drop Bookings table
DROP TABLE IF EXISTS Bookings;

-- Drop Seats table
DROP TABLE IF EXISTS Seats;

-- Drop Train_classes table
DROP TABLE IF EXISTS Train_classes;

-- Drop Routes table
DROP TABLE IF EXISTS Routes;

-- Drop Stations table
DROP TABLE IF EXISTS Stations;

-- Drop Trains table
DROP TABLE IF EXISTS Trains;

-- Drop Users table
DROP TABLE IF EXISTS Users;
