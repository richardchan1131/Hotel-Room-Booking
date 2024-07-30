<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bravo_rate_pricing', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pricing_cat_id')->nullable();
            $table->bigInteger('rate_id')->nullable();
            $table->decimal('price')->nullable();
            $table->tinyInteger('is_tier')->nullable();
            $table->tinyInteger('tier_min')->nullable();
            $table->tinyInteger('tier_max')->nullable();
            $table->bigInteger('schedule_id')->nullable();
            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bravo_rate_pricing');
    }
};
