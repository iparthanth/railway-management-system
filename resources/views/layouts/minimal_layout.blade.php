<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Railway Management System')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f4f8;
            color: #333;
        }
        .container {
            max-width: 360px;
            margin: 0 auto;
            padding: 25px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #28a745;
            text-align: center;
            margin-bottom: 15px;
            font-size: 28px;
        }
    </style>
</head>
<body>

    <div class="container">
        @yield('content')
    </div>

</body>
</html>
