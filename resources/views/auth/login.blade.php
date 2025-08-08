<html>
<head>
    <title>Login - Railway System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-box {
            background-color: white;
            border: 1px solid #ddd;
            padding: 30px;
            width: 350px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1, h2 {
            text-align: center;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #5cb85c;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #4cae4c;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
        a {
            color: #5cb85c;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>
        
        @if ($errors->any())
            <p class="error">The provided credentials do not match our records.</p>
        @endif
        
        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            
            <input type="submit" value="Login">
            
        </form>
        
    </div>
</body>
</html>
