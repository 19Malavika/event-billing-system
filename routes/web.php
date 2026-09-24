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

    if ($request->filled('search')) {

        $query->where(
            'title',
            'like',
            '%' . $request->search . '%'
        );
    }

    $events = $query
        ->latest()
        ->paginate(9);

    // Public events listing page
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
    [RegistrationController::class, 'store']
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

        return view('dashboard', compact(
            'totalEvents',
            'upcomingEventsCount',
            'totalParticipants',
            'totalRegistrations',
            'totalRevenue',
            'availableSeats',
            'upcomingEvents',
            'recentRegistrations'
        ));

    })->name('dashboard');


    // --------------------------------------
    // Revenue / Billing Report
    // --------------------------------------

    Route::get('/reports/revenue', function () {

        $totalRevenue = Registration::where(
            'payment_status',
            'paid'
        )->sum('final_amount');

        $paidCount = Registration::where(
            'payment_status',
            'paid'
        )->count();

        $pendingCount = Registration::where(
            'payment_status',
            'pending'
        )->count();

        $totalDiscounts = Registration::sum(
            'discount_amount'
        );

        $registrations = Registration::latest()
            ->paginate(10);

        return view(
            'reports.revenue',
            compact(
                'totalRevenue',
                'paidCount',
                'pendingCount',
                'totalDiscounts',
                'registrations'
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

