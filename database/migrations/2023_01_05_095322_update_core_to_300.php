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

        Schema::table('users',function(Blueprint $blueprint){
            if(!Schema::hasColumn('users','role_id')){
                $blueprint->bigInteger('role_id')->nullable();
            }
        });

        $tableAddAuthorId = [
            'media_files',
            'bravo_review',
            'core_news',
            'core_pages',
            'bravo_services',
        ];
        foreach ($tableAddAuthorId as $tbName){
            Schema::table($tbName,function(Blueprint $blueprint) use ($tbName){
                if(!Schema::hasColumn($tbName,'author_id')){
                    $blueprint->bigInteger('author_id')->nullable();
                }
            });
        }

        //-----------------------------------------------------------------------

        $tableAddUserId = [
            'bravo_user_plan',
            'bravo_booking_payments'
        ];
        foreach ($tableAddUserId as $tbName){
            if(Schema::hasTable($tbName)) {
                Schema::table($tbName, function (Blueprint $blueprint) use ($tbName) {
                    if (!Schema::hasColumn($tbName, 'user_id')) {
                        $blueprint->bigInteger('user_id')->nullable();
                    }
                });
            }
        }

        Schema::table('media_files', function (Blueprint $table) {
            if (!Schema::hasColumn('media_files', 'folder_id')) {
                $table->bigInteger('folder_id')->nullable()->default(0);
            }
            if(!Schema::hasColumn('media_files','file_edit')){
                $table->tinyInteger('file_edit')->default(0)->nullable();
            }
            if(!Schema::hasColumn('media_files','driver')){
                $table->string('driver',255)->nullable();
            }
        });
        Schema::table('core_pages', function (Blueprint $table) {
            if (!Schema::hasColumn('core_pages', 'show_template')) {
                $table->tinyInteger('show_template')->nullable();
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
};
