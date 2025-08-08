@extends('layouts.minimal_layout')

@section('title', 'Contact Us - Railway Management System')

@section('content')
    <style>
        .contact-form {
            max-width: 320px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
            font-size: 14px;
        }
        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
        }
        textarea {
            height: 100px;
            resize: vertical;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #28a745;
            color: white;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .back-link {
            text-align: center;
            margin-top: 15px;
        }
        .back-link a {
            color: #28a745;
            text-decoration: none;
            font-size: 14px;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>

    <h1>Contact Us</h1>
    
    <div class="contact-form">
        <p style="text-align: center; margin-bottom: 20px; color: #666; font-size: 14px;">
            Have questions? Fill out the form and we'll get back to you.
        </p>
        
        <form method="POST">
            @csrf
            
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required>
            
            <label for="message">Message:</label>
            <textarea id="message" name="message" placeholder="Your message..." required></textarea>
            
            <input type="submit" value="Send Message">
        </form>
        
        <div class="back-link">
            <a href="{{ route('home') }}">← Back to Home</a>
        </div>
    </div>
@endsection
