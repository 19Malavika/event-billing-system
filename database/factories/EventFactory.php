<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition(): array
{
    $totalSeats = $this->faker->numberBetween(50, 200);

    return [
        'title' => $this->faker->sentence(3),
        'description' => $this->faker->paragraph(),

        'event_date' => $this->faker->dateTimeBetween('+2 weeks', '+2 months'),

        'registration_start_date' => now(),

        'registration_end_date' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),

        'total_seats' => $totalSeats,

        'available_seats' => $totalSeats,

        'registration_fee' => $this->faker->randomFloat(2, 100, 1000),

        'status' => 'published',
    ];
}

}
