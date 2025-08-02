-- Migration: 001_create_initial_tables.sql
-- Description: Create all initial tables for the railway management system
-- Date: Created

-- ======================================
-- Users table
-- ======================================
CREATE TABLE Users (
    id SERIAL PRIMARY KEY,
    NID VARCHAR(50) NOT NULL UNIQUE,
    date_of_birth DATE NOT NULL,
    address TEXT NOT NULL,
    profile_image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Index for NID lookups
CREATE INDEX idx_users_nid ON Users(NID);

-- ======================================
-- Trains table
-- ======================================
CREATE TABLE Trains (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    number VARCHAR(20) UNIQUE NOT NULL,
    type VARCHAR(50) NOT NULL,
    running_days VARCHAR(50) NOT NULL,
    available_classes VARCHAR(100) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Indexes for train lookups
CREATE INDEX idx_trains_number ON Trains(number);
CREATE INDEX idx_trains_is_active ON Trains(is_active);

-- ======================================
-- Stations table
-- ======================================
CREATE TABLE Stations (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(10) UNIQUE NOT NULL,
    location TEXT NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Indexes for station lookups
CREATE INDEX idx_stations_code ON Stations(code);
CREATE INDEX idx_stations_is_active ON Stations(is_active);

-- ======================================
-- Routes table
-- ======================================
CREATE TABLE Routes (
    id SERIAL PRIMARY KEY,
    train_id INT NOT NULL REFERENCES Trains(id) ON DELETE CASCADE,
    station_id INT NOT NULL REFERENCES Stations(id) ON DELETE CASCADE,
    arrival_time TIME,
    departure_time TIME,
    stop_order INT NOT NULL,
    distance_from_origin DECIMAL(10, 2) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Indexes for route lookups
CREATE INDEX idx_routes_train_id ON Routes(train_id);
CREATE INDEX idx_routes_station_id ON Routes(station_id);
CREATE INDEX idx_routes_stop_order ON Routes(train_id, stop_order);

-- Unique constraint to prevent duplicate train-station-stop_order combinations
ALTER TABLE Routes ADD CONSTRAINT unique_train_station_stop_order 
UNIQUE (train_id, station_id, stop_order);

-- ======================================
-- Train_classes table
-- ======================================
CREATE TABLE Train_classes (
    id SERIAL PRIMARY KEY,
    train_id INT NOT NULL REFERENCES Trains(id) ON DELETE CASCADE,
    class_type VARCHAR(50) NOT NULL,
    total_seats INT NOT NULL CHECK (total_seats > 0),
    fare_per_km DECIMAL(10, 2) NOT NULL CHECK (fare_per_km >= 0),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Indexes for train class lookups
CREATE INDEX idx_train_classes_train_id ON Train_classes(train_id);
CREATE INDEX idx_train_classes_class_type ON Train_classes(class_type);

-- Unique constraint to prevent duplicate train-class combinations
ALTER TABLE Train_classes ADD CONSTRAINT unique_train_class 
UNIQUE (train_id, class_type);

-- ======================================
-- Seats table
-- ======================================
CREATE TABLE Seats (
    id SERIAL PRIMARY KEY,
    train_class_id INT NOT NULL REFERENCES Train_classes(id) ON DELETE CASCADE,
    seat_number VARCHAR(10) NOT NULL,
    row INT NOT NULL CHECK (row > 0),
    column VARCHAR(5) NOT NULL,
    is_available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Indexes for seat lookups
CREATE INDEX idx_seats_train_class_id ON Seats(train_class_id);
CREATE INDEX idx_seats_is_available ON Seats(is_available);

-- Unique constraint to prevent duplicate seats in same class
ALTER TABLE Seats ADD CONSTRAINT unique_seat_in_class 
UNIQUE (train_class_id, seat_number);

-- ======================================
-- Bookings table
-- ======================================
CREATE TABLE Bookings (
    id SERIAL PRIMARY KEY,
    user_id INT NOT NULL REFERENCES Users(id) ON DELETE CASCADE,
    train_id INT NOT NULL REFERENCES Trains(id) ON DELETE CASCADE,
    journey_date DATE NOT NULL,
    from_station_id INT NOT NULL REFERENCES Stations(id),
    to_station_id INT NOT NULL REFERENCES Stations(id),
    status VARCHAR(50) NOT NULL DEFAULT 'pending',
    total_fare DECIMAL(10, 2) NOT NULL CHECK (total_fare >= 0),
    payment_status VARCHAR(50) NOT NULL DEFAULT 'unpaid',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Indexes for booking lookups
CREATE INDEX idx_bookings_user_id ON Bookings(user_id);
CREATE INDEX idx_bookings_train_id ON Bookings(train_id);
CREATE INDEX idx_bookings_journey_date ON Bookings(journey_date);
CREATE INDEX idx_bookings_status ON Bookings(status);
CREATE INDEX idx_bookings_payment_status ON Bookings(payment_status);

-- Check constraint to ensure from and to stations are different
ALTER TABLE Bookings ADD CONSTRAINT check_different_stations 
CHECK (from_station_id != to_station_id);

-- ======================================
-- Booking_seats table
-- ======================================
CREATE TABLE Booking_seats (
    id SERIAL PRIMARY KEY,
    booking_id INT NOT NULL REFERENCES Bookings(id) ON DELETE CASCADE,
    seat_id INT NOT NULL REFERENCES Seats(id) ON DELETE CASCADE,
    passenger_name VARCHAR(100) NOT NULL,
    passenger_age INT NOT NULL CHECK (passenger_age > 0 AND passenger_age <= 120),
    passenger_gender VARCHAR(10) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Indexes for booking seat lookups
CREATE INDEX idx_booking_seats_booking_id ON Booking_seats(booking_id);
CREATE INDEX idx_booking_seats_seat_id ON Booking_seats(seat_id);

-- Unique constraint to prevent double booking of same seat for same booking
ALTER TABLE Booking_seats ADD CONSTRAINT unique_booking_seat 
UNIQUE (booking_id, seat_id);

-- ======================================
-- Payments table
-- ======================================
CREATE TABLE Payments (
    id SERIAL PRIMARY KEY,
    booking_id INT NOT NULL REFERENCES Bookings(id) ON DELETE CASCADE,
    payment_method VARCHAR(50) NOT NULL,
    transaction_id VARCHAR(100),
    amount DECIMAL(10, 2) NOT NULL CHECK (amount > 0),
    status VARCHAR(50) NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Indexes for payment lookups
CREATE INDEX idx_payments_booking_id ON Payments(booking_id);
CREATE INDEX idx_payments_transaction_id ON Payments(transaction_id);
CREATE INDEX idx_payments_status ON Payments(status);

-- ======================================
-- Contact_messages table
-- ======================================
CREATE TABLE Contact_messages (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15),
    subject VARCHAR(255),
    message TEXT NOT NULL,
    status VARCHAR(50) DEFAULT 'unread',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Indexes for contact message lookups
CREATE INDEX idx_contact_messages_email ON Contact_messages(email);
CREATE INDEX idx_contact_messages_status ON Contact_messages(status);
CREATE INDEX idx_contact_messages_created_at ON Contact_messages(created_at);

-- ======================================
-- OTP_verifications table
-- ======================================
CREATE TABLE OTP_verifications (
    id SERIAL PRIMARY KEY,
    mobile VARCHAR(15) NOT NULL,
    otp VARCHAR(10) NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    is_used BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Indexes for OTP lookups
CREATE INDEX idx_otp_verifications_mobile ON OTP_verifications(mobile);
CREATE INDEX idx_otp_verifications_expires_at ON OTP_verifications(expires_at);
CREATE INDEX idx_otp_verifications_is_used ON OTP_verifications(is_used);

-- ======================================
-- Additional Constraints and Triggers
-- ======================================

-- Create a function to update the updated_at timestamp
CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ language 'plpgsql';

-- Create triggers for updated_at columns
CREATE TRIGGER update_users_updated_at BEFORE UPDATE ON Users 
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_trains_updated_at BEFORE UPDATE ON Trains 
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_stations_updated_at BEFORE UPDATE ON Stations 
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_routes_updated_at BEFORE UPDATE ON Routes 
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_train_classes_updated_at BEFORE UPDATE ON Train_classes 
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_seats_updated_at BEFORE UPDATE ON Seats 
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_bookings_updated_at BEFORE UPDATE ON Bookings 
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_booking_seats_updated_at BEFORE UPDATE ON Booking_seats 
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_payments_updated_at BEFORE UPDATE ON Payments 
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_contact_messages_updated_at BEFORE UPDATE ON Contact_messages 
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
