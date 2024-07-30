<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Booking\Models\BookingPassenger;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if(Schema::hasTable(BookingPassenger::getTableName())) return;

        Schema::create(BookingPassenger::getTableName(), function (Blueprint $blueprint) {

            $blueprint->bigIncrements('id');
            $blueprint->integer('flight_id')->nullable();
            $blueprint->integer('flight_seat_id')->nullable();
            $blueprint->integer('booking_id')->nullable();
            $blueprint->string('seat_type')->nullable();
            $blueprint->string('email')->nullable();
            $blueprint->string('first_name')->nullable();
            $blueprint->string('last_name')->nullable();
            $blueprint->string('phone')->nullable();
            $blueprint->dateTime('dob')->nullable();
            $blueprint->decimal('price', 12, 2)->nullable();
            $blueprint->string('id_card')->nullable();

            $blueprint->string('object_model',30);
            $blueprint->bigInteger('object_id')->nullable();

            $blueprint->index('booking_id');
            $blueprint->index(['object_model','object_id']);

            $blueprint->text('meta')->nullable();
            $blueprint->tinyInteger('is_scanned')->nullable()->default(0);
            $blueprint->bigInteger('scanned_by')->nullable();
            $blueprint->timestamp('scanned_at')->nullable();

            $blueprint->bigInteger('create_user')->nullable();
            $blueprint->bigInteger('update_user')->nullable();
            $blueprint->timestamps();
            $blueprint->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(BookingPassenger::getTableName());
    }
};
