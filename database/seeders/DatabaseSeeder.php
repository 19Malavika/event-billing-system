<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Participant;
use App\Models\Registration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default Test User
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed Fake Events, Participants, and Registrations
        Event::factory(5)->create()->each(function ($event) {
            $participants = Participant::factory(4)->create();
            
            foreach ($participants as $participant) {
               Registration::create([
    'event_id' => $event->id,
    'participant_id' => $participant->id,
    'tickets_count' => 2,
    'registration_date' => now(),
    'additional_workshop' => true,
    'food_preference' => 'Vegetarian',
    'subtotal' => 500.00,
    'discount_percentage' => 10.00,
    'discount_amount' => 50.00,
    'final_amount' => 450.00,
    'payment_status' => 'paid',
]);
            }
        });
    }
}