<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bravo_coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code',50)->unique();
            $table->string('name')->nullable();
            $table->float('amount')->nullable();
            $table->string('discount_type',50)->nullable();
            $table->dateTime('end_date')->nullable();

            $table->float('min_total')->nullable();
            $table->float('max_total')->nullable();

            $table->string('services')->nullable();
            $table->integer('only_for_user')->nullable();
            $table->string('status',30)->nullable();

            $table->integer('quantity_limit')->nullable();
            $table->integer('limit_per_user')->nullable();

            $table->bigInteger('image_id')->nullable();

            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('bravo_coupon_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('coupon_id')->nullable();
            $table->bigInteger('object_id')->nullable();
            $table->string('object_model')->nullable();
            $table->bigInteger('service_id')->nullable();

            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->timestamps();
        });
        Schema::create('bravo_booking_coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('booking_id')->nullable();
            $table->string('booking_status',30)->nullable();
            $table->bigInteger('object_id')->nullable();
            $table->string('object_model')->nullable();

            $table->string('coupon_code')->nullable();
            $table->decimal('coupon_amount',10,2)->nullable()->default(0);
            $table->text('coupon_data')->nullable();

            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
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
        Schema::dropIfExists('bravo_coupons');
        Schema::dropIfExists('bravo_coupon_services');
        Schema::dropIfExists('bravo_booking_coupons');
    }
}
