<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bravo_service_time', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('object_id')->nullable();
            $table->string('object_model')->nullable();
            $table->string('name')->nullable();
            $table->timestamp('time')->nullable();
            $table->tinyInteger('duration')->nullable();
            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bravo_service_time');
    }
};
