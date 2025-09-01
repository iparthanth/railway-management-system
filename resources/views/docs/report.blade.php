<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Railway Management System - Detailed Code Explanation</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color: #222; }
        h1 { font-size: 20px; margin: 0 0 10px; color: #2c7a2c; }
        h2 { font-size: 16px; margin: 18px 0 8px; color: #2c7a2c; }
        h3 { font-size: 14px; margin: 12px 0 6px; }
        .file { margin-bottom: 22px; }
        .code { background: #f8f8f8; border: 1px solid #ddd; padding: 10px; white-space: pre-wrap; word-break: break-word; font-family: Consolas, monospace; font-size: 11px; }
        .explain { background: #fcfffc; border-left: 3px solid #2c7a2c; padding: 8px 10px; margin: 6px 0 14px; }
        .hr { border-top: 1px dashed #aaa; margin: 12px 0; }
        ul { margin: 6px 0 6px 16px; }
        .note { color:#666; font-style: italic; }
    </style>
</head>
<body>
    <h1>Railway Management System - Detailed Code Explanation</h1>
    <div class="note">Each file is broken into small code blocks followed by an explanation of what it does, how it connects to other files/pages, and what it uses from the database. In this demo, no database queries are used; data is generated in the controller for learning. Where a DB would be used in real projects, we mention what would typically be queried.</div>

    <!-- TrainController.php blocks -->
    <div class="file">
        <h2>app/Http/Controllers/TrainController.php</h2>
        @foreach($controllerBlocks as $b)
            <h3>{{ $b['title'] }}</h3>
            <div class="code">{!! nl2br(e($b['code'])) !!}</div>
            <div class="explain">{!! nl2br(e($b['explain'])) !!}</div>
        @endforeach
    </div>

    <!-- home.blade.php blocks -->
    <div class="file">
        <h2>resources/views/home.blade.php</h2>
        @foreach($homeBlocks as $b)
            <h3>{{ $b['title'] }}</h3>
            <div class="code">{!! nl2br(e($b['code'])) !!}</div>
            <div class="explain">{!! nl2br(e($b['explain'])) !!}</div>
        @endforeach
    </div>

    <!-- trains/index.blade.php blocks -->
    <div class="file">
        <h2>resources/views/trains/index.blade.php</h2>
        @foreach($indexBlocks as $b)
            <h3>{{ $b['title'] }}</h3>
            <div class="code">{!! nl2br(e($b['code'])) !!}</div>
            <div class="explain">{!! nl2br(e($b['explain'])) !!}</div>
        @endforeach
    </div>

    <!-- trains/search-results.blade.php blocks -->
    <div class="file">
        <h2>resources/views/trains/search-results.blade.php</h2>
        @foreach($searchBlocks as $b)
            <h3>{{ $b['title'] }}</h3>
            <div class="code">{!! nl2br(e($b['code'])) !!}</div>
            <div class="explain">{!! nl2br(e($b['explain'])) !!}</div>
        @endforeach
    </div>

    <!-- trains/seats.blade.php blocks -->
    <div class="file">
        <h2>resources/views/trains/seats.blade.php</h2>
        @foreach($seatsBlocks as $b)
            <h3>{{ $b['title'] }}</h3>
            <div class="code">{!! nl2br(e($b['code'])) !!}</div>
            <div class="explain">{!! nl2br(e($b['explain'])) !!}</div>
        @endforeach
    </div>
</body>
</html>