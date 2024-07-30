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
        Schema::table('bravo_coupons', function (Blueprint $table) {
            if(!Schema::hasColumn('bravo_coupons','author_id')){
                $table->bigInteger('author_id')->nullable();
            }
            if(!Schema::hasColumn('bravo_coupons','is_vendor')){
                $table->smallInteger('is_vendor')->nullable();
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
};
