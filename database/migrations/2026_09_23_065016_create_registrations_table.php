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
       Schema::create('registrations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('event_id')->constrained()->cascadeOnDelete();
    $table->foreignId('participant_id')->constrained()->cascadeOnDelete();
    $table->integer('tickets_count')->default(1);
    $table->dateTime('registration_date');
    $table->boolean('additional_workshop')->default(false);
    $table->string('food_preference')->nullable();
    
    // Financial Fields
    $table->decimal('subtotal', 10, 2);
    $table->decimal('discount_percentage', 5, 2)->default(0.00);
    $table->decimal('discount_amount', 10, 2)->default(0.00);
    $table->decimal('final_amount', 10, 2);
    
    $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
    $table->timestamps();
});
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
