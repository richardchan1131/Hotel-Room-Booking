<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Booking\Models\Service;
use Modules\Booking\Models\ServiceTranslation;
use Modules\Location\Models\LocationCategory;
use Modules\Location\Models\LocationCategoryTranslation;

class UpdateCore190 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable((new LocationCategory())->getTable())) {
            Schema::create((new LocationCategory())->getTable(), function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name', 255)->nullable();
                $table->string('icon_class', 255)->nullable();
                $table->text('content')->nullable();
                $table->string('slug', 255)->nullable();
                $table->string('status', 50)->nullable();
                $table->nestedSet();

                $table->integer('create_user')->nullable();
                $table->integer('update_user')->nullable();
                $table->softDeletes();

                //Languages
                $table->bigInteger('origin_id')->nullable();
                $table->string('lang', 10)->nullable();

                $table->timestamps();
            });
        }

        if (!Schema::hasTable((new LocationCategoryTranslation())->getTable())) {
            Schema::create((new LocationCategoryTranslation())->getTable(), function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('origin_id')->nullable();
                $table->string('locale', 10)->nullable();

                $table->string('name', 255)->nullable();
                $table->text('content')->nullable();

                $table->integer('create_user')->nullable();
                $table->integer('update_user')->nullable();
                $table->unique(['origin_id', 'locale']);
                $table->timestamps();
            });
        }
        Schema::table("users", function (Blueprint $table) {
            if (!Schema::hasColumn("users", 'user_name')) {
                $table->string('user_name')->nullable()->unique();
            }
        });

        if (!Schema::hasTable((new Service())->getTable())) {
            Schema::create((new Service())->getTable(), function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->string('title', 255)->nullable();
                $table->string('slug', 255)->charset('utf8')->index();
                $table->integer('category_id')->nullable();
                $table->integer('location_id')->nullable();
                $table->string('address', 255)->nullable();
                $table->string('map_lat', 20)->nullable();
                $table->string('map_lng', 20)->nullable();
                $table->tinyInteger('is_featured')->nullable();
                $table->tinyInteger('star_rate')->nullable();
                //Price
                $table->decimal('price', 12, 2)->nullable();
                $table->decimal('sale_price', 12, 2)->nullable();

                //Tour type
                $table->integer('min_people')->nullable();
                $table->integer('max_people')->nullable();
                $table->integer('max_guests')->nullable();
                $table->integer('review_score')->nullable();
                $table->integer('min_day_before_booking')->nullable();
                $table->integer('min_day_stays')->nullable();
                $table->integer('object_id')->nullable();
                $table->string('object_model', 255)->nullable();
                $table->string('status', 50)->nullable();

                $table->integer('create_user')->nullable();
                $table->integer('update_user')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable((new ServiceTranslation())->getTable())) {
            Schema::create((new ServiceTranslation())->getTable(), function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('origin_id')->nullable();
                $table->string('locale', 10)->nullable();

                $table->string('title', 255)->nullable();
                $table->text('address')->nullable();
                $table->text('content')->nullable();

                $table->integer('create_user')->nullable();
                $table->integer('update_user')->nullable();
                $table->unique(['origin_id', 'locale']);
                $table->timestamps();
            });
        }
        if(!Schema::hasTable('bravo_booking_payments')) {
            Schema::create('bravo_booking_payments', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('code', 64)->nullable();
                $table->bigInteger('object_id')->nullable();
                $table->string('object_model', 40)->nullable();
                $table->text('meta')->nullable();

                $table->integer('booking_id')->nullable();
                $table->string('payment_gateway', 50)->nullable();

                $table->decimal('amount', 10, 2)->nullable();
                $table->string('currency', 10)->nullable();

                $table->decimal('converted_amount', 10, 2)->nullable();
                $table->string('converted_currency', 10)->nullable();
                $table->decimal('exchange_rate', 10, 2)->nullable();

                $table->string('status', 30)->nullable();
                $table->text('logs')->nullable();

                $table->integer('create_user')->nullable();
                $table->integer('update_user')->nullable();
                $table->softDeletes();
                $table->bigInteger('wallet_transaction_id')->nullable();

                $table->timestamps();
            });
        }
        Schema::table('bravo_review', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_review', 'vendor_id')) {
                $table->bigInteger('vendor_id')->nullable();
            }
        });
        Schema::table('bravo_attrs', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_attrs', 'display_type')) {
                $table->string('display_type',255)->nullable();
            }
            if (!Schema::hasColumn('bravo_attrs', 'hide_in_single')) {
                $table->tinyInteger('hide_in_single')->nullable();
            }
        });
        if (!Schema::hasTable('user_wishlist')) {
            Schema::create('user_wishlist', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('object_id')->nullable();
                $table->string('object_model', 255)->nullable();
                $table->integer('user_id')->nullable();
                $table->integer('create_user')->nullable();
                $table->integer('update_user')->nullable();
                $table->timestamps();
            });
        }
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'verify_submit_status')) {
                $table->string('verify_submit_status',30)->nullable();
            }
            if (!Schema::hasColumn('users', 'is_verified')) {
                $table->smallInteger('is_verified')->nullable();
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
        Schema::dropIfExists('user_wishlist');
        Schema::dropIfExists('bravo_booking_payments');
    }
}
