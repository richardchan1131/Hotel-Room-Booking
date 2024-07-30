<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bc_properties', function (Blueprint $table) {
            $table->bigIncrements('id');

            //Info
            $table->string('title', 255)->nullable();
            $table->string('slug',255)->charset('utf8')->index();
            $table->text('content')->nullable();
            $table->integer('image_id')->nullable();
            $table->integer('banner_image_id')->nullable();
            $table->integer('location_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('address', 255)->nullable();
            $table->string('map_lat',20)->nullable();
            $table->string('map_lng',20)->nullable();
            $table->integer('map_zoom')->nullable();
            $table->tinyInteger('is_featured')->nullable();
            $table->string('gallery', 255)->nullable();
            $table->string('video', 255)->nullable();
            $table->text('faqs')->nullable();
            $table->dateTime('last_time_viewed')->nullable();

            //Price
            $table->decimal('price', 12,2)->nullable();
            $table->decimal('sale_price', 12,2)->nullable();
            $table->tinyInteger('is_instant')->default(0)->nullable();
            $table->tinyInteger('allow_children')->default(0)->nullable();
            $table->tinyInteger('allow_infant')->default(0)->nullable();
            $table->integer('max_guests')->default(0)->nullable();

            $table->tinyInteger('bed')->default(0)->nullable();
            $table->tinyInteger('bathroom')->default(0)->nullable();
            $table->integer('square')->default(0)->nullable();

            $table->tinyInteger('garages')->default(0)->nullable();
            $table->year('year_built')->nullable();
            $table->integer('area')->default(0)->nullable();
            $table->text('area_unit')->nullable();

            $table->text('deposit')->nullable();
            $table->text('pool_size')->nullable();
            $table->text('additional_zoom')->nullable();
            $table->text('remodal_year')->nullable();
            $table->text('amenities')->nullable();
            $table->text('equipment')->nullable();

            $table->tinyInteger('enable_extra_price')->nullable();
            $table->tinyInteger('property_type')->nullable()->default(1);
            $table->text('extra_price')->nullable();
            $table->text('discount_by_days')->nullable();

            //Extra Info
            $table->string('status',50)->nullable();
            $table->tinyInteger('default_state')->default(1)->nullable();
            $table->integer('view')->default(0)->nullable();
            $table->integer('review_score')->default(0)->nullable();
            $table->dateTime('recent_view')->nullable();

            $table->bigInteger('author_id')->nullable();
            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->softDeletes();

            $table->timestamps();
        });

        Schema::create('bc_property_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('origin_id')->unsigned();
            $table->string('locale')->index();

            //Info
            $table->string('title', 255)->nullable();
            $table->text('content')->nullable();
            $table->text('faqs')->nullable();
            $table->string('address', 255)->nullable();

            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->softDeletes();

            $table->timestamps();
        });

        Schema::create('bc_property_term', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('term_id')->nullable();
            $table->integer('target_id')->nullable();

            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->timestamps();

        });

        Schema::create('bc_property_dates', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->bigInteger('target_id')->nullable();

            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->decimal('price',12,2)->nullable();
            $table->tinyInteger('max_guests')->nullable();
            $table->tinyInteger('active')->default(0)->nullable();
            $table->text('note_to_customer')->nullable();
            $table->text('note_to_admin')->nullable();
            $table->tinyInteger('is_instant')->default(0)->nullable();

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
        Schema::dropIfExists('bc_properties');
        Schema::dropIfExists('bc_property_translations');
        Schema::dropIfExists('bc_property_term');
        Schema::dropIfExists('bc_property_dates');
    }
}
