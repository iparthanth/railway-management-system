-- Migration: 002_insert_sample_data.sql
-- Description: Insert sample data for testing the railway management system
-- Date: Created

-- ======================================
-- Sample Users
-- ======================================
INSERT INTO Users (NID, date_of_birth, address, profile_image) VALUES
('1234567890123', '1990-05-15', '123 Main Street, Dhaka, Bangladesh', 'profiles/user1.jpg'),
('2345678901234', '1985-10-22', '456 Park Avenue, Chittagong, Bangladesh', 'profiles/user2.jpg'),
('3456789012345', '1992-12-08', '789 Lake Road, Sylhet, Bangladesh', 'profiles/user3.jpg'),
('4567890123456', '1988-07-30', '321 Hill View, Rajshahi, Bangladesh', 'profiles/user4.jpg'),
('5678901234567', '1995-03-18', '654 Beach Road, Coxs Bazar, Bangladesh', 'profiles/user5.jpg');

-- ======================================
-- Sample Stations
-- ======================================
INSERT INTO Stations (name, code, location, is_active) VALUES
('Dhaka Kamalapur', 'DK', 'Kamalapur, Dhaka', TRUE),
('Chittagong', 'CTG', 'Chittagong Railway Station', TRUE),
('Sylhet', 'SYL', 'Sylhet Railway Station', TRUE),
('Rajshahi', 'RAJ', 'Rajshahi Railway Station', TRUE),
('Comilla', 'COM', 'Comilla Railway Station', TRUE),
('Mymensingh', 'MYM', 'Mymensingh Railway Station', TRUE),
('Rangpur', 'RNG', 'Rangpur Railway Station', TRUE),
('Jessore', 'JES', 'Jessore Railway Station', TRUE),
('Bogura', 'BOG', 'Bogura Railway Station', TRUE),
('Dinajpur', 'DIN', 'Dinajpur Railway Station', TRUE);

-- ======================================
-- Sample Trains
-- ======================================
INSERT INTO Trains (name, number, type, running_days, available_classes, is_active) VALUES
('Sonar Bangla Express', '1', 'Express', 'Daily', 'AC_B,AC_S,S_Chair,Shulov', TRUE),
('Chitra Express', '2', 'Express', 'Daily', 'AC_B,AC_S,S_Chair,Shulov', TRUE),
('Parabat Express', '3', 'Express', 'Daily', 'AC_S,S_Chair,Shulov', TRUE),
('Titumir Express', '4', 'Express', 'Daily', 'S_Chair,Shulov', TRUE),
('Upaban Express', '5', 'Express', 'Daily', 'AC_B,AC_S,S_Chair', TRUE),
('Rangpur Express', '6', 'Express', 'Daily', 'AC_S,S_Chair,Shulov', TRUE),
('Silk City Express', '7', 'Express', 'Daily', 'AC_B,AC_S,S_Chair,Shulov', TRUE),
('Padma Express', '8', 'Express', 'Daily', 'S_Chair,Shulov', TRUE),
('Sundarban Express', '9', 'Express', 'Daily', 'AC_S,S_Chair,Shulov', TRUE),
('Drutojan Express', '10', 'Express', 'Daily', 'AC_B,AC_S,S_Chair,Shulov', TRUE);

-- ======================================
-- Sample Train Classes
-- ======================================
-- Sonar Bangla Express classes
INSERT INTO Train_classes (train_id, class_type, total_seats, fare_per_km) VALUES
(1, 'AC_B', 48, 3.50),
(1, 'AC_S', 72, 2.80),
(1, 'S_Chair', 96, 1.50),
(1, 'Shulov', 120, 0.80);

-- Chitra Express classes
INSERT INTO Train_classes (train_id, class_type, total_seats, fare_per_km) VALUES
(2, 'AC_B', 48, 3.50),
(2, 'AC_S', 72, 2.80),
(2, 'S_Chair', 96, 1.50),
(2, 'Shulov', 120, 0.80);

-- Parabat Express classes
INSERT INTO Train_classes (train_id, class_type, total_seats, fare_per_km) VALUES
(3, 'AC_S', 72, 2.80),
(3, 'S_Chair', 96, 1.50),
(3, 'Shulov', 120, 0.80);

-- Titumir Express classes
INSERT INTO Train_classes (train_id, class_type, total_seats, fare_per_km) VALUES
(4, 'S_Chair', 96, 1.50),
(4, 'Shulov', 120, 0.80);

-- Upaban Express classes
INSERT INTO Train_classes (train_id, class_type, total_seats, fare_per_km) VALUES
(5, 'AC_B', 48, 3.50),
(5, 'AC_S', 72, 2.80),
(5, 'S_Chair', 96, 1.50);

-- ======================================
-- Sample Routes (Dhaka to Chittagong route for Sonar Bangla Express)
-- ======================================
INSERT INTO Routes (train_id, station_id, arrival_time, departure_time, stop_order, distance_from_origin) VALUES
(1, 1, NULL, '06:00:00', 1, 0),        -- Dhaka Kamalapur (departure only)
(1, 5, '08:30:00', '08:35:00', 2, 97), -- Comilla
(1, 2, '11:00:00', NULL, 3, 264);      -- Chittagong (arrival only)

-- Chitra Express (Dhaka to Rajshahi)
INSERT INTO Routes (train_id, station_id, arrival_time, departure_time, stop_order, distance_from_origin) VALUES
(2, 1, NULL, '14:00:00', 1, 0),        -- Dhaka Kamalapur
(2, 9, '17:30:00', '17:35:00', 2, 182), -- Bogura
(2, 4, '19:00:00', NULL, 3, 256);      -- Rajshahi

-- Parabat Express (Dhaka to Sylhet)
INSERT INTO Routes (train_id, station_id, arrival_time, departure_time, stop_order, distance_from_origin) VALUES
(3, 1, NULL, '22:00:00', 1, 0),        -- Dhaka Kamalapur
(3, 3, '05:30:00', NULL, 2, 308);      -- Sylhet

-- ======================================
-- Sample Seats for Sonar Bangla Express AC_B class
-- ======================================
INSERT INTO Seats (train_class_id, seat_number, row, column, is_available) VALUES
-- AC_B class seats (train_class_id = 1)
(1, 'A1', 1, 'A', TRUE),
(1, 'A2', 1, 'B', TRUE),
(1, 'A3', 1, 'C', TRUE),
(1, 'A4', 1, 'D', TRUE),
(1, 'B1', 2, 'A', TRUE),
(1, 'B2', 2, 'B', TRUE),
(1, 'B3', 2, 'C', TRUE),
(1, 'B4', 2, 'D', TRUE),
(1, 'C1', 3, 'A', TRUE),
(1, 'C2', 3, 'B', TRUE),
(1, 'C3', 3, 'C', TRUE),
(1, 'C4', 3, 'D', TRUE),
(1, 'D1', 4, 'A', TRUE),
(1, 'D2', 4, 'B', TRUE),
(1, 'D3', 4, 'C', TRUE),
(1, 'D4', 4, 'D', TRUE);

-- AC_S class seats (train_class_id = 2)
INSERT INTO Seats (train_class_id, seat_number, row, column, is_available) VALUES
(2, 'A1', 1, 'A', TRUE),
(2, 'A2', 1, 'B', TRUE),
(2, 'A3', 1, 'C', TRUE),
(2, 'B1', 2, 'A', TRUE),
(2, 'B2', 2, 'B', TRUE),
(2, 'B3', 2, 'C', TRUE),
(2, 'C1', 3, 'A', TRUE),
(2, 'C2', 3, 'B', TRUE),
(2, 'C3', 3, 'C', TRUE),
(2, 'D1', 4, 'A', TRUE),
(2, 'D2', 4, 'B', TRUE),
(2, 'D3', 4, 'C', TRUE);

-- ======================================
-- Sample Bookings
-- ======================================
INSERT INTO Bookings (user_id, train_id, journey_date, from_station_id, to_station_id, status, total_fare, payment_status) VALUES
(1, 1, '2024-02-15', 1, 2, 'confirmed', 924.00, 'paid'),
(2, 1, '2024-02-16', 1, 5, 'confirmed', 339.50, 'paid'),
(3, 2, '2024-02-17', 1, 4, 'pending', 384.00, 'unpaid'),
(4, 3, '2024-02-18', 1, 3, 'confirmed', 862.40, 'paid'),
(5, 1, '2024-02-19', 5, 2, 'cancelled', 585.50, 'refunded');

-- ======================================
-- Sample Booking Seats
-- ======================================
INSERT INTO Booking_seats (booking_id, seat_id, passenger_name, passenger_age, passenger_gender) VALUES
(1, 1, 'John Doe', 32, 'Male'),
(1, 2, 'Jane Doe', 28, 'Female'),
(2, 13, 'Alice Smith', 45, 'Female'),
(4, 17, 'Bob Johnson', 38, 'Male'),
(4, 18, 'Carol Johnson', 35, 'Female');

-- ======================================
-- Sample Payments
-- ======================================
INSERT INTO Payments (booking_id, payment_method, transaction_id, amount, status) VALUES
(1, 'Credit Card', 'TXN001234567', 924.00, 'completed'),
(2, 'bKash', 'BKS987654321', 339.50, 'completed'),
(4, 'Nagad', 'NGD456789123', 862.40, 'completed'),
(5, 'Credit Card', 'TXN555666777', 585.50, 'refunded');

-- ======================================
-- Sample Contact Messages
-- ======================================
INSERT INTO Contact_messages (name, email, phone, subject, message, status) VALUES
('Rahman Ahmed', 'rahman@email.com', '+8801712345678', 'Booking Issue', 'I am having trouble booking my ticket online. Please help.', 'unread'),
('Fatima Khan', 'fatima.khan@email.com', '+8801823456789', 'Train Schedule', 'Could you please provide the updated schedule for Dhaka to Sylhet trains?', 'read'),
('Mohammad Ali', 'mohammad.ali@email.com', '+8801934567890', 'Refund Request', 'I need to cancel my booking and request a refund for booking ID 12345.', 'replied'),
('Rashida Begum', 'rashida@email.com', '+8801645678901', 'Seat Availability', 'Are there any AC seats available for tomorrow on Sonar Bangla Express?', 'unread'),
('Karim Hassan', 'karim.hassan@email.com', '+8801756789012', 'Technical Issue', 'The mobile app is not working properly. It crashes when I try to search for trains.', 'in_progress');

-- ======================================
-- Sample OTP Verifications
-- ======================================
INSERT INTO OTP_verifications (mobile, otp, expires_at, is_used) VALUES
('+8801712345678', '123456', '2024-02-01 10:30:00', TRUE),
('+8801823456789', '789012', '2024-02-01 11:15:00', TRUE),
('+8801934567890', '345678', '2024-02-01 14:45:00', FALSE),
('+8801645678901', '901234', '2024-02-01 16:20:00', FALSE),
('+8801756789012', '567890', '2024-02-01 18:10:00', TRUE);
