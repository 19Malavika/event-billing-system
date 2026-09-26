<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = Registration::with(['event', 'participant']);

        // Search by participant name/email or event title
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->whereHas('participant', function ($participantQuery) use ($search) {
                    $participantQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('event', function ($eventQuery) use ($search) {
                    $eventQuery->where('title', 'like', "%{$search}%");
                });
            });
        }

        // Filter by event
        if ($request->filled('event_id')) {
            $query->where('event_id', $request->input('event_id'));
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where(
                'payment_status',
                $request->input('payment_status')
            );
        }

        // Filter by registration date
        if ($request->filled('date')) {
            $query->whereDate(
                'registration_date',
                $request->input('date')
            );
        }

        $registrations = $query
            ->latest('registration_date')
            ->paginate(10)
            ->withQueryString();

        $events = Event::orderBy('title')->get();

        return view(
            'admin.registrations.index',
            compact('registrations', 'events')
        );
    }

    private function calculateTotals(array $data, Event $event): array
    {
        $tickets = (int) $data['tickets_count'];

        // Event registration fee
        $eventFeeTotal =
            (float) $event->registration_fee * $tickets;

        // Workshop fee
        $workshopTotal =
            !empty($data['additional_workshop'])
                ? (float) $event->workshop_fee * $tickets
                : 0;

        // Food fee
        $foodTotal =
            !empty($data['food_preference'])
                ? (float) $event->food_fee * $tickets
                : 0;

        // Subtotal
        $subtotal =
            $eventFeeTotal +
            $workshopTotal +
            $foodTotal;

        // Discount rules
        $discountPercentage = 0;

        if ($tickets >= 5) {
            $discountPercentage = 10;
        } elseif ($tickets >= 3) {
            $discountPercentage = 5;
        }

        // Discount amount
        $discountAmount =
            ($subtotal * $discountPercentage) / 100;

        // Final amount
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
        $events = Event::where('status', 'published')
            ->orderBy('event_date')
            ->get();

        $participants = Participant::orderBy('name')->get();

        return view(
            'admin.registrations.create',
            compact('events', 'participants')
        );
    }

    /**
     * Public registration
     */
    public function storePublic(Request $request, Event $event)
    {
        $now = now();
        // Validate public registration fields
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'gender' => ['nullable', 'string', 'max:50'],
            'department' => ['nullable', 'string', 'max:100'],
            'tickets_count' => ['required', 'integer', 'min:1'],
            'additional_workshop' => ['nullable', 'boolean'],
            'food_preference' => ['nullable', 'string', 'max:100'],
            'payment_status' => ['required', 'in:pending,paid'],
        ]);

        // Make sure the event is available for registration
       if (
            $now->toDateString() < $event->registration_start_date->toDateString() ||
            $now->gt($event->registration_end_date)
        ) {
            return back()
                ->withErrors([
                    'event' => 'The registration period for this event is closed.',
                ])
                ->withInput();
        } 
        // Find existing participant or create a new one
        $participant = Participant::firstOrCreate(
            [
                'email' => $validated['email'],
            ],
            [
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'gender' => $validated['gender'] ?? null,
                'course_department' =>
                    $validated['department'] ?? 'General',
            ]
        );

        // Prevent duplicate registration
        $exists = Registration::where('event_id', $event->id)
            ->where('participant_id', $participant->id)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'email' =>
                        'This participant is already registered for this event.',
                ])
                ->withInput();
        }

        $registrationData = [
            'event_id' => $event->id,
            'participant_id' => $participant->id,
             'ticket_code' => 'TKT-' . strtoupper(Str::random(10)),
            'tickets_count' => $validated['tickets_count'],
            'registration_date' => now(),
            'additional_workshop' =>
                $validated['additional_workshop'] ?? false,
            'food_preference' =>
    $validated['food_preference'] ?? null,
'payment_status' =>
    $validated['payment_status'] ?? 'pending',
        ];

        // Calculate billing
        $totals = $this->calculateTotals(
            $registrationData,
            $event
        );

        $finalRegistrationData = array_merge(
            $registrationData,
            $totals
        );

        // Save registration and update seats
        $registration = DB::transaction(function () use (
            $finalRegistrationData,
            $event
        ) {
            $registration = Registration::create(
                $finalRegistrationData
            );

            $event->decrement(
                'available_seats',
                $finalRegistrationData['tickets_count']
            );

            return $registration;
        });

        return redirect()
            ->route(
                'registrations.confirmation',
                $registration
            )
            ->with(
                'success',
                'Registration and billing computed successfully.'
            );
    }

    /**
     * Admin registration
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => ['required', 'exists:events,id'],
            'participant_id' => [
                'required',
                'exists:participants,id',
            ],
            'tickets_count' => [
                'required',
                'integer',
                'min:1',
            ],
            'registration_date' => [
                'required',
                'date',
            ],
            'additional_workshop' => [
                'nullable',
                'boolean',
            ],
            'food_preference' => [
                'nullable',
                'string',
                'max:100',
            ],
            'payment_status' => [
                'required',
                'in:pending,paid,failed,refunded',
            ],
        ]);

        $event = Event::findOrFail(
            $validated['event_id']
        );

        // Event must be published
        if ($event->status !== 'published') {
            return back()
                ->withErrors([
                    'event_id' =>
                        'This event is not available for registration.',
                ])
                ->withInput();
        }

        // Check registration period
        $registrationDate = $validated['registration_date'];

        if (
            $registrationDate < $event->registration_start_date ||
            $registrationDate > $event->registration_end_date
        ) {
            return back()
                ->withErrors([
                    'registration_date' =>
                        'The registration date must be within the event registration period.',
                ])
                ->withInput();
        }

        // Prevent duplicate registration
        $exists = Registration::where(
            'event_id',
            $validated['event_id']
        )
            ->where(
                'participant_id',
                $validated['participant_id']
            )
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'participant_id' =>
                        'This participant is already registered for this event.',
                ])
                ->withInput();
        }

        // Check seats
        if (
            $event->available_seats <
            $validated['tickets_count']
        ) {
            return back()
                ->withErrors([
                    'tickets_count' =>
                        'Requested tickets exceed available seats.',
                ])
                ->withInput();
        }

        // Calculate billing
        $totals = $this->calculateTotals(
            $validated,
            $event
        );

        $registrationData = array_merge(
            $validated,
            $totals
        );

        // Save registration and decrease seats
        DB::transaction(function () use (
            $registrationData,
            $event
        ) {
            Registration::create(
                $registrationData
            );

            $event->decrement(
                'available_seats',
                $registrationData['tickets_count']
            );
        });

        return redirect()
            ->route('registrations.index')
            ->with(
                'success',
                'Registration created successfully.'
            );
    }

    public function show(Registration $registration)
    {
        $registration->load([
            'event',
            'participant',
        ]);

        return view(
            'admin.registrations.show',
            compact('registration')
        );
    }

    public function edit(Registration $registration)
    {
        $events = Event::all();
        $participants = Participant::all();

        return view(
            'admin.registrations.edit',
            compact(
                'registration',
                'events',
                'participants'
            )
        );
    }

    public function update(
        Request $request,
        Registration $registration
    ) {
        $validated = $request->validate([
            'event_id' => [
                'required',
                'exists:events,id',
            ],
            'participant_id' => [
                'required',
                'exists:participants,id',
            ],
            'tickets_count' => [
                'required',
                'integer',
                'min:1',
            ],
            'registration_date' => [
                'required',
                'date',
            ],
            'additional_workshop' => [
                'nullable',
                'boolean',
            ],
            'food_preference' => [
                'nullable',
                'string',
                'max:100',
            ],
            'payment_status' => [
                'required',
                'in:pending,paid,failed,refunded',
            ],
        ]);

        DB::transaction(function () use (
            $validated,
            $registration
        ) {
            $oldEvent = Event::findOrFail(
                $registration->event_id
            );

            $newEvent = Event::findOrFail(
                $validated['event_id']
            );

            /*
             * If the event changes:
             *
             * Return the old tickets to the old event.
             * Remove the new tickets from the new event.
             */
            if ($oldEvent->id !== $newEvent->id) {

                $oldEvent->increment(
                    'available_seats',
                    $registration->tickets_count
                );

                if (
                    $newEvent->available_seats <
                    $validated['tickets_count']
                ) {
                    throw new \Exception(
                        'Not enough available seats in the selected event.'
                    );
                }

                $newEvent->decrement(
                    'available_seats',
                    $validated['tickets_count']
                );
            } else {

                // Same event: calculate the ticket difference
                $seatDifference =
                    $validated['tickets_count'] -
                    $registration->tickets_count;

                if ($seatDifference > 0) {

                    if (
                        $newEvent->available_seats <
                        $seatDifference
                    ) {
                        throw new \Exception(
                            'Not enough available seats to update ticket count.'
                        );
                    }

                    $newEvent->decrement(
                        'available_seats',
                        $seatDifference
                    );
                } elseif ($seatDifference < 0) {

                    $newEvent->increment(
                        'available_seats',
                        abs($seatDifference)
                    );
                }
            }

            // Prevent duplicate participant/event combination
            $duplicate = Registration::where(
                'event_id',
                $validated['event_id']
            )
                ->where(
                    'participant_id',
                    $validated['participant_id']
                )
                ->where(
                    'id',
                    '!=',
                    $registration->id
                )
                ->exists();

            if ($duplicate) {
                throw new \Exception(
                    'This participant is already registered for this event.'
                );
            }

            // Recalculate billing using the selected event
            $totals = $this->calculateTotals(
                $validated,
                $newEvent
            );

         $registrationData = array_merge(
    $validated,
    $totals,
    [
        'ticket_code' => 'TKT-' . strtoupper(Str::random(10)),
    ]
);

            $registration->update(
                $registrationData
            );
        });

        return redirect()
            ->route('registrations.index')
            ->with(
                'success',
                'Registration updated successfully.'
            );
    }

    public function destroy(Registration $registration)
    {
        DB::transaction(function () use ($registration) {

            // Restore seats
            $registration->event->increment(
                'available_seats',
                $registration->tickets_count
            );

            // Delete registration
            $registration->delete();
        });

        return redirect()
            ->route('registrations.index')
            ->with(
                'success',
                'Registration deleted and seats restored.'
            );
    }
}