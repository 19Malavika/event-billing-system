<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('date')) {
            $query->whereDate('event_date', $request->input('date'));
        }

        $events = $query
            ->latest('event_date')
            ->paginate(10)
            ->withQueryString();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'registration_start_date' => 'required|date',
            'registration_end_date' => 'required|date|after_or_equal:registration_start_date',
            'total_seats' => 'required|integer|min:1',
            'registration_fee' => 'required|numeric|min:0',
            'workshop_fee' => 'required|numeric|min:0',
            'food_fee' => 'required|numeric|min:0',
            'status' => 'required|in:draft,published,completed,cancelled',
        ]);

        $validated['available_seats'] = $validated['total_seats'];

        Event::create($validated);

        return redirect()
            ->route('events.index')
            ->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        $event->load([
            'registrations.participant',
        ]);

        $registeredTickets = $event->registrations->sum('tickets_count');

        $registeredCount = $event->registrations->count();

        $revenue = $event->registrations
            ->where('payment_status', 'paid')
            ->sum('final_amount');

        return view('admin.events.show', compact(
            'event',
            'registeredTickets',
            'registeredCount',
            'revenue'
        ));
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'registration_start_date' => 'required|date',
            'registration_end_date' => 'required|date|after_or_equal:registration_start_date',
            'total_seats' => 'required|integer|min:1',
            'registration_fee' => 'required|numeric|min:0',
            'workshop_fee' => 'required|numeric|min:0',
            'food_fee' => 'required|numeric|min:0',
            'status' => 'required|in:draft,published,completed,cancelled',
        ]);

        $registeredTickets = $event->total_seats - $event->available_seats;

        if ($validated['total_seats'] < $registeredTickets) {
            return back()
                ->withErrors([
                    'total_seats' => 'Total seats cannot be less than already registered tickets.',
                ])
                ->withInput();
        }

        $validated['available_seats'] =
            $validated['total_seats'] - $registeredTickets;

        $event->update($validated);

        return redirect()
            ->route('events.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()
            ->route('events.index')
            ->with('success', 'Event deleted successfully.');
    }
}