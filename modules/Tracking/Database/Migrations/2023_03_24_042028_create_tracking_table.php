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

        if(!Schema::hasTable('tracking_users')) {
            Schema::create('tracking_users', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->bigInteger('user_id')->nullable()->index();
                $table->bigInteger('device_id')->nullable()->index();
                $table->string('client_ip')->nullable()->index();
                $table->tinyInteger('is_robot')->nullable()->default(0);

                $table->timestamps();
            });
        }

        if(!Schema::hasTable('tracking_sessions')) {
            Schema::create('tracking_sessions', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->bigInteger('user_id')->nullable()->index();
                $table->bigInteger('device_id')->nullable()->index();
                $table->string('client_ip')->nullable()->index();
                $table->tinyInteger('is_robot')->default(0)->nullable();

                $table->timestamps();
            });
        }
        if(!Schema::hasTable('tracking_paths')) {
            Schema::create('tracking_paths', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->string('path')->index();

                $table->timestamps();
            });
        }
        if(!Schema::hasTable('tracking_events')) {
            Schema::create('tracking_events', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->string('name')->index();


                $table->timestamps();
            });
        }
        if(!Schema::hasTable('tracking_devices')) {
            Schema::create('tracking_devices', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->string('brand',50)->nullable();
                $table->string('model',50)->nullable();
                $table->string('platform',50)->nullable();
                $table->string('platform_version',50)->nullable();
                $table->string('browser',50)->nullable();
                $table->string('browser_version',50)->nullable();

                $table->tinyInteger('is_mobile')->nullable()->default(0);

                $table->timestamps();
            });
        }

        if(!Schema::hasTable('tracking_utms')) {
            Schema::create('tracking_utms', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->string('utm_campaign')->nullable();
                $table->string('utm_source')->nullable();
                $table->string('utm_medium')->nullable();
                $table->string('utm_content')->nullable();
                $table->string('utm_term')->nullable();

                $table->index(['utm_campaign','utm_source','utm_medium']);

                $table->timestamps();
            });
        }
        if(!Schema::hasTable('tracking_logs')) {
            Schema::create('tracking_logs', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->bigInteger('session_id')->nullable()->index();
                $table->bigInteger('user_id')->nullable()->index();
                $table->bigInteger('path_id')->nullable()->index();
                $table->bigInteger('event_id')->nullable()->index();
                $table->bigInteger('utm_id')->nullable()->index();
                $table->bigInteger('geoip_id')->nullable()->index();
                $table->bigInteger('device_id')->nullable()->index();
                $table->string('client_ip')->nullable()->index();

                $table->string('method',10)->nullable();
                $table->string('browser_lang',5)->nullable();
                $table->string('country',20)->nullable();

                $table->tinyInteger('is_ajax')->nullable()->default(0);

                $table->bigInteger('vendor_id')->nullable();
                $table->bigInteger('object_id')->nullable();
                $table->string('object_model',40)->nullable();

                $table->integer('year');
                $table->integer('month');
                $table->integer('day');
                $table->integer('hour');
                $table->integer('minute');

                $table->index(['year','month','day']);

                $table->index(['object_id','object_model']);

                $table->timestamps();
            });

        }
        if(!Schema::hasTable('tracking_geoip')) {
            Schema::create('tracking_geoip', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->double('lat')->nullable();
                $table->double('lng')->nullable();

                $table->string('country_code',10)->nullable();
                $table->string('country_name')->nullable();
                $table->string('city')->nullable()->index();
                $table->string('region')->nullable();
                $table->string('postal_code')->nullable();
                $table->string('area_code')->nullable();
                $table->string('continent_code')->nullable();

                $table->index('country_code');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracking_users');
        Schema::dropIfExists('tracking_sessions');
        Schema::dropIfExists('tracking_paths');
        Schema::dropIfExists('tracking_events');
        Schema::dropIfExists('tracking_devices');
        Schema::dropIfExists('tracking_utms');
        Schema::dropIfExists('tracking_logs');
        Schema::dropIfExists('tracking_geoip');
    }
};
