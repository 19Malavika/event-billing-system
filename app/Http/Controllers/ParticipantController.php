<?php
namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index(Request $request)
    {
        $query = Participant::query();

        // Search by Name, Email, or Course/Department
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('course_department', 'like', "%{$search}%");
            });
        }

        $participants = $query->latest()->paginate(10)->withQueryString();

        return view('admin.participants.index', compact('participants'));
    }

    public function create()
    {
        return view('admin.participants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:participants,email',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Male,Female,Other',
            'course_department' => 'required|string|max:255',
        ]);

        Participant::create($validated);

       return redirect()
    ->route('participants.index')
    ->with('success', 'Participant added successfully.');
    }

    public function show(Participant $participant)
    {
        $participant->load('registrations.event');
        return view('admin.participants.show', compact('participant'));
    }

    public function edit(Participant $participant)
    {
        return view('admin.participants.edit', compact('participant'));
    }

    public function update(Request $request, Participant $participant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:participants,email,' . $participant->id,
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Male,Female,Other',
            'course_department' => 'required|string|max:255',
        ]);

        $participant->update($validated);

return redirect()
    ->route('participants.index')
    ->with('success', 'Participant updated successfully.');
    }

    public function destroy(Participant $participant)
    {
        $participant->delete();

       return redirect()
    ->route('participants.index')
    ->with('success', 'Participant deleted successfully.');
    }
}