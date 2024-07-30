<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if(Schema::hasTable('personal_access_tokens')){
            Schema::table('personal_access_tokens',function(Blueprint $blueprint){
                if(!Schema::hasColumn('personal_access_tokens','expires_at')){
                    $blueprint->timestamp('expires_at')->nullable();
                }
            });
        }
    }

    public function down(): void
    {

    }
};
