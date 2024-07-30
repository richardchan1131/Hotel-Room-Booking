<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('core_roles')) {
            Schema::create('core_roles', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('code', 50)->nullable();
                $table->decimal('commission')->nullable();
                $table->string('commission_type',40)->nullable()->default('default');

                $table->integer('create_user')->nullable();
                $table->integer('update_user')->nullable();

                $table->string('status', 30)->nullable();
                $table->timestamps();
            });
        }else{
            Schema::table('core_roles',function(Blueprint $table){
                if(!Schema::hasColumn('core_roles','code')){
                    $table->string('code', 50)->default(null);
                }
                if(!Schema::hasColumn('core_roles','create_user')){
                    $table->integer('create_user')->nullable();
                    $table->integer('update_user')->nullable();
                }
            });
        }

        if(!Schema::hasTable('core_role_permissions')) {
            Schema::create('core_role_permissions', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('role_id')->nullable();
                $table->string('permission')->nullable();

                $table->integer('create_user')->nullable();
                $table->integer('update_user')->nullable();

                $table->unique(['role_id', 'permission']);
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
        Schema::dropIfExists('core_roles');
        Schema::dropIfExists('core_role_permissions');
    }
}
