<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFrom110To120 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if(!Schema::hasColumn('users','locale')) {
                $table->string('locale', 10)->nullable();
            }
        });

        Schema::table('core_news_category', function (Blueprint $table) {
            if(!Schema::hasColumn('core_news_category','origin_id')) {
                $table->bigInteger('origin_id')->nullable();
                $table->string('lang', 10)->nullable();
            }
        });

        Schema::table('bravo_attrs', function (Blueprint $table) {
            if(!Schema::hasColumn('bravo_attrs','deleted_at')) {
                $table->softDeletes();
            }
        });
        Schema::table('bravo_terms', function (Blueprint $table) {
            if(!Schema::hasColumn('bravo_terms','deleted_at')) {
                $table->softDeletes();
                $table->integer('image_id')->nullable();
            }
        });

        $this->createTranslationTables();
    }

    public function createTranslationTables(){

        Schema::create('bravo_tour_translations', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('origin_id')->nullable();
            $table->string('locale',10)->nullable();

            //Tour info
            $table->string('title', 255)->nullable();
            $table->string('slug',255)->charset('utf8')->index();
            $table->text('content')->nullable();
            $table->text('short_desc')->nullable();
            $table->string('address', 255)->nullable();
            $table->text('faqs')->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();

            $table->unique(['origin_id', 'locale']);
            $table->timestamps();
        });


        Schema::create('bravo_tour_category_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('origin_id')->nullable();
            $table->string('locale',10)->nullable();

            $table->string('name',255)->nullable();
            $table->text('content')->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->unique(['origin_id', 'locale']);
            $table->timestamps();
        });




    }

    /**
     * Reverse the migrations.
     *y
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('bravo_tour_translations');
        Schema::dropIfExists('bravo_tour_category_translations');
    }
}
