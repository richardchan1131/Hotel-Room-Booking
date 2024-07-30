<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaFolderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_folders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('parent_id')->nullable()->default(0);
            $table->bigInteger('user_id')->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();

            $table->unique(['parent_id','name']);

            $table->timestamps();
        });

        Schema::table('media_files', function (Blueprint $table) {
            if (!Schema::hasColumn('media_files', 'folder_id')) {
                $table->bigInteger('folder_id')->nullable()->default(0);
            }
            if (!Schema::hasColumn('media_files', 'driver')) {
                $table->string('driver',255)->nullable();
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
        Schema::dropIfExists('media_folders');
    }
}
