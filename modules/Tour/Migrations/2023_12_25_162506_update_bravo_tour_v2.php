<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bravo_tours', function (Blueprint $table) {

            if (!Schema::hasColumn('bravo_tours', 'booking_type')) {
                $table->string('booking_type')->nullable();
            }
            if (!Schema::hasColumn('bravo_tours', 'limit_type')) {
                $table->string('limit_type')->nullable();
            }
            if (!Schema::hasColumn('bravo_tours', 'capacity_type')) {
                $table->string('capacity_type')->nullable();
            }
            if (!Schema::hasColumn('bravo_tours', 'capacity')) {
                $table->text('capacity')->nullable();
            }
            if (!Schema::hasColumn('bravo_tours', 'pass_exprire_type')) {
                $table->string('pass_exprire_type')->nullable();
            }
            if (!Schema::hasColumn('bravo_tours', 'pass_exprire_at')) {
                $table->dateTime('pass_exprire_at')->nullable();
            }
            if (!Schema::hasColumn('bravo_tours', 'pass_valid_for')) {
                $table->dateTime('pass_valid_for')->nullable();
            }
        });
        Schema::table('bravo_tour_dates', function (Blueprint $table) {

            if (!Schema::hasColumn('bravo_tour_dates', 'time_id')) {
                $table->bigInteger('time_id')->nullable();
            }
            if (!Schema::hasColumn('bravo_tour_dates', 'min_guest')) {
                $table->tinyInteger('min_guest')->nullable();
            }
        });
    }

    public function down(): void
    {

    }
};
