<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use App\Models\Registration;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEvents = Event::count();
        $upcomingEventsCount = Event::where('event_date', '>', now())->count();
        $totalParticipants = Participant::count();
        $totalRegistrations = Registration::count();
        $totalRevenue = Registration::where('payment_status', 'paid')->sum('final_amount');
        $availableSeats = Event::sum('available_seats');

        $upcomingEvents = Event::where('event_date', '>', now())
            ->orderBy('event_date', 'asc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalEvents',
            'upcomingEventsCount',
            'totalParticipants',
            'totalRegistrations',
            'totalRevenue',
            'availableSeats',
            'upcomingEvents'
        ));
    }
}