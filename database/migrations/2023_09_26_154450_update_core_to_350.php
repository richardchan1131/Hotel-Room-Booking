<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('core_news', function (Blueprint $table) {
            if (!Schema::hasColumn('core_news', 'gallery')) {
                $table->string('gallery', 255)->nullable();
            }
        });
        Schema::table('media_files', function (Blueprint $table) {
            if (!Schema::hasColumn('media_files', 'is_private')) {
                $table->tinyInteger('is_private')->nullable()->default(0);
            }
        });
        Schema::table('bravo_terms', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_terms', 'icon')) {
                $table->string('icon')->nullable();
            }
        });

        if (!Schema::hasColumn('bravo_locations', 'gallery')) {
            Schema::table('bravo_locations', function (Blueprint $table) {
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
