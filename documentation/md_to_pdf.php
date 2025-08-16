<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use Parsedown;

// Read the markdown file
$markdown = file_get_contents(__DIR__ . '/model_documentation.md');

// Convert Markdown to HTML
$parsedown = new Parsedown();
$html = $parsedown->text($markdown);

// Add some basic styling
$styledHtml = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Railway Management System - Model Documentation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 40px;
        }
        h1 {
            color: #333;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        h2 {
            color: #444;
            margin-top: 30px;
        }
        h3 {
            color: #666;
        }
        code {
            background: #f4f4f4;
            padding: 2px 5px;
            font-family: monospace;
        }
        pre {
            background: #f4f4f4;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
        }
    </style>
</head>
<body>' . $html . '</body>
</html>';

// Initialize DOMPDF
$dompdf = new Dompdf();
$dompdf->loadHtml($styledHtml);

// Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render PDF
$dompdf->render();

// Save the PDF
file_put_contents(__DIR__ . '/model_documentation.pdf', $dompdf->output());

echo "PDF has been generated successfully!\n";
