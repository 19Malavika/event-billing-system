<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Participant;
use App\Models\Registration;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default Test Admin User
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        // Create a clean test event with your exact business rule fees
        $event = Event::create([
            'title' => 'Tech Innovators Meetup 2026',
            'description' => 'A premier tech conference exploring modern web development.',
            'event_date' => '2026-10-15 10:00:00',
            'registration_start_date' => '2026-09-01 00:00:00',
            'registration_end_date' => '2026-10-10 23:59:59',
            'total_seats' => 100,
            'available_seats' => 100,
            'status' => 'published',
            'registration_fee' => 500.00,  // Exact rule price
            'workshop_fee'     => 200.00,  // Exact rule price
            'food_fee'         => 150.00,  // Exact rule price
        ]);

        // Create realistic test participants
        $participant1 = Participant::create([
            'name' => 'Rahul Sharma',
            'email' => 'rahul.sharma@example.com',
            'phone' => '9876543210',
            'gender' => 'Male',
            'course_department' => 'Computer Science',
        ]);

        $participant2 = Participant::create([
            'name' => 'Ananya Menon',
            'email' => 'ananya.m@example.com',
            'phone' => '9123456780',
            'gender' => 'Female',
            'course_department' => 'Information Technology',
        ]);

        // Optional: Create a sample registration using 3 tickets to test your 5% discount rule
        // (3 tickets * 500 = 1500 + workshop 200*3 = 600 + food 150*3 = 450 => Subtotal = 2550 - 5% = 2422.50)
        $tickets = 3;
        $subtotal = ($event->registration_fee * $tickets) + ($event->workshop_fee * $tickets) + ($event->food_fee * $tickets);
        $discountAmount = ($subtotal * 5) / 100;
        
        Registration::create([
            'event_id' => $event->id,
            'participant_id' => $participant1->id,
            'ticket_code' => 'TKT-' . strtoupper(Str::random(10)),
            'tickets_count' => $tickets,
            'registration_date' => now(),
            'additional_workshop' => true,
            'food_preference' => 'Vegetarian',
            'subtotal' => $subtotal,
            'discount_percentage' => 5.00,
            'discount_amount' => $discountAmount,
            'final_amount' => $subtotal - $discountAmount,
            'payment_status' => 'paid',
        ]);

        // Decrement seats for the sample registration
        $event->decrement('available_seats', $tickets);
    }
}