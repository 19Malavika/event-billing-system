<?php
namespace App\Http\Requests;

use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id' => [
                'required',
                'exists:events,id',
                // Rule to ensure event is valid and published
                function ($attribute, $value, $fail) {
                    $event = Event::find($value);
                    if (!$event || $event->status !== 'published') {
                        $fail('The selected event is invalid or not currently available for registration.');
                    }
                    // Registration date bounds check
                    $now = now();
                    if ($now->lt($event->registration_start_date) || $now->gt($event->registration_end_date)) {
                        $fail('The registration period for this event is not active.');
                    }
                },
            ],
            'participant_id' => [
                'required',
                'exists:participants,id',
                // Prevent duplicate registration for the same event
                Rule::unique('registrations')->where(function ($query) {
                    return $query->where('event_id', $this->event_id)
                                 ->where('participant_id', $this->participant_id);
                }),
            ],
            'tickets_count' => [
                'required',
                'integer',
                'min:1',
                // Check available seats dynamically
                function ($attribute, $value, $fail) {
                    $event = Event::find($this->event_id);
                    if ($event && $event->available_seats < $value) {
                        $fail("Only {$event->available_seats} seats are available for this event.");
                    }
                },
            ],
            'registration_date' => 'required|date',
            'additional_workshop' => 'boolean',
            'food_preference' => 'nullable|string|max:100',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ];
    }

    public function messages(): array
    {
        return [
            'participant_id.unique' => 'This participant is already registered for this event.',
            'tickets_count.min' => 'You must register for at least 1 ticket.',
        ];
    }
}