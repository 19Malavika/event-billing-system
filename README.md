# Event Registration & Billing System (EventHub)

A robust, full-stack Laravel-based event management, public registration, and billing system designed to handle secure event browsing, dynamic fee calculation, seat tracking, and administrative reporting.

---

## 🚀 Project Description
The Event Registration & Billing System streamlines the entire lifecycle of hosting events—from administrative publishing and seating configuration to seamless public registration, ticket generation, and automated billing computation.

---

## 🛠️ Features
* **Public Event Browsing & Search**: Filter published events by title, date, or status without requiring admin credentials.
* **Streamlined Public Registration**: Participants can register directly with dynamic form validation, auto-creating participant profiles based on email uniqueness.
* **Dynamic Billing & Discounts**: Real-time calculation of event fees, additional workshops, food preferences, and promotional percentage discounts.
* **Secure Seat Management**: Database transactions ensure seat counts decrement accurately and prevent overbooking.
* **Confirmation & Ticketing**: Instant redirection to a detailed confirmation and printable ticket view upon successful sign-up.
* **Comprehensive Admin Dashboard**: Complete CRUD management for events, participants, registrations, and financial reporting with secure role-based access.
* **Responsive UI/UX**: Built with Tailwind CSS, featuring status badges, empty states, flash messages, and mobile-first layouts.

---

## ⚙️ Setup Instructions

Follow these steps to set up the project locally:

Business Rules & Implementation Logic
1. Registration Controller Validation & Flow (RegistrationController@store)
Registrations enforce strict temporal, status, and duplication checks:

PHP
public function store(Request $request, Event $event)
{
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

    // Seat Availability Check
    if ($event->available_seats < $validated['tickets_count']) {
        return back()->withErrors(['tickets_count' => 'Requested tickets exceed available seats.'])->withInput();
    }

    // Auto-create or find participant profile via unique email
    $participant = Participant::firstOrCreate(
        ['email' => $validated['email']],
        [
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'gender' => $validated['gender'] ?? null,
            'course_department' => $validated['department'] ?? 'General',
        ]
    );

    // Prevent duplicate registration per event
    $exists = Registration::where('event_id', $event->id)
                          ->where('participant_id', $participant->id)
                          ->exists();
    if ($exists) {
        return back()->withErrors(['email' => 'This participant is already registered for this event.'])->withInput();
    }
    
    // ... Database transaction & seat decrement logic
}
2. Seat Management & Database Transactions
To prevent race conditions and overbooking, database transactions handle registration creation and seat decrements simultaneously:

PHP
$registration = DB::transaction(function () use ($finalRegistrationData, $event) {
    $reg = Registration::create($finalRegistrationData);
    $event->decrement('available_seats', $finalRegistrationData['tickets_count']);
    return $reg;
});
Calculation Logic
Billing amounts, workshop fees, and percentage-based discounts are calculated dynamically upon form submission:

PHP
protected function calculateTotals($data, $event)
{
    $ticketFee = $event->registration_fee * $data['tickets_count'];
    $workshopFee = !empty($data['additional_workshop']) ? ($event->workshop_fee ?? 0) : 0;
    $foodFee = !empty($data['food_preference']) ? ($event->food_fee ?? 0) : 0;

    $subtotal = $ticketFee + $workshopFee + $foodFee;
    
    // Apply discount percentage if configured
    $discountPercentage = $event->discount_percentage ?? 0;
    $discountAmount = $subtotal * ($discountPercentage / 100);
    $finalAmount = $subtotal - $discountAmount;

    return [
        'subtotal' => round($subtotal, 2),
        'discount_percentage' => round($discountPercentage, 2),
        'discount_amount' => round($discountAmount, 2),
        'final_amount' => round($finalAmount, 2),
    ];
}
## Screenshots

You can view the application screenshots in the [public/screenshots folder](./public/screenshots).