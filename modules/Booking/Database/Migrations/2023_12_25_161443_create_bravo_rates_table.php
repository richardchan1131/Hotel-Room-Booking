<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bravo_rates', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('object_id')->nullable();
            $table->string('object_model')->nullable();
            $table->tinyInteger('is_per_person')->nullable();
            $table->tinyInteger('is_all_pricing_category')->nullable();
            $table->text('start_time_ids')->nullable();
            $table->tinyInteger('min_passengers')->nullable();
            $table->tinyInteger('max_passengers')->nullable();
            $table->tinyInteger('tier_pricing_enable')->nullable();
            $table->text('tier_pricing')->nullable();
            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bravo_rates');
    }
};
