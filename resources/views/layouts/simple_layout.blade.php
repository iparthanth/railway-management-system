<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bangladesh Railway')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f4f8;
            color: #333;
        }
        .navbar {
            background-color: #ffffff;
            padding: 8px 20px;
            border-bottom: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .navbar-brand {
            color: #28a745;
            font-size: 20px;
            font-weight: bold;
            text-decoration: none;
        }
        .navbar-nav {
            display: flex;
            gap: 15px;
            flex-grow: 1;
            justify-content: center;
        }
        .navbar-nav a {
            color: #333;
            text-decoration: none;
            font-weight: 500;
            font-size: 16px;
        }
        .navbar-nav a:hover {
            color: #28a745;
        }
        .user-info {
            color: #333;
            font-weight: 500;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #28a745;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>


    <div class="container">
        @yield('content')
    </div>

</body>
</html>
