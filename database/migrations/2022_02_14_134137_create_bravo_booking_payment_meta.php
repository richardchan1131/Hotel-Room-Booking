<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBravoBookingPaymentMeta extends Migration
{
	public function up()
	{
        if(!Schema::hasTable('bravo_booking_payment_meta')){
		    Schema::create('bravo_booking_payment_meta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('payment_id')->nullable();
            $table->string('name',255)->nullable();
            $table->text('val')->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();

            $table->index(['payment_id','name']);

			$table->timestamps();
		});
	    }
	}

	public function down()
	{
		Schema::dropIfExists('bravo_booking_payment_meta');
	}
}
