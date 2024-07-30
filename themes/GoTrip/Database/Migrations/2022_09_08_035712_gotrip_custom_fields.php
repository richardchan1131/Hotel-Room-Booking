<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GoTripCustomFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('core_pages', function (Blueprint $table) {
            if (!Schema::hasColumn('core_pages', 'footer_style')) {
                $table->string('footer_style')->nullable();
            }
        });
        Schema::table('core_pages', function (Blueprint $table) {
            if (!Schema::hasColumn('core_pages', 'disable_subscribe_default')) {
                $table->tinyInteger('disable_subscribe_default')->default(0)->nullable();
            }
        });
        Schema::table('bravo_tour_category', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_tour_category', 'cat_icon')) {
                $table->string('cat_icon')->nullable();
            }
        });
        Schema::table('bravo_locations', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_locations', 'general_info')) {
                $table->text('general_info')->nullable();
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
        //
    }
}
