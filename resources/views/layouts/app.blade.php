<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Railway Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-200">
    <nav class="bg-white shadow mb-4">
        <div class="container mx-auto p-4">
            <a href="/" class="text-green-700 font-bold">Railway Management System</a>
        </div>
    </nav>
    <div class="container mx-auto p-4 bg-white shadow">
        @yield('content')
    </div>
</body>
</html>

