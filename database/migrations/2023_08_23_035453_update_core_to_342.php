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
        if (!Schema::hasColumn("users", 'review_score')) {
            Schema::table("users", function (Blueprint $table) {
                $table->decimal('review_score', 2, 1)->nullable();
            });
        }
        if (!Schema::hasColumn('bravo_plans', 'image_id')) {
            Schema::table('bravo_plans', function (Blueprint $table) {
                $table->integer('image_id')->nullable();
            });
        }
        if (!Schema::hasColumn('core_news', 'gallery')) {
            Schema::table('core_news', function (Blueprint $table) {
                $table->string('gallery')->nullable();
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
    }
};
