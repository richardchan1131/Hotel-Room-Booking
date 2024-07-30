<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bravo_tour_availability', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tour_id')->nullable();
            $table->dateTime('date')->nullable();
            $table->string('type')->nullable();
            $table->tinyInteger('min')->nullable();
            $table->tinyInteger('max')->nullable();
            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bravo_tour_availability');
    }
};
