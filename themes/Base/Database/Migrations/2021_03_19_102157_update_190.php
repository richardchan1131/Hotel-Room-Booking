<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\Service;
use Modules\Booking\Models\ServiceTranslation;
use Modules\Car\Models\Car;
use Modules\Event\Models\Event;
use Modules\Event\Models\EventTranslation;
use Modules\Hotel\Models\Hotel;
use Modules\Hotel\Models\HotelTranslation;
use Modules\Location\Models\LocationCategory;
use Modules\Location\Models\LocationCategoryTranslation;
use Modules\Space\Models\Space;
use Modules\Space\Models\SpaceTranslation;
use Modules\Tour\Models\Tour;
use Modules\Tour\Models\TourTranslation;

class Update190 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tour::getTableName(), function (Blueprint $table) {
            if (!Schema::hasColumn(Tour::getTableName(), 'service_fee')) {
                $table->tinyInteger('enable_service_fee')->nullable();
                $table->text('service_fee')->nullable();
            }
        });
        Schema::table(Space::getTableName(), function (Blueprint $table) {
            if (!Schema::hasColumn(Space::getTableName(), 'service_fee')) {
                $table->tinyInteger('enable_service_fee')->nullable();
                $table->text('service_fee')->nullable();
            }
        });
        Schema::table(Hotel::getTableName(), function (Blueprint $table) {
            if (!Schema::hasColumn(Hotel::getTableName(), 'service_fee')) {
                $table->tinyInteger('enable_service_fee')->nullable();
                $table->text('service_fee')->nullable();
            }
        });
        Schema::table(Car::getTableName(), function (Blueprint $table) {
            if (!Schema::hasColumn(Car::getTableName(), 'service_fee')) {
                $table->tinyInteger('enable_service_fee')->nullable();
                $table->text('service_fee')->nullable();
            }
        });
        Schema::table(Event::getTableName(), function (Blueprint $table) {
            if (!Schema::hasColumn(Event::getTableName(), 'service_fee')) {
                $table->tinyInteger('enable_service_fee')->nullable();
                $table->text('service_fee')->nullable();
            }
        });

        Schema::table(Booking::getTableName(), function (Blueprint $table) {
            if (!Schema::hasColumn(Booking::getTableName(), 'vendor_service_fee_amount')) {
                $table->decimal('vendor_service_fee_amount')->nullable();
            }
            if (!Schema::hasColumn(Booking::getTableName(), 'vendor_service_fee')) {
                $table->text('vendor_service_fee')->nullable();
            }
        });


        Schema::table(Hotel::getTableName(), function (Blueprint $table) {
            if (!Schema::hasColumn(Hotel::getTableName(), 'surrounding')) {
                $table->text('surrounding')->nullable();
            }
        });
        Schema::table(HotelTranslation::getTableName(), function (Blueprint $table) {
            if (!Schema::hasColumn(HotelTranslation::getTableName(), 'surrounding')) {
                $table->text('surrounding')->nullable();
            }
        });

        Schema::table(Tour::getTableName(), function (Blueprint $table) {
            if (!Schema::hasColumn(Tour::getTableName(), 'surrounding')) {
                $table->text('surrounding')->nullable();
            }
        });
        Schema::table(TourTranslation::getTableName(), function (Blueprint $table) {
            if (!Schema::hasColumn(TourTranslation::getTableName(), 'surrounding')) {
                $table->text('surrounding')->nullable();
            }
        });

        Schema::table(Space::getTableName(), function (Blueprint $table) {
            if (!Schema::hasColumn(Space::getTableName(), 'surrounding')) {
                $table->text('surrounding')->nullable();
            }
        });
        Schema::table(SpaceTranslation::getTableName(), function (Blueprint $table) {
            if (!Schema::hasColumn(SpaceTranslation::getTableName(), 'surrounding')) {
                $table->text('surrounding')->nullable();
            }
        });
        Schema::table(Event::getTableName(), function (Blueprint $table) {
            if (!Schema::hasColumn(Event::getTableName(), 'surrounding')) {
                $table->text('surrounding')->nullable();
            }
        });
        Schema::table(EventTranslation::getTableName(), function (Blueprint $table) {
            if (!Schema::hasColumn(EventTranslation::getTableName(), 'surrounding')) {
                $table->text('surrounding')->nullable();
            }
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
