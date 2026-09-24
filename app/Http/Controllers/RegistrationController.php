<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = Registration::with(['event', 'participant']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('participant', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('event', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        $registrations = $query->latest()->paginate(10)->withQueryString();

        return view('admin.registrations.index', compact('registrations'));
    }
  private function calculateTotals(array $data, Event $event): array
{
    $tickets = (int) $data['tickets_count'];

    $eventFeeTotal =
        (float) $event->registration_fee * $tickets;

    $workshopTotal =
        !empty($data['additional_workshop'])
            ? (float) $event->workshop_fee * $tickets
            : 0;

    $foodTotal =
        !empty($data['food_preference'])
            ? (float) $event->food_fee * $tickets
            : 0;

    $subtotal =
        $eventFeeTotal +
        $workshopTotal +
        $foodTotal;

    $discountPercentage = 0;

    if ($tickets >= 5) {
        $discountPercentage = 10;
    } elseif ($tickets >= 3) {
        $discountPercentage = 5;
    }

    $discountAmount =
        ($subtotal * $discountPercentage) / 100;

    $finalAmount =
        $subtotal - $discountAmount;

    return [
        'subtotal' => $subtotal,
        'discount_percentage' => $discountPercentage,
        'discount_amount' => $discountAmount,
        'final_amount' => $finalAmount,
    ];
} 

    public function create()
    {
        $events = Event::where('status', 'published')->get();
        $participants = Participant::all();
        return view('admin.registrations.create', compact('events', 'participants'));
    }

 public function store(Request $request, Event $event)
{
    // 1. Validate the public registration form fields
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255'],
        'phone' => ['required', 'string', 'max:20'],
        'gender' => ['nullable', 'string', 'max:50'],
        'department' => ['nullable', 'string', 'max:100'],
        'tickets_count' => 'required|integer|min:1',
        'additional_workshop' => 'boolean',
        'food_preference' => 'nullable|string|max:100',
    ]);

    // 2. Validate seat availability
    if ($event->available_seats < $validated['tickets_count']) {
        return back()->withErrors(['tickets_count' => 'Requested tickets exceed available seats.'])->withInput();
    }

    // 3. Automatically find or create the participant using their email address
    $participant = Participant::firstOrCreate(
        ['email' => $validated['email']],
        [
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'gender' => $validated['gender'] ?? null,
           'course_department' => $validated['department'] ?? 'General', // <-
        ]
    );

    // 4. Prevent duplicate registration for the same event
    $exists = Registration::where('event_id', $event->id)
                          ->where('participant_id', $participant->id)
                          ->exists();
                          
    if ($exists) {
        return back()->withErrors(['email' => 'This participant is already registered for this event.'])->withInput();
    }

    // 5. Build base registration record data
    $registrationData = [
        'event_id' => $event->id,
        'participant_id' => $participant->id,
        'tickets_count' => $validated['tickets_count'],
        'registration_date' => now(),
        'additional_workshop' => $validated['additional_workshop'] ?? false,
        'food_preference' => $validated['food_preference'] ?? null,
        'payment_status' => 'pending',
    ];

    // 6. Compute pricing totals and discount logic
    $totals = $this->calculateTotals($registrationData, $event);
    $finalRegistrationData = array_merge($registrationData, $totals);

    // 7. Save the registration and decrement event available seats safely
    $registration = DB::transaction(function () use ($finalRegistrationData, $event) {
        $reg = Registration::create($finalRegistrationData);
        $event->decrement('available_seats', $finalRegistrationData['tickets_count']);
        return $reg;
    });

    // 8. Redirect straight to the registration confirmation / ticket page
    return redirect()->route('registrations.confirmation', $registration)
                     ->with('success', 'Registration and billing computed successfully.');
}
    public function show(Registration $registration)
    {
        return view('admin.registrations.show', compact('registration'));
    }

    public function edit(Registration $registration)
    {
        $events = Event::all();
        $participants = Participant::all();
        return view('admin.registrations.edit', compact('registration', 'events', 'participants'));
    }

    public function update(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'participant_id' => 'required|exists:participants,id',
            'tickets_count' => 'required|integer|min:1',
            'registration_date' => 'required|date',
            'additional_workshop' => 'boolean',
            'food_preference' => 'nullable|string|max:100',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        DB::transaction(function () use ($validated, $registration) {
            $seatDifference = $validated['tickets_count'] - $registration->tickets_count;
            
            if ($seatDifference !== 0) {
                $event = Event::findOrFail($validated['event_id']);
                if ($seatDifference > 0 && $event->available_seats < $seatDifference) {
                    throw new \Exception('Not enough available seats to update ticket count.');
                }
                $event->decrement('available_seats', $seatDifference);
            }

            $registration->update($validated);
        });

        return redirect()->route('registrations.index')->with('success', 'Registration updated successfully.');
    }

    public function destroy(Registration $registration)
    {
        DB::transaction(function () use ($registration) {
            // Restore seats back to the event
            $registration->event->increment('available_seats', $registration->tickets_count);
            $registration->delete();
        });

        return redirect()->route('registrations.index')->with('success', 'Registration deleted and seats restored.');
    }
}
