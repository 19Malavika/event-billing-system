<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Event Name
            $table->text('description')->nullable();
            $table->dateTime('event_date'); // Event Date
            $table->dateTime('registration_start_date');
            $table->dateTime('registration_end_date');
            $table->integer('total_seats'); // Maximum Seats
            $table->integer('available_seats');
            $table->decimal('registration_fee', 10, 2)->default(0.00);
            $table->enum('status', ['draft', 'published', 'completed', 'cancelled'])->default('draft');
            $table->string('image')->nullable(); //
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
