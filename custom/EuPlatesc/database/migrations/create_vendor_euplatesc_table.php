<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_euplatesc', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vendor_id');
            $table->string('key');
            $table->string('mid');
            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_euplatesc');
    }
};