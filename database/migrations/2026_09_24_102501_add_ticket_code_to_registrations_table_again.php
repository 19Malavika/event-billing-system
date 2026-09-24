<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('registrations', 'ticket_code')) {
            Schema::table('registrations', function (Blueprint $table) {
                $table->string('ticket_code')
                    ->unique()
                    ->nullable()
                    ->after('id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('registrations', 'ticket_code')) {
            Schema::table('registrations', function (Blueprint $table) {
                $table->dropColumn('ticket_code');
            });
        }
    }
};