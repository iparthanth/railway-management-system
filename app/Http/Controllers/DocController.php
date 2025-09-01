<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;

class DocController extends Controller
{
    public function reportPdf()
    {
        $base = base_path();
        $paths = [
            'controller' => $base . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'TrainController.php',
            'index' => $base . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'trains' . DIRECTORY_SEPARATOR . 'index.blade.php',
            'search' => $base . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'trains' . DIRECTORY_SEPARATOR . 'search-results.blade.php',
            'seats' => $base . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'trains' . DIRECTORY_SEPARATOR . 'seats.blade.php',
            'home' => $base . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'home.blade.php',
        ];

        $src = [];
        foreach ($paths as $key => $path) {
            $src[$key] = file_exists($path) ? file_get_contents($path) : 'File not found: ' . $path;
        }

        // Build blocks per file (student-friendly sections)
        $controllerBlocks = $this->buildControllerBlocks($src['controller']);
        $homeBlocks = $this->buildHomeBlocks($src['home']);
        $indexBlocks = $this->buildIndexBlocks($src['index']);
        $searchBlocks = $this->buildSearchBlocks($src['search']);
        $seatsBlocks = $this->buildSeatsBlocks($src['seats']);

        $html = view('docs.report', [
            'controllerBlocks' => $controllerBlocks,
            'homeBlocks' => $homeBlocks,
            'indexBlocks' => $indexBlocks,
            'searchBlocks' => $searchBlocks,
            'seatsBlocks' => $seatsBlocks,
            'controllerCode' => $src['controller'],
            'homeCode' => $src['home'],
            'indexCode' => $src['index'],
            'searchCode' => $src['search'],
            'seatsCode' => $src['seats'],
        ])->render();

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="railway_system_detailed_explanation.pdf"',
        ]);
    }

    // -------- helpers to slice code into simple blocks --------

    private function between(string $haystack, string $start, ?string $end = null): string
    {
        $posStart = strpos($haystack, $start);
        if ($posStart === false) return '';
        $posStart += strlen($start);
        if ($end === null) return substr($haystack, $posStart);
        $posEnd = strpos($haystack, $end, $posStart);
        if ($posEnd === false) return substr($haystack, $posStart);
        return substr($haystack, $posStart, $posEnd - $posStart);
    }

    private function slice(string $haystack, string $start, string $end): string
    {
        $p1 = strpos($haystack, $start);
        if ($p1 === false) return '';
        $p2 = strpos($haystack, $end, $p1 + strlen($start));
        if ($p2 === false) return substr($haystack, $p1);
        return substr($haystack, $p1, $p2 - $p1 + strlen($end));
    }

    private function buildControllerBlocks(string $code): array
    {
        $blocks = [];
        // Imports and class header
        $blocks[] = [
            'title' => 'Imports and Class Declaration',
            'code' => $this->slice($code, "<?php", "private function getTrainsData"),
            'explain' => 'Sets up the controller with Request and Carbon. Declares TrainController which handles listing, searching, and seats. Connected routes: trains.index, trains.search, trains.seats. Database: not used here; using a static dataset for demo.'
        ];
        // getTrainsData
        $blocks[] = [
            'title' => 'getTrainsData(): demo dataset',
            'code' => $this->slice($code, 'private function getTrainsData()', 'public function index('),
            'explain' => 'Returns a hard-coded list of trains (id, number, route, schedule). Used by index(), search(), and seats(). Database: none; replace with Eloquent queries in real apps.'
        ];
        // index
        $blocks[] = [
            'title' => 'index(): show all trains',
            'code' => $this->slice($code, 'public function index()', 'public function search('),
            'explain' => 'Loads all trains and returns the trains.index view. Connected page: resources/views/trains/index.blade.php. Database: none.'
        ];
        // search
        $blocks[] = [
            'title' => 'search(): validate and filter',
            'code' => $this->slice($code, 'public function search(', 'public function seats('),
            'explain' => 'Validates form input from home.blade.php, filters the demo trains by from/to, adds price and seats, and returns trains.search-results with results + original searchParams. Connected page: resources/views/trains/search-results.blade.php. Database: none.'
        ];
        // seats
        $blocks[] = [
            'title' => 'seats(): rolling 7 days + booked seats per date',
            'code' => $this->slice($code, 'public function seats(', 'private function generateBookedSeatsForDate('),
            'explain' => 'Finds the train by id, builds a 7-day rolling window (today or chosen date), creates day cards with availability, clamps selected date, and computes $bookedSeats. Passes week, selectedDate, bookedSeats, isFullyBooked and train to the seats view. Database: none; availability is generated in code for learning.'
        ];
        // generator
        $blocks[] = [
            'title' => 'generateBookedSeatsForDate(): simple weekday-based demo',
            'code' => $this->between($code, 'private function generateBookedSeatsForDate', null),
            'explain' => 'Chooses booked seats by weekday so code is easy to grade. Wednesday is fully booked; others vary (light/medium/high/almost full). Connected page: seats.blade.php uses this output to disable seats and show counts.'
        ];
        return $blocks;
    }

    private function buildHomeBlocks(string $code): array
    {
        return [
            [
                'title' => 'Head and Styles',
                'code' => $this->slice($code, '<head>', '</head>'),
                'explain' => 'Page title, CSS for navbar and search card. Connected routes in navbar: home and trains.index. Database: none.'
            ],
            [
                'title' => 'Navbar',
                'code' => $this->slice($code, '<div class="navbar">', '</div>'),
                'explain' => 'Top navigation with links. Appears on all pages for consistent UX. Database: none.'
            ],
            [
                'title' => 'Welcome Text',
                'code' => $this->slice($code, '<div class="welcome-text">', '</div>'),
                'explain' => 'Simple hero text. Visual only. Database: none.'
            ],
            [
                'title' => 'Search Form',
                'code' => $this->slice($code, '<div class="container">', '</div>'),
                'explain' => 'Form posts to route trains.search (TrainController::search). Fields: from, to, journey_date (min today), passengers (1-4). Database: none here; controller filters demo data.'
            ],
            [
                'title' => 'Client-side Validation Script',
                'code' => $this->slice($code, '<script>', '</script>'),
                'explain' => 'Prevents same from/to and empty selections before submitting. Final validation also runs server-side in TrainController::search. Database: none.'
            ],
        ];
    }

    private function buildIndexBlocks(string $code): array
    {
        return [
            [
                'title' => 'Head and Styles',
                'code' => $this->slice($code, '<head>', '</head>'),
                'explain' => 'Basic page setup and styles. Database: none.'
            ],
            [
                'title' => 'Navbar',
                'code' => $this->slice($code, '<div class="navbar">', '</div>'),
                'explain' => 'Navigation bar shared across pages. Database: none.'
            ],
            [
                'title' => 'Trains List (foreach)',
                'code' => $this->slice($code, '@foreach($trains', '@endforeach'),
                'explain' => 'Loops over $trains provided by TrainController::index. Shows key info and a link to trains.seats for each train. Database: dataset comes from controller, not DB.'
            ],
        ];
    }

    private function buildSearchBlocks(string $code): array
    {
        return [
            [
                'title' => 'Head and Styles',
                'code' => $this->slice($code, '<head>', '</head>'),
                'explain' => 'Page setup and styles for results screen. Database: none.'
            ],
            [
                'title' => 'Navbar',
                'code' => $this->slice($code, '<div class="navbar">', '</div>'),
                'explain' => 'Navigation links. Database: none.'
            ],
            [
                'title' => 'Search Summary Card',
                'code' => $this->slice($code, '<div class="card">\n            <h2>🔍 Search Results</h2>', '</div>'),
                'explain' => 'Shows selected route, date, and passenger count based on $searchParams from TrainController::search. Database: none.'
            ],
            [
                'title' => 'Results Loop (foreach)',
                'code' => $this->slice($code, '@foreach($trains as $train)', '@endforeach'),
                'explain' => 'Renders each matching train with price and “Select Seats” button. Passes journey_date and passengers into the seats route. Database: none.'
            ],
            [
                'title' => 'Empty State (no results)',
                'code' => $this->slice($code, '@else', '@endif'),
                'explain' => 'Shown when no trains match the route. Database: none.'
            ],
        ];
    }

    private function buildSeatsBlocks(string $code): array
    {
        return [
            [
                'title' => 'Head and Styles',
                'code' => $this->slice($code, '<head>', '</head>'),
                'explain' => 'Seat page title and CSS for date pills and seat grid. Database: none.'
            ],
            [
                'title' => 'Navbar',
                'code' => $this->slice($code, '<div class="navbar">', '</div>'),
                'explain' => 'Top navigation. Database: none.'
            ],
            [
                'title' => 'Train Info Card',
                'code' => $this->slice($code, '<div class="card">\n            <h2>Select Your Seats</h2>', '</div>'),
                'explain' => 'Shows the selected train name/number and route. Data comes from TrainController::seats. Database: none.'
            ],
            [
                'title' => 'Date Strip (7 days)',
                'code' => $this->slice($code, '<div class="card">\n            <h3>Choose Date (7 days)</h3>', '</div>'),
                'explain' => 'Renders seven days starting from the controller-provided $train[\'journey_date\']. Clicking pills reloads the same seats route with ?date=... to switch availability. Database: none; controller computes booked seats.'
            ],
            [
                'title' => 'Seat Legend',
                'code' => $this->slice($code, '<div class="card">\n            <h3>Seat Legend</h3>', '</div>'),
                'explain' => 'Legend for Available/Selected/Booked colors. Database: none.'
            ],
            [
                'title' => 'Seat Grid Form',
                'code' => $this->slice($code, '<form', '</form>'),
                'explain' => 'Creates a 4x4 grid (A-D rows, 1-4 columns). Uses $bookedSeats from controller to disable booked ones and styles them red. When $isFullyBooked, the Confirm button is disabled. Database: none; availability is generated by controller.'
            ],
        ];
    }
}