<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bravo_pricing_cat_relation', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('object_id')->nullable();
            $table->string('object_model')->nullable();
            $table->bigInteger('pricing_cat_id')->nullable();
            $table->tinyInteger('is_default')->default(0)->nullable();
            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bravo_pricing_cat_relation');
    }
};
