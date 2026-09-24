<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\RegistrationController;
use App\Models\Event;
use App\Models\Participant;
use App\Models\Registration;
use Illuminate\Support\Facades\Route;

// ==========================================
// 1. PUBLIC / LANDING SIDE ROUTES
// ==========================================

// Home / Landing Page
Route::get('/', function () {

    $upcomingEvents = Event::where('status', 'published')
        ->where('event_date', '>', now())
        ->orderBy('event_date', 'asc')
        ->take(3)
        ->get();

    return view('public.welcome', compact('upcomingEvents'));

})->name('home');


// ==========================================
// Events Listing (Public)
// ==========================================
Route::get('/events', function (\Illuminate\Http\Request $request) {

    $query = Event::where('status', 'published');

    // Search by event title
    if ($request->filled('search')) {
        $query->where(
            'title',
            'like',
            '%' . $request->search . '%'
        );
    }

    // Filter by event date
    if ($request->filled('date')) {
        $query->whereDate(
            'event_date',
            $request->input('date')
        );
    }

    $events = $query
        ->orderBy('event_date', 'asc')
        ->paginate(9)
        ->withQueryString();

    return view(
        'public.events.index',
        compact('events')
    );

})->name('public.events.index');

// ==========================================
// Event Details (Public)
// ==========================================

Route::get('/events/{event}', function (Event $event) {

    return view(
        'public.events.show',
        compact('event')
    );

})->name('public.events.show');


// ==========================================
// Event Registration Form (Public)
// ==========================================

Route::get('/events/{event}/register', function (Event $event) {

    return view(
        'public.register',
        compact('event')
    );

})->name('public.events.register');

Route::get('/registrations/{registration}/ticket', function (App\Models\Registration $registration) {
    return view('public.registrations.ticket', compact('registration'));
})->name('registrations.ticket');
// ==========================================
// Store Event Registration (Public Action)
// ==========================================

Route::post(
    '/events/{event}/register',
    [RegistrationController::class, 'storePublic']
)->name('events.register.store');


// ==========================================
// Registration Confirmation & Ticket View
// ==========================================

Route::get(
    '/registrations/{registration}/confirmation',
    function (Registration $registration) {

        $registration->load([
            'event',
            'participant'
        ]);

        return view(
            'public.registrations.confirmation',
            compact('registration')
        );

    }
)->name('registrations.confirmation');


// ==========================================
// 2. AUTHENTICATED ADMIN / MANAGEMENT ROUTES
// ==========================================

Route::middleware(['auth', 'verified'])->group(function () {

    // --------------------------------------
    // Admin Dashboard
    // --------------------------------------

    Route::get('/dashboard', function () {

        $totalEvents = Event::count();

        $upcomingEventsCount = Event::where(
            'status',
            'published'
        )
            ->where('event_date', '>', now())
            ->count();

        $totalParticipants = Participant::count();

        $totalRegistrations = Registration::count();

        $totalRevenue = Registration::where(
            'payment_status',
            'paid'
        )->sum('final_amount');

        $availableSeats = Event::sum('available_seats');

        $upcomingEvents = Event::where(
            'status',
            'published'
        )
            ->where('event_date', '>', now())
            ->orderBy('event_date', 'asc')
            ->take(5)
            ->get();

        $recentRegistrations = Registration::with([
            'event',
            'participant'
        ])
            ->latest()
            ->take(5)
            ->get();
        // Registration Summary
$registrationSummary = [
    'paid' => Registration::where('payment_status', 'paid')->count(),
    'pending' => Registration::where('payment_status', 'pending')->count(),
    'failed' => Registration::where('payment_status', 'failed')->count(),
    'refunded' => Registration::where('payment_status', 'refunded')->count(),
];

// Revenue Summary
$revenueSummary = [
    'paid' => Registration::where('payment_status', 'paid')->sum('final_amount'),
    'pending' => Registration::where('payment_status', 'pending')->sum('final_amount'),
    'refunded' => Registration::where('payment_status', 'refunded')->sum('final_amount'),
];
return view('dashboard', compact(
    'totalEvents',
    'upcomingEventsCount',
    'totalParticipants',
    'totalRegistrations',
    'totalRevenue',
    'availableSeats',
    'upcomingEvents',
    'recentRegistrations',
    'registrationSummary',
    'revenueSummary'
));

    })->name('dashboard');


    // --------------------------------------
    // Revenue / Billing Report
    // --------------------------------------

   Route::get('/reports/revenue', function (\Illuminate\Http\Request $request) {

    $query = Registration::with([
        'event',
        'participant'
    ]);

    // Search/filter by date range
    if ($request->filled('from_date')) {
        $query->whereDate(
            'registration_date',
            '>=',
            $request->input('from_date')
        );
    }

    if ($request->filled('to_date')) {
        $query->whereDate(
            'registration_date',
            '<=',
            $request->input('to_date')
        );
    }

    // Filter by event
    if ($request->filled('event_id')) {
        $query->where(
            'event_id',
            $request->input('event_id')
        );
    }

    // Filter by payment status
    if ($request->filled('payment_status')) {
        $query->where(
            'payment_status',
            $request->input('payment_status')
        );
    }

    // Clone query before pagination for report statistics
    $statsQuery = clone $query;

    $totalRevenue = (clone $statsQuery)
        ->where('payment_status', 'paid')
        ->sum('final_amount');

    $totalRegistrations = (clone $statsQuery)
        ->count();

    $paidCount = (clone $statsQuery)
        ->where('payment_status', 'paid')
        ->count();

    $pendingCount = (clone $statsQuery)
        ->where('payment_status', 'pending')
        ->count();

    $totalDiscounts = (clone $statsQuery)
        ->sum('discount_amount');

    $registrations = $query
        ->latest('registration_date')
        ->paginate(10)
        ->withQueryString();

    $events = Event::orderBy('title')->get();

    return view(
        'reports.revenue',
        compact(
            'totalRevenue',
            'totalRegistrations',
            'paidCount',
            'pendingCount',
            'totalDiscounts',
            'registrations',
            'events'
        )
    );

})->name('reports.revenue');


    // --------------------------------------
    // Invoice / Billing Details
    // --------------------------------------

    Route::get(
        '/reports/invoices/{registration}',
        function (Registration $registration) {

            $registration->load([
                'event',
                'participant'
            ]);

            return view(
                'admin.reports.invoice',
                compact('registration')
            );

        }
    )->name('reports.invoice');


    // --------------------------------------
    // Admin Resources
    // --------------------------------------

    Route::resource(
        'admin/events',
        EventController::class
    )->names('events');


    Route::resource(
        'participants',
        ParticipantController::class
    );


    Route::resource(
        'registrations',
        RegistrationController::class
    );
});


// ==========================================
// 3. PROFILE MANAGEMENT & AUTH
// ==========================================

Route::middleware('auth')->group(function () {

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');
});


require __DIR__.'/auth.php';

