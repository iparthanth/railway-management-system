-- Create Users table
CREATE TABLE Users (
    id SERIAL PRIMARY KEY,
    NID VARCHAR(50) NOT NULL,
    date_of_birth DATE NOT NULL,
    address TEXT NOT NULL,
    profile_image VARCHAR(255)
);

-- Create Trains table
CREATE TABLE Trains (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    number VARCHAR(20) UNIQUE NOT NULL,
    type VARCHAR(50) NOT NULL,
    running_days VARCHAR(50) NOT NULL,
    available_classes VARCHAR(100) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE
);

-- Create Stations table
CREATE TABLE Stations (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(10) UNIQUE NOT NULL,
    location TEXT NOT NULL,
    is_active BOOLEAN DEFAULT TRUE
);

-- Create Routes table
CREATE TABLE Routes (
    id SERIAL PRIMARY KEY,
    train_id INT REFERENCES Trains(id),
    station_id INT REFERENCES Stations(id),
    arrival_time TIME,
    departure_time TIME,
    stop_order INT,
    distance_from_origin DECIMAL(10, 2)
);

-- Create Train_classes table
CREATE TABLE Train_classes (
    id SERIAL PRIMARY KEY,
    train_id INT REFERENCES Trains(id),
    class_type VARCHAR(50) NOT NULL,
    total_seats INT NOT NULL,
    fare_per_km DECIMAL(10, 2) NOT NULL
);

-- Create Seats table
CREATE TABLE Seats (
    id SERIAL PRIMARY KEY,
    train_class_id INT REFERENCES Train_classes(id),
    seat_number VARCHAR(10) NOT NULL,
    row INT NOT NULL,
    column VARCHAR(5) NOT NULL,
    is_available BOOLEAN DEFAULT TRUE
);

-- Create Bookings table
CREATE TABLE Bookings (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES Users(id),
    train_id INT REFERENCES Trains(id),
    journey_date DATE NOT NULL,
    from_station_id INT REFERENCES Stations(id),
    to_station_id INT REFERENCES Stations(id),
    status VARCHAR(50) NOT NULL,
    total_fare DECIMAL(10, 2) NOT NULL,
    payment_status VARCHAR(50) NOT NULL
);

-- Create Booking_seats table
CREATE TABLE Booking_seats (
    id SERIAL PRIMARY KEY,
    booking_id INT REFERENCES Bookings(id),
    seat_id INT REFERENCES Seats(id),
    passenger_name VARCHAR(100) NOT NULL,
    passenger_age INT NOT NULL,
    passenger_gender VARCHAR(10) NOT NULL
);

-- Create Payments table
CREATE TABLE Payments (
    id SERIAL PRIMARY KEY,
    booking_id INT REFERENCES Bookings(id),
    payment_method VARCHAR(50) NOT NULL,
    transaction_id VARCHAR(100),
    amount DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50) NOT NULL
);

-- Create Contact_messages table
CREATE TABLE Contact_messages (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15),
    subject VARCHAR(255),
    message TEXT NOT NULL,
    status VARCHAR(50)
);

-- Create OTP_verifications table
CREATE TABLE OTP_verifications (
    id SERIAL PRIMARY KEY,
    mobile VARCHAR(15) NOT NULL,
    otp VARCHAR(10) NOT NULL,
    expires_at TIMESTAMP NOT NULL
);
