<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $supportNumbers = [
            'bkash' => '16247',
            'nagad' => '16167',
            'rocket' => '16216',
            'upay' => '16268',
            'visa_mastercard' => 'N/A',
        ];

        return view('contact', compact('supportNumbers'));
    }
}
