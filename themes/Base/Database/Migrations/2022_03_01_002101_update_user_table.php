<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserTable extends Migration
{
	public function up()
	{
		Schema::table('users', function (Blueprint $table) {
			//
            if (!Schema::hasColumn('users', 'stripe_customer_id')) {
                $table->string('stripe_customer_id')->nullable();
            }
            if (!Schema::hasColumn('users', 'vendor_commission_amount')) {
                $table->integer('vendor_commission_amount')->nullable();
            }
            if (!Schema::hasColumn('users', 'total_before_fees')) {
                $table->decimal('total_before_fees', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('users', 'vendor_commission_type')) {
                $table->string('vendor_commission_type', 30)->nullable();
            }
		});
	}

	public function down()
	{
		Schema::table('users', function (Blueprint $table) {
			//
            $table->dropColumn('stripe_customer_id');
            $table->dropColumn('total_before_fees');
            $table->dropColumn('vendor_commission_type');
            $table->dropColumn('vendor_commission_amount');
		});
	}
}
