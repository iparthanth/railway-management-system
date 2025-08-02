<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function index()
    {
        return Station::all();
    }

    public function search(Request $request)
    {
        return Station::where('name', 'like', "%{$request->query('q')}%")
            ->orWhere('code', 'like', "%{$request->query('q')}%")
            ->get();
    }
}
