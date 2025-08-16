# Railway Management System - Model Documentation

## 1. Station Model

### Migration (2024_01_01_000001_create_stations_table.php)
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStationsTable extends Migration
{
    public function up(): void
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 10)->unique();
            $table->string('city');
            $table->string('state');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stations');
    }
}
```

### Factory (StationFactory.php)
```php
<?php

namespace Database\Factories;

use App\Models\Station;
use Illuminate\Database\Eloquent\Factories\Factory;

class StationFactory extends Factory
{
    protected $model = Station::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->city(),
            'code' => strtoupper($this->faker->unique()->lexify('???')),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
        ];
    }
}
```

### Seeder (StationSeeder.php)
```php
<?php

namespace Database\Seeders;

use App\Models\Station;
use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
{
    public function run(): void
    {
        $stations = [
            ['name' => 'Dhaka', 'code' => 'DHK', 'city' => 'Dhaka', 'state' => 'Bangladesh'],
            ['name' => 'Chittagong', 'code' => 'CTG', 'city' => 'Chittagong', 'state' => 'Bangladesh'],
            ['name' => 'Sylhet', 'code' => 'SYL', 'city' => 'Sylhet', 'state' => 'Bangladesh'],
            ['name' => 'Rajshahi', 'code' => 'RAJ', 'city' => 'Rajshahi', 'state' => 'Bangladesh'],
            ['name' => 'Khulna', 'code' => 'KHL', 'city' => 'Khulna', 'state' => 'Bangladesh'],
            ['name' => 'Barisal', 'code' => 'BAR', 'city' => 'Barisal', 'state' => 'Bangladesh'],
            ['name' => 'Tangail', 'code' => 'TAN', 'city' => 'Tangail', 'state' => 'Bangladesh'],
        ];

        foreach ($stations as $station) {
            Station::create($station);
        }
    }
}
```

### Model (Station.php)
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'city',
        'state'
    ];

    public function departureRoutes()
    {
        return $this->hasMany(Route::class, 'from_station_id');
    }

    public function arrivalRoutes()
    {
        return $this->hasMany(Route::class, 'to_station_id');
    }
}
```

## 2. Train Model

### Migration (2024_01_01_000002_create_trains_table.php)
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainsTable extends Migration
{
    public function up(): void
    {
        Schema::create('trains', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('number')->unique();
            $table->enum('type', ['express', 'local', 'intercity', 'mail']);
            $table->integer('total_coaches');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trains');
    }
}
```

### Factory (TrainFactory.php)
```php
<?php

namespace Database\Factories;

use App\Models\Train;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrainFactory extends Factory
{
    protected $model = Train::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(2, true) . ' Express',
            'number' => $this->faker->unique()->numerify('####'),
            'type' => $this->faker->randomElement(['express', 'local', 'intercity', 'mail']),
            'total_coaches' => $this->faker->numberBetween(8, 16),
        ];
    }
}
```

### Seeder (TrainSeeder.php)
```php
<?php

namespace Database\Seeders;

use App\Models\Train;
use Illuminate\Database\Seeder;

class TrainSeeder extends Seeder
{
    public function run(): void
    {
        $trains = [
            ['name' => 'Suborno Express', 'number' => '701', 'type' => 'express', 'total_coaches' => 12],
            ['name' => 'Padma Express', 'number' => '759', 'type' => 'express', 'total_coaches' => 10],
            ['name' => 'Meghna Express', 'number' => '720', 'type' => 'express', 'total_coaches' => 14],
            ['name' => 'Jamuna Express', 'number' => '142', 'type' => 'intercity', 'total_coaches' => 8],
            ['name' => 'Karnaphuli Express', 'number' => '320', 'type' => 'express', 'total_coaches' => 11],
            ['name' => 'Surma Express', 'number' => '246', 'type' => 'mail', 'total_coaches' => 9],
        ];

        foreach ($trains as $train) {
            Train::create($train);
        }
    }
}
```

### Model (Train.php)
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'number',
        'type',
        'total_coaches'
    ];

    public function routes()
    {
        return $this->hasMany(Route::class);
    }

    public function coaches()
    {
        return $this->hasMany(Coach::class);
    }
}
```

## 3. Coach Model

### Migration (2024_01_01_000004_create_coaches_table.php)
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoachesTable extends Migration
{
    public function up(): void
    {
        Schema::create('coaches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('train_id')->constrained()->onDelete('cascade');
            $table->string('coach_number');
            $table->enum('coach_type', ['economy', 'business', 'first_class', 'sleeper']);
            $table->integer('total_seats');
            $table->decimal('price_multiplier', 3, 2)->default(1.00);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coaches');
    }
}
```

### Factory (CoachFactory.php)
```php
<?php

namespace Database\Factories;

use App\Models\Coach;
use Illuminate\Database\Eloquent\Factories\Factory;

class CoachFactory extends Factory
{
    protected $model = Coach::class;

    public function definition(): array
    {
        return [
            'train_id' => \App\Models\Train::factory(),
            'coach_number' => $this->faker->unique()->bothify('C#'),
            'coach_type' => $this->faker->randomElement(['economy', 'business', 'first_class', 'sleeper']),
            'total_seats' => $this->faker->numberBetween(30, 80),
            'price_multiplier' => $this->faker->randomFloat(2, 1, 3),
        ];
    }
}
```

### Seeder (CoachSeeder.php)
```php
<?php

namespace Database\Seeders;

use App\Models\Coach;
use Illuminate\Database\Seeder;

class CoachSeeder extends Seeder
{
    public function run(): void
    {
        $coaches = [
            ['train_id' => 1, 'coach_number' => 'C1', 'coach_type' => 'business', 'total_seats' => 24, 'price_multiplier' => 2.5],
            ['train_id' => 1, 'coach_number' => 'C2', 'coach_type' => 'first_class', 'total_seats' => 52, 'price_multiplier' => 1.5],
            ['train_id' => 2, 'coach_number' => 'C1', 'coach_type' => 'business', 'total_seats' => 60, 'price_multiplier' => 1.2],
            ['train_id' => 2, 'coach_number' => 'C2', 'coach_type' => 'economy', 'total_seats' => 80, 'price_multiplier' => 1.0],
            ['train_id' => 3, 'coach_number' => 'C1', 'coach_type' => 'business', 'total_seats' => 48, 'price_multiplier' => 2.0],
            ['train_id' => 3, 'coach_number' => 'C2', 'coach_type' => 'first_class', 'total_seats' => 32, 'price_multiplier' => 1.8],
            ['train_id' => 4, 'coach_number' => 'C1', 'coach_type' => 'business', 'total_seats' => 60, 'price_multiplier' => 1.2],
            ['train_id' => 5, 'coach_number' => 'C1', 'coach_type' => 'economy', 'total_seats' => 80, 'price_multiplier' => 1.0],
        ];

        foreach ($coaches as $coach) {
            Coach::create($coach);
        }
    }
}
```

### Model (Coach.php)
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    use HasFactory;

    protected $fillable = [
        'train_id',
        'coach_number',
        'coach_type',
        'total_seats',
        'price_multiplier'
    ];

    public function train()
    {
        return $this->belongsTo(Train::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
}
```

## 4. Route Model

### Migration (2024_01_01_000003_create_routes_table.php)
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('train_id')->constrained()->onDelete('cascade');
            $table->foreignId('from_station_id')->constrained('stations')->onDelete('cascade');
            $table->foreignId('to_station_id')->constrained('stations')->onDelete('cascade');
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->integer('duration_minutes');
            $table->decimal('distance_km', 8, 2);
            $table->decimal('base_price', 10, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
}
```

### Factory (RouteFactory.php)
```php
<?php

namespace Database\Factories;

use App\Models\Route;
use Illuminate\Database\Eloquent\Factories\Factory;

class RouteFactory extends Factory
{
    protected $model = Route::class;

    public function definition(): array
    {
        return [
            'train_id' => \App\Models\Train::factory(),
            'from_station_id' => \App\Models\Station::factory(),
            'to_station_id' => \App\Models\Station::factory(),
            'departure_time' => $this->faker->time(),
            'arrival_time' => $this->faker->time(),
            'duration_minutes' => $this->faker->numberBetween(60, 480),
            'distance_km' => $this->faker->numberBetween(100, 1000),
            'base_price' => $this->faker->numberBetween(300, 2000),
            'is_active' => true,
        ];
    }
}
```

### Seeder (RouteSeeder.php)
```php
<?php

namespace Database\Seeders;

use App\Models\Route;
use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    public function run(): void
    {
        $routes = [
            [
                'train_id' => 1,
                'from_station_id' => 1,
                'to_station_id' => 2,
                'departure_time' => '07:30:00',
                'arrival_time' => '13:00:00',
                'duration_minutes' => 330,
                'distance_km' => 264,
                'base_price' => 500,
                'is_active' => true,
            ],
            [
                'train_id' => 2,
                'from_station_id' => 1,
                'to_station_id' => 3,
                'departure_time' => '08:00:00',
                'arrival_time' => '12:15:00',
                'duration_minutes' => 255,
                'distance_km' => 198,
                'base_price' => 400,
                'is_active' => true,
            ],
            [
                'train_id' => 3,
                'from_station_id' => 1,
                'to_station_id' => 4,
                'departure_time' => '09:00:00',
                'arrival_time' => '14:00:00',
                'duration_minutes' => 300,
                'distance_km' => 256,
                'base_price' => 450,
                'is_active' => true,
            ],
        ];

        foreach ($routes as $route) {
            Route::create($route);
        }
    }
}
```

### Model (Route.php)
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'train_id',
        'from_station_id',
        'to_station_id',
        'departure_time',
        'arrival_time',
        'duration_minutes',
        'distance_km',
        'base_price',
        'is_active'
    ];

    public function train()
    {
        return $this->belongsTo(Train::class);
    }

    public function fromStation()
    {
        return $this->belongsTo(Station::class, 'from_station_id');
    }

    public function toStation()
    {
        return $this->belongsTo(Station::class, 'to_station_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
```

## 5. Booking Model

### Migration (2024_01_01_000006_create_bookings_table.php)
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_reference')->unique();
            $table->foreignId('train_id')->constrained()->onDelete('cascade');
            $table->foreignId('route_id')->constrained()->onDelete('cascade');
            $table->foreignId('coach_id')->constrained()->onDelete('cascade');
            $table->date('journey_date');
            $table->string('passenger_name');
            $table->string('passenger_email');
            $table->string('passenger_phone');
            $table->integer('passenger_count');
            $table->decimal('total_amount', 10, 2);
            $table->enum('booking_status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
}
```

### Factory (BookingFactory.php)
```php
<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        return [
            'booking_reference' => 'BK' . $this->faker->unique()->numerify('######'),
            'train_id' => \App\Models\Train::factory(),
            'route_id' => \App\Models\Route::factory(),
            'coach_id' => \App\Models\Coach::factory(),
            'journey_date' => $this->faker->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'passenger_name' => $this->faker->name(),
            'passenger_email' => $this->faker->email(),
            'passenger_phone' => $this->faker->numerify('###########'),
            'passenger_count' => $this->faker->numberBetween(1, 4),
            'total_amount' => $this->faker->numberBetween(500, 2000),
            'booking_status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'failed', 'refunded']),
        ];
    }
}
```

### Seeder (BookingSeeder.php)
```php
<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $bookings = [
            [
                'booking_reference' => 'BK001',
                'train_id' => 1,
                'route_id' => 1,
                'coach_id' => 1,
                'journey_date' => '2024-02-15',
                'passenger_name' => 'Ahmed Hassan',
                'passenger_email' => 'ahmed@example.com',
                'passenger_phone' => '01712345678',
                'passenger_count' => 2,
                'total_amount' => 1000.00,
                'booking_status' => 'confirmed',
                'payment_status' => 'paid',
            ],
            // Add more sample bookings here
        ];

        foreach ($bookings as $booking) {
            Booking::create($booking);
        }
    }
}
```

### Model (Booking.php)
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_reference',
        'train_id',
        'route_id',
        'coach_id',
        'journey_date',
        'passenger_name',
        'passenger_email',
        'passenger_phone',
        'passenger_count',
        'total_amount',
        'booking_status',
        'payment_status'
    ];

    public function train()
    {
        return $this->belongsTo(Train::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function bookingSeats()
    {
        return $this->hasMany(BookingSeat::class);
    }
}
```

## 6. BookingSeat Model

### Migration (2024_01_01_000007_create_booking_seats_table.php)
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingSeatsTable extends Migration
{
    public function up(): void
    {
        Schema::create('booking_seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('seat_id')->constrained()->onDelete('cascade');
            $table->string('passenger_name');
            $table->integer('passenger_age');
            $table->enum('passenger_gender', ['male', 'female', 'other']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_seats');
    }
}
```

### Factory (BookingSeatFactory.php)
```php
<?php

namespace Database\Factories;

use App\Models\BookingSeat;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingSeatFactory extends Factory
{
    protected $model = BookingSeat::class;

    public function definition(): array
    {
        return [
            'booking_id' => \App\Models\Booking::factory(),
            'seat_id' => \App\Models\Seat::factory(),
            'passenger_name' => $this->faker->name(),
            'passenger_age' => $this->faker->numberBetween(1, 80),
            'passenger_gender' => $this->faker->randomElement(['male', 'female', 'other']),
        ];
    }
}
```

### Seeder (BookingSeatSeeder.php)
```php
<?php

namespace Database\Seeders;

use App\Models\BookingSeat;
use Illuminate\Database\Seeder;

class BookingSeatSeeder extends Seeder
{
    public function run(): void
    {
        $bookingSeats = [
            [
                'booking_id' => 1,
                'seat_id' => 1,
                'passenger_name' => 'Ahmed Hassan',
                'passenger_age' => 35,
                'passenger_gender' => 'male',
            ],
            [
                'booking_id' => 1,
                'seat_id' => 2,
                'passenger_name' => 'Fatima Hassan',
                'passenger_age' => 32,
                'passenger_gender' => 'female',
            ],
            [
                'booking_id' => 2,
                'seat_id' => 25,
                'passenger_name' => 'Fatima Rahman',
                'passenger_age' => 28,
                'passenger_gender' => 'female',
            ],
            [
                'booking_id' => 4,
                'seat_id' => 3,
                'passenger_name' => 'Rashida Begum',
                'passenger_age' => 45,
                'passenger_gender' => 'female',
            ],
        ];

        foreach ($bookingSeats as $bookingSeat) {
            BookingSeat::create($bookingSeat);
        }
    }
}
```

### Model (BookingSeat.php)
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingSeat extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'seat_id',
        'passenger_name',
        'passenger_age',
        'passenger_gender'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }
}
```

## 7. Seat Model

### Migration (2024_01_01_000005_create_seats_table.php)
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeatsTable extends Migration
{
    public function up(): void
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coach_id')->constrained()->onDelete('cascade');
            $table->string('seat_number');
            $table->integer('row_number');
            $table->enum('position', ['window', 'middle', 'aisle']);
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
}
```

### Factory (SeatFactory.php)
```php
<?php

namespace Database\Factories;

use App\Models\Coach;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeatFactory extends Factory
{
    public function definition(): array
    {
        $positions = ['window', 'middle', 'aisle'];
        $position = $this->faker->randomElement($positions);
        
        return [
            'coach_id' => Coach::factory(),
            'seat_number' => $this->faker->bothify('?#'),
            'row_number' => $this->faker->numberBetween(1, 20),
            'position' => $position,
            'is_window' => $position === 'window',
            'is_available' => $this->faker->boolean(80),
        ];
    }
}
```

### Seeder (SeatSeeder.php)
```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeatSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('seats')->insert([
            ['coach_id' => 1, 'seat_number' => 'A1', 'row_number' => 1, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 1, 'seat_number' => 'A2', 'row_number' => 1, 'position' => 'aisle', 'is_available' => true],
            ['coach_id' => 1, 'seat_number' => 'A3', 'row_number' => 2, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 1, 'seat_number' => 'A4', 'row_number' => 2, 'position' => 'aisle', 'is_available' => true],
            ['coach_id' => 1, 'seat_number' => 'A5', 'row_number' => 3, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 1, 'seat_number' => 'A6', 'row_number' => 3, 'position' => 'aisle', 'is_available' => true],
            ['coach_id' => 1, 'seat_number' => 'A7', 'row_number' => 4, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 1, 'seat_number' => 'A8', 'row_number' => 4, 'position' => 'aisle', 'is_available' => true],
            ['coach_id' => 1, 'seat_number' => 'A9', 'row_number' => 5, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 1, 'seat_number' => 'A10', 'row_number' => 5, 'position' => 'aisle', 'is_available' => true],
        ]);

        DB::table('seats')->insert([
            ['coach_id' => 2, 'seat_number' => 'B1', 'row_number' => 1, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 2, 'seat_number' => 'B2', 'row_number' => 1, 'position' => 'aisle', 'is_available' => true],
            ['coach_id' => 2, 'seat_number' => 'B3', 'row_number' => 2, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 2, 'seat_number' => 'B4', 'row_number' => 2, 'position' => 'aisle', 'is_available' => true],
            ['coach_id' => 2, 'seat_number' => 'B5', 'row_number' => 3, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 2, 'seat_number' => 'B6', 'row_number' => 3, 'position' => 'aisle', 'is_available' => true],
            ['coach_id' => 2, 'seat_number' => 'B7', 'row_number' => 4, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 2, 'seat_number' => 'B8', 'row_number' => 4, 'position' => 'aisle', 'is_available' => true],
            ['coach_id' => 2, 'seat_number' => 'B9', 'row_number' => 5, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 2, 'seat_number' => 'B10', 'row_number' => 5, 'position' => 'aisle', 'is_available' => true],
        ]);

        DB::table('seats')->insert([
            ['coach_id' => 3, 'seat_number' => 'C1', 'row_number' => 1, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 3, 'seat_number' => 'C2', 'row_number' => 1, 'position' => 'aisle', 'is_available' => true],
            ['coach_id' => 3, 'seat_number' => 'C3', 'row_number' => 2, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 3, 'seat_number' => 'C4', 'row_number' => 2, 'position' => 'aisle', 'is_available' => true],
            ['coach_id' => 3, 'seat_number' => 'C5', 'row_number' => 3, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 3, 'seat_number' => 'C6', 'row_number' => 3, 'position' => 'aisle', 'is_available' => true],
            ['coach_id' => 3, 'seat_number' => 'C7', 'row_number' => 4, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 3, 'seat_number' => 'C8', 'row_number' => 4, 'position' => 'aisle', 'is_available' => true],
            ['coach_id' => 3, 'seat_number' => 'C9', 'row_number' => 5, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 3, 'seat_number' => 'C10', 'row_number' => 5, 'position' => 'aisle', 'is_available' => true],
        ]);
    }
}
```

### Model (Seat.php)
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'coach_id',
        'seat_number',
        'row_number',
        'position',
        'is_window',
        'is_available'
    ];

    protected $casts = [
        'is_window' => 'boolean',
        'is_available' => 'boolean'
    ];

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function bookingSeats()
    {
        return $this->hasMany(BookingSeat::class);
    }

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_seats');
    }
}
```
