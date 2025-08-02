@extends('layouts.app')

@section('title', 'Search Results - Bangladesh Railway')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Search Summary -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <img src="/placeholder.svg?height=30&width=30&text=Train" alt="Train" class="h-8 w-8">
                        <div class="ml-3">
                            <p class="text-orange-600 font-semibold">{{ $fromStation->name }} - {{ $toStation->name }}</p>
                            <p class="text-sm text-gray-500">{{ $journeyDate->format('d-M-Y') }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('home') }}" class="bg-green-600 text-white px-4 py-2 rounded text-sm font-medium hover:bg-green-700">
                        MODIFY SEARCH
                    </a>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('search.trains') }}?{{ http_build_query(array_merge($request->all(), ['journey_date' => $journeyDate->subDay()->format('Y-m-d')])) }}" 
                           class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-chevron-left"></i> PREV DAY
                        </a>
                        <a href="{{ route('search.trains') }}?{{ http_build_query(array_merge($request->all(), ['journey_date' => $journeyDate->addDays(2)->format('Y-m-d')])) }}" 
                           class="text-orange-600 hover:text-orange-700">
                            NEXT DAY <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Users -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="bg-green-50 border border-green-200 rounded-lg p-3 text-center">
            <p class="text-green-700">Total Active Users on this page: <span class="font-bold">{{ $activeUsersCount ?? rand(10, 50) }}</span></p>
        </div>
    </div>

    @if($availableTrains->isEmpty())
        <!-- No Trains Found -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center mb-8">
                <h3 class="text-lg font-semibold text-blue-800 mb-2">NOT FINDING ANY TICKET FOR YOUR DESIRED ROUTE ?</h3>
                <p class="text-blue-600 mb-4">Try Searching with other routes with the same destination</p>
                
                <div class="space-y-2 mb-4">
                    <div class="bg-white rounded p-2">
                        <span class="text-blue-600">{{ $fromStation->name }} - {{ $toStation->name }}</span>
                    </div>
                </div>
                
                <p class="text-blue-600 mb-4">Or try searching in previous or the next day</p>
                
                <div class="bg-white rounded p-2 inline-block">
                    <span class="text-blue-600">Next Day: {{ $journeyDate->addDay()->format('d/m/Y') }}</span>
                </div>
            </div>

            <!-- Sample Train with No Available Seats -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Train Header -->
                <div class="bg-orange-50 px-6 py-4 border-b">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-orange-800">TURNA (741)</h3>
                            <p class="text-sm text-orange-600">
                                <i class="fas fa-users mr-1"></i>
                                0+ users are trying to book ticket(s)
                            </p>
                        </div>
                        <div class="text-right">
                            <div class="flex items-center space-x-8">
                                <div class="text-center">
                                    <p class="text-sm text-gray-500">{{ $journeyDate->format('d M, H:i') }}</p>
                                    <p class="font-semibold">11:30</p>
                                    <p class="text-sm text-gray-500">{{ $fromStation->name }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-sm text-gray-500">Duration</p>
                                    <p class="text-xs text-gray-400">05h 40m</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-sm text-gray-500">{{ $journeyDate->format('d M, H:i') }}</p>
                                    <p class="font-semibold">05:10</p>
                                    <p class="text-sm text-gray-500">{{ $toStation->name }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-sm text-gray-500">Train</p>
                                    <p class="text-xs text-gray-400">Express</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Train Classes with No Availability -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- S_CHAIR -->
                        <div class="border rounded-lg p-4 bg-red-50 border-red-200">
                            <div class="text-center">
                                <h4 class="font-semibold text-lg">S_CHAIR</h4>
                                <p class="text-2xl font-bold text-green-600">৳405</p>
                                <p class="text-xs text-gray-500">Including VAT</p>
                                
                                <div class="mt-2">
                                    <p class="text-sm">Available Tickets</p>
                                    <p class="text-sm text-red-600">(Counter + Online)</p>
                                    <p class="font-bold text-red-600">0</p>
                                </div>

                                <button disabled class="w-full bg-gray-400 text-white py-2 px-4 rounded font-medium mt-3 cursor-not-allowed">
                                    SOLD OUT
                                </button>
                            </div>
                        </div>

                        <!-- F_BERTH -->
                        <div class="border rounded-lg p-4 bg-red-50 border-red-200">
                            <div class="text-center">
                                <h4 class="font-semibold text-lg">F_BERTH</h4>
                                <p class="text-2xl font-bold text-green-600">৳982</p>
                                <p class="text-xs text-gray-500">Including VAT</p>
                                
                                <div class="mt-2">
                                    <p class="text-sm">Available Tickets</p>
                                    <p class="text-sm text-red-600">(Counter + Online)</p>
                                    <p class="font-bold text-red-600">0</p>
                                </div>

                                <button disabled class="w-full bg-gray-400 text-white py-2 px-4 rounded font-medium mt-3 cursor-not-allowed">
                                    SOLD OUT
                                </button>
                            </div>
                        </div>

                        <!-- AC_B -->
                        <div class="border rounded-lg p-4 bg-red-50 border-red-200">
                            <div class="text-center">
                                <h4 class="font-semibold text-lg">AC_B</h4>
                                <p class="text-2xl font-bold text-green-600">৳1448</p>
                                <p class="text-xs text-gray-500">Including VAT</p>
                                
                                <div class="mt-2">
                                    <p class="text-sm">Available Tickets</p>
                                    <p class="text-sm text-red-600">(Counter + Online)</p>
                                    <p class="font-bold text-red-600">0</p>
                                </div>

                                <button disabled class="w-full bg-gray-400 text-white py-2 px-4 rounded font-medium mt-3 cursor-not-allowed">
                                    SOLD OUT
                                </button>
                            </div>
                        </div>

                        <!-- SNIGDHA -->
                        <div class="border rounded-lg p-4 bg-red-50 border-red-200">
                            <div class="text-center">
                                <h4 class="font-semibold text-lg">SNIGDHA</h4>
                                <p class="text-2xl font-bold text-green-600">৳777</p>
                                <p class="text-xs text-gray-500">Including VAT</p>
                                
                                <div class="mt-2">
                                    <p class="text-sm">Available Tickets</p>
                                    <p class="text-sm text-red-600">(Counter + Online)</p>
                                    <p class="font-bold text-red-600">0</p>
                                </div>

                                <button disabled class="w-full bg-gray-400 text-white py-2 px-4 rounded font-medium mt-3 cursor-not-allowed">
                                    SOLD OUT
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Train Route Info -->
                <div class="bg-gray-50 px-6 py-3 border-t">
                    <p class="text-sm text-blue-600">
                        <i class="fas fa-info-circle mr-1"></i>
                        Departs from {{ $fromStation->name }} on {{ $journeyDate->format('d M') }} at 11:30 PM.
                    </p>
                </div>
            </div>
        </div>
    @else
        <!-- Available Trains -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="space-y-6">
                @foreach($availableTrains as $train)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <!-- Train Header -->
                        <div class="bg-orange-50 px-6 py-4 border-b">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-orange-800">{{ $train->name }} ({{ $train->number }})</h3>
                                    <p class="text-sm text-orange-600">
                                        <i class="fas fa-users mr-1"></i>
                                        {{ $train->trainClasses->sum('active_users') ?? rand(15, 45) }} users are trying to book ticket(s)
                                    </p>
                                </div>
                                <div class="text-right">
                                    @php
                                        $fromRoute = $train->routes->where('station_id', $request->from_station)->first();
                                        $toRoute = $train->routes->where('station_id', $request->to_station)->first();
                                    @endphp
                                    <div class="flex items-center space-x-8">
                                        <div class="text-center">
                                            <p class="text-sm text-gray-500">{{ $journeyDate->format('d M, H:i') }}</p>
                                            <p class="font-semibold">{{ $fromRoute ? $fromRoute->departure_time : 'N/A' }}</p>
                                            <p class="text-sm text-gray-500">{{ $fromStation->name }}</p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-sm text-gray-500">Duration</p>
                                            <p class="text-xs text-gray-400">
                                                @if($fromRoute && $toRoute)
                                                    {{ \Carbon\Carbon::parse($fromRoute->departure_time)->diffForHumans(\Carbon\Carbon::parse($toRoute->arrival_time), true) }}
                                                @else
                                                    N/A
                                                @endif
                                            </p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-sm text-gray-500">{{ $journeyDate->format('d M, H:i') }}</p>
                                            <p class="font-semibold">{{ $toRoute ? $toRoute->arrival_time : 'N/A' }}</p>
                                            <p class="text-sm text-gray-500">{{ $toStation->name }}</p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-sm text-gray-500">Train</p>
                                            <p class="text-xs text-gray-400">{{ ucfirst($train->type) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Train Classes -->
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                @foreach($train->trainClasses as $trainClass)
                                    @if($request->class == '' || $request->class == $trainClass->class_name)
                                        <div class="border rounded-lg p-4 {{ $trainClass->available_seats > 0 ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
                                            <div class="text-center">
                                                <h4 class="font-semibold text-lg">{{ $trainClass->class_name }}</h4>
                                                <p class="text-2xl font-bold text-green-600">৳{{ number_format($trainClass->base_fare) }}</p>
                                                <p class="text-xs text-gray-500">Including VAT</p>
                                                
                                                <div class="mt-2">
                                                    <p class="text-sm">Available Tickets</p>
                                                    <p class="text-sm {{ $trainClass->available_seats > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                        (Counter + Online)
                                                    </p>
                                                    <p class="font-bold {{ $trainClass->available_seats > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                        {{ $trainClass->available_seats }}
                                                    </p>
                                                </div>

                                                @if($trainClass->available_seats > 0)
                                                    <form action="{{ route('booking.select-seats') }}" method="GET" class="mt-3">
                                                        <input type="hidden" name="train_id" value="{{ $train->id }}">
                                                        <input type="hidden" name="from_station_id" value="{{ $request->from_station }}">
                                                        <input type="hidden" name="to_station_id" value="{{ $request->to_station }}">
                                                        <input type="hidden" name="journey_date" value="{{ $request->journey_date }}">
                                                        <input type="hidden" name="class_name" value="{{ $trainClass->class_name }}">
                                                        <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded font-medium hover:bg-green-700">
                                                            BOOK NOW
                                                        </button>
                                                    </form>
                                                @else
                                                    <button disabled class="w-full bg-gray-400 text-white py-2 px-4 rounded font-medium mt-3 cursor-not-allowed">
                                                        SOLD OUT
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Train Route Info -->
                        <div class="bg-gray-50 px-6 py-3 border-t">
                            <p class="text-sm text-blue-600">
                                <i class="fas fa-info-circle mr-1"></i>
                                Departs from {{ $fromRoute ? $train->routes->where('sequence', 1)->first()->station->name : 'Origin' }} on {{ $journeyDate->format('d M') }} at {{ $fromRoute ? $train->routes->where('sequence', 1)->first()->departure_time : 'N/A' }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
