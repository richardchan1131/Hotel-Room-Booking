<?php

namespace Themes\Base\Core\Middleware;

use App\User;
use Closure;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\Service;
use Modules\Booking\Models\ServiceTranslation;
use Modules\Car\Models\Car;
use Modules\Car\Models\CarTranslation;
use Modules\Core\Models\NotificationPush;
use Modules\Core\Models\Settings;
use Modules\Event\Models\Event;
use Modules\Event\Models\EventTranslation;
use Modules\Flight\Models\BookingPassengers;
use Modules\Flight\Models\Flight;
use Modules\Flight\Models\FlightSeat;
use Modules\Hotel\Models\Hotel;
use Modules\Hotel\Models\HotelRoom;
use Modules\Hotel\Models\HotelTranslation;
use Modules\Location\Models\LocationCategory;
use Modules\Location\Models\LocationCategoryTranslation;
use Modules\Review\Models\Review;
use Modules\Space\Models\Space;
use Modules\Space\Models\SpaceTranslation;
use Modules\Tour\Models\Tour;
use Modules\Tour\Models\TourTranslation;
use Modules\User\Emails\CreditPaymentEmail;
use Modules\User\Helpers\PermissionHelper;
use Modules\User\Models\Role;
use Themes\Base\Core\Updaters\Updater250;
use Themes\Base\Core\Updaters\Updater300;
use Themes\Base\Core\Updaters\Updater310;
use Themes\Base\Core\Updaters\Updater340;
use Themes\Base\Core\Updaters\Updater350;

class RunUpdater
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (strpos($request->path(), 'install') === false && file_exists(storage_path().'/installed') and !app()->runningInConsole()) {

            $this->updateTo110();
            $this->updateTo120();
            $this->updateTo130();
            $this->updateTo140();
            $this->updateTo150();
            $this->updateTo151();
            $this->updateTo160();
            $this->updateTo170();
            $this->updateTo180();
            $this->updateTo190();
            $this->updateTo200();
            $this->updateTo210();
            $this->updateTo220();
            $this->updateTo230();
            $this->updateTo240();
            Updater250::run();
            Updater300::run();
            Updater310::run();
            Updater340::run();
            Updater350::run();
        }
        return $next($request);
    }

    public function updateTo192()
    {
        if (setting_item('update_to_192')) {
            return false;
        }

        Artisan::call('migrate', [
            '--force' => true,
        ]);



        Artisan::call('cache:clear');
    }
    public function updateTo110()
    {
        if (setting_item('update_to_110')) {
            return false;
        }
        Artisan::call('migrate', [
            '--force' => true,
        ]);
        $vendor = Role::firstOrCreate(['name'=>'vendor']);
        $vendor->givePermission('media_upload');
        $vendor->givePermission('tour_view');
        $vendor->givePermission('tour_create');
        $vendor->givePermission('tour_update');
        $vendor->givePermission('tour_delete');
        $vendor->givePermission('dashboard_vendor_access');
        $role = Role::firstOrCreate(['name'=>'administrator']);
        $role->givePermission('dashboard_vendor_access');
        Settings::store('update_to_110', true);
        Artisan::call('cache:clear');
    }

    public function updateTo120()
    {
        if (setting_item('update_to_120')) {
            return false;
        }
        Artisan::call('migrate', [
            '--force' => true,
        ]);
        // Vendor
        $vendor = Role::firstOrCreate(['name'=>'vendor']);
        $vendor->givePermission('space_create');
        $vendor->givePermission('space_view');
        $vendor->givePermission('space_update');
        $vendor->givePermission('space_delete');
        // Admin
        $role = Role::firstOrCreate(['name'=>'administrator']);
        $role->givePermission('space_view');
        $role->givePermission('space_create');
        $role->givePermission('space_update');
        $role->givePermission('space_delete');
        $role->givePermission('space_manage_others');
        $role->givePermission('space_manage_attributes');

        if (empty(setting_item('topbar_left_text'))) {
            DB::table('core_settings')->insert(
                [
                    'name'  => 'topbar_left_text',
                    'val'   => '<div class="socials">
<a href="#"><i class="fa fa-facebook"></i></a>
<a href="#"><i class="fa fa-linkedin"></i></a>
<a href="#"><i class="fa fa-google-plus"></i></a>
</div>
<span class="line"></span>
<a href="mailto:contact@bookingcore.com">contact@bookingcore.com</a>',
                    'group' => "general",
                ]
            );
        }
        Settings::store('update_to_120', true);
        Artisan::call('cache:clear');
    }

    public function updateTo130()
    {
        if (setting_item('update_to_130')) {
            return false;
        }
        Artisan::call('migrate', [
            '--force' => true,
        ]);
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'vendor_commission_amount')) {
                $table->integer('vendor_commission_amount')->nullable();
                $table->decimal('total_before_fees', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('users', 'vendor_commission_type')) {
                $table->string('vendor_commission_type', 30)->nullable();
            }
        });
        $this->__updateReviewVendorId();
        // Fix null status user
        User::query()->whereRaw('status is NULL')->update([
            'status' => 'publish'
        ]);
        Settings::store('update_to_130', true);
        Artisan::call('cache:clear');
    }

    public function updateTo140()
    {

        if (setting_item('update_to_140')) {
            return false;
        }
        Artisan::call('migrate', [
            '--force' => true,
        ]);

        // Admin
        $role = Role::firstOrCreate(['name'=>'administrator']);
        $role->givePermission('vendor_payout_view');
        $role->givePermission('vendor_payout_manage');
        $role->givePermission('hotel_view');
        $role->givePermission('hotel_create');
        $role->givePermission('hotel_update');
        $role->givePermission('hotel_delete');
        $role->givePermission('hotel_manage_others');
        $role->givePermission('hotel_manage_attributes');

        $vendor = Role::firstOrCreate(['name'=>'vendor']);
        $vendor->givePermission('hotel_view');
        $vendor->givePermission('hotel_create');
        $vendor->givePermission('hotel_update');
        $vendor->givePermission('hotel_delete');

        Settings::store('update_to_140', true);
        Artisan::call('cache:clear');
    }

    public function updateTo150()
    {
        if (setting_item('update_to_150')) {
            return false;
        }
        Artisan::call('migrate', [
            '--force' => true,
        ]);
        $role = Role::firstOrCreate(['name'=>'administrator']);
        $role->givePermission('plugin_manage');

        // Vendor
        $vendor = Role::firstOrCreate(['name'=>'vendor']);
        $vendor->givePermission('car_create');
        $vendor->givePermission('car_view');
        $vendor->givePermission('car_update');
        $vendor->givePermission('car_delete');
        // Admin
        $role = Role::firstOrCreate(['name'=>'administrator']);
        $role->givePermission('car_view');
        $role->givePermission('car_create');
        $role->givePermission('car_update');
        $role->givePermission('car_delete');
        $role->givePermission('car_manage_others');
        $role->givePermission('car_manage_attributes');

        Settings::store('update_to_150', true);
        Artisan::call('cache:clear');
    }

    public function updateTo151()
    {
        if (setting_item('update_to_151')) {
            return false;
        }
        Artisan::call('migrate', [
            '--force' => true,
        ]);
        $allServices = get_bookable_services();
        foreach ($allServices as $k=>$service) {
            if(in_array($k,['plan'])) continue;
            $alls = $service::query()->whereNull('review_score')->get();
            if (!empty($alls)) {
                foreach ($alls as $item) {
                    $item->update_service_rate();
                }
            }
        }

        Schema::table(Tour::getTableName(), function (Blueprint $table) {
            if (!Schema::hasColumn(Tour::getTableName(), 'ical_import_url')) {
                $table->string('ical_import_url')->nullable();
            }
        });
        Schema::table(Space::getTableName(), function (Blueprint $table) {
            if (!Schema::hasColumn(Space::getTableName(), 'ical_import_url')) {
                $table->string('ical_import_url')->nullable();
            }
        });
        Schema::table(Hotel::getTableName(), function (Blueprint $table) {
            if (!Schema::hasColumn(Hotel::getTableName(), 'ical_import_url')) {
                $table->string('ical_import_url')->nullable();
            }
        });
        Schema::table(Car::getTableName(), function (Blueprint $table) {
            if (!Schema::hasColumn(Car::getTableName(), 'ical_import_url')) {
                $table->string('ical_import_url')->nullable();
            }
        });

        Schema::table(CarTranslation::getTableName(), function (Blueprint $table) {
            if (Schema::hasColumn(CarTranslation::getTableName(), 'extra_price')) {
                $table->dropColumn('extra_price');
            }
        });
        Schema::table(SpaceTranslation::getTableName(), function (Blueprint $table) {
            if (Schema::hasColumn(SpaceTranslation::getTableName(), 'extra_price')) {
                $table->dropColumn('extra_price');
            }
        });


        DB::statement('ALTER TABLE bravo_spaces MODIFY bed integer');
        DB::statement('ALTER TABLE bravo_spaces MODIFY bathroom integer');
        DB::statement('ALTER TABLE bravo_spaces MODIFY square integer');
        DB::statement('ALTER TABLE bravo_hotel_rooms MODIFY size integer');

        Settings::store('update_to_151', true);
        Artisan::call('cache:clear');
    }

    public function updateTo160()
    {
        if (setting_item('update_to_160')) {
            return false;
        }
        Artisan::call('migrate', [
            '--force' => true,
        ]);
        $bookings = Booking::query()->whereIn('status', [
            'paid',
            'completed',
            'completed',
        ])->whereRaw('IFNULL(deposit,0) <= 0 ')->get();
        foreach ($bookings as $booking) {
            if (!$booking->deposit) {
                $booking->paid = $booking->total;
                $booking->save();
            }
        }
        Schema::table(HotelRoom::getTableName(), function (Blueprint $table) {
            if (!Schema::hasColumn(HotelRoom::getTableName(), 'ical_import_url')) {
                $table->string('ical_import_url')->nullable();
            }
        });

        Settings::store('update_to_160', true);
        Artisan::call('cache:clear');
    }

    public function updateTo170()
    {
        if (setting_item('update_to_170')) {
            return false;
        }
        Artisan::call('migrate', [
            '--force' => true,
        ]);
        if (empty(setting_item('tour_map_search_fields'))) {
            DB::table('core_settings')->insert(
                [
                    'name'  => 'tour_map_search_fields',
                    'val'   => '[{"field":"location","attr":null,"position":"1"},{"field":"category","attr":null,"position":"2"},{"field":"date","attr":null,"position":"3"},{"field":"price","attr":null,"position":"4"},{"field":"advance","attr":null,"position":"5"}]',
                    'group' => 'tour'
                ]
            );
        }
        if (empty(setting_item('tour_search_fields'))) {
            DB::table('core_settings')->insert(
                [
                    'name'  => 'tour_search_fields',
                    'val'   => '[{"title":"Location","field":"location","size":"6","position":"1"},{"title":"From - To","field":"date","size":"6","position":"2"}]',
                    'group' => 'tour'
                ]
            );
        }
        if (empty(setting_item('space_search_fields'))) {
            DB::table('core_settings')->insert(
                [
                    'name'  => 'space_search_fields',
                    'val'   => '[{"title":"Location","field":"location","size":"4","position":"1"},{"title":"From - To","field":"date","size":"4","position":"2"},{"title":"Guests","field":"guests","size":"4","position":"3"}]',
                    'group' => 'tour'
                ]
            );
        }
        if (empty(setting_item('hotel_search_fields'))) {
            DB::table('core_settings')->insert(
                [
                    'name'  => 'hotel_search_fields',
                    'val'   => '[{"title":"Location","field":"location","size":"4","position":"1"},{"title":"Check In - Out","field":"date","size":"4","position":"2"},{"title":"Guests","field":"guests","size":"4","position":"3"}]',
                    'group' => 'hotel'
                ]
            );
        }
        if (empty(setting_item('car_search_fields'))) {
            DB::table('core_settings')->insert(
                [
                    'name'  => 'car_search_fields',
                    'val'   => '[{"title":"Location","field":"location","size":"6","position":"1"},{"title":"From - To","field":"date","size":"6","position":"2"}]',
                    'group' => 'car'
                ]
            );
        }

        if (empty(setting_item('enable_mail_vendor_registered'))) {
            DB::table('core_settings')->insert(
                [
                    'name'  => 'enable_mail_vendor_registered',
                    'val'   => '1',
                    'group' => 'vendor'
                ]
            );
            DB::table('core_settings')->insert(
                [
                    'name'  => 'vendor_content_email_registered',
                    'val'   => '<h1 style="text-align: center;">Welcome!</h1>
                        <h3>Hello [first_name] [last_name]</h3>
                        <p>Thank you for signing up with Booking Core! We hope you enjoy your time with us.</p>
                        <p>Regards,</p>
                        <p>Booking Core</p>',
                    'group' => 'vendor'
                ]
            );
        }
        if (empty(setting_item('admin_enable_mail_vendor_registered'))) {
            DB::table('core_settings')->insert(
                [
                    'name'  => 'admin_enable_mail_vendor_registered',
                    'val'   => '1',
                    'group' => 'vendor'
                ]
            );
            DB::table('core_settings')->insert(
                [
                    'name'  => 'admin_content_email_vendor_registered',
                    'val'   => '<h3>Hello Administrator</h3>
                        <p>An user has been registered as Vendor. Please check the information bellow:</p>
                        <p>Full name: [first_name] [last_name]</p>
                        <p>Email: [email]</p>
                        <p>Registration date: [created_at]</p>
                        <p>You can approved the request here: [link_approved]</p>
                        <p>Regards,</p>
                        <p>Booking Core</p>',
                    'group' => 'vendor'
                ]
            );
        }
        if (empty(setting_item('booking_enquiry_enable_mail_to_vendor_content'))) {
            DB::table('core_settings')->insert([
                [
                    'name'  => "booking_enquiry_enable_mail_to_vendor_content",
                    'val'   => "<h3>Hello [vendor_name]</h3>
                        <p>You get new inquiry request from [email]</p>
                        <p>Name :[name]</p>
                        <p>Emai:[email]</p>
                        <p>Phone:[phone]</p>
                        <p>Content:[note]</p>
                        <p>Service:[service_link]</p>
                        <p>Regards,</p>
                        <p>Booking Core</p>
                        </div>",
                    'group' => "enquiry",
                ]
            ]);
        }
        if (empty(setting_item('booking_enquiry_enable_mail_to_admin_content'))) {
            DB::table('core_settings')->insert([
                [
                    'name'  => "booking_enquiry_enable_mail_to_admin_content",
                    'val'   => "<h3>Hello Administrator</h3>
                        <p>You get new inquiry request from [email]</p>
                        <p>Name :[name]</p>
                        <p>Emai:[email]</p>
                        <p>Phone:[phone]</p>
                        <p>Content:[note]</p>
                        <p>Service:[service_link]</p>
                        <p>Vendor:[vendor_link]</p>
                        <p>Regards,</p>
                        <p>Booking Core</p>",
                    'group' => "enquiry",
                ],
            ]);
        }

        Schema::table('bravo_spaces', function (Blueprint $table) {
            if (Schema::hasColumn('bravo_spaces', 'square')) {
                DB::statement('ALTER TABLE bravo_spaces MODIFY square integer');
            }
            if (Schema::hasColumn('bravo_spaces', 'max_guests')) {
                DB::statement('ALTER TABLE bravo_spaces MODIFY max_guests integer');
            }
        });

        // Admin
        $role = Role::firstOrCreate(['name'=>'administrator']);
        $role->givePermission('enquiry_view');
        $role->givePermission('enquiry_update');
        $role->givePermission('enquiry_manage_others');
        $role->givePermission('event_view');
        $role->givePermission('event_create');
        $role->givePermission('event_update');
        $role->givePermission('event_delete');
        $role->givePermission('event_manage_others');
        $role->givePermission('event_manage_attributes');

        // Vendor
        $role = Role::firstOrCreate(['name'=>'vendor']);
        $role->givePermission('enquiry_view');
        $role->givePermission('enquiry_update');
        $role->givePermission('event_view');
        $role->givePermission('event_create');
        $role->givePermission('event_update');
        $role->givePermission('event_delete');

        Settings::store('update_to_170', true);
        Artisan::call('cache:clear');
    }

    public function updateTo180()
    {
        if (setting_item('update_to_182')) {
            return "Updated Up 1.8.2";
        }

        Artisan::call('migrate', [
            '--force' => true,
        ]);

        setting_update_item('wallet_credit_exchange_rate', 1);
        setting_update_item('wallet_deposit_rate', 1);
        setting_update_item('wallet_deposit_type', 'list');
        setting_update_item('wallet_deposit_lists', [
            ['name' => __("100$"), 'amount' => 100, 'credit' => 100],
            ['name' => __("Bonus 10%"), 'amount' => 500, 'credit' => 550],
            ['name' => __("Bonus 15%"), 'amount' => 1000, 'credit' => 1150],
        ]);

        setting_update_item('wallet_new_deposit_admin_subject', 'New credit purchase');
        setting_update_item('wallet_new_deposit_admin_content', CreditPaymentEmail::defaultNewBody());
        setting_update_item('wallet_new_deposit_customer_subject', 'Thank you for your purchasing');
        setting_update_item('wallet_new_deposit_customer_content', CreditPaymentEmail::defaultNewBody());

        setting_update_item('wallet_update_deposit_admin_subject', 'Credit purchase updated');
        setting_update_item('wallet_update_deposit_admin_content', CreditPaymentEmail::defaultUpdateBody());
        setting_update_item('wallet_update_deposit_customer_subject', 'Your credit purchase updated');
        setting_update_item('wallet_update_deposit_customer_content', CreditPaymentEmail::defaultUpdateBody());

        Schema::table('bravo_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_bookings', 'wallet_credit_used')) {
                $table->double('wallet_credit_used')->nullable();// Credit used
                $table->double('wallet_total_used')->nullable();// Credit in total (after exchange credit to money)
            }
            if (!Schema::hasColumn('bravo_bookings', 'wallet_transaction_id')) {
                $table->bigInteger('wallet_transaction_id')->nullable();// Credit used
            }
            if (!Schema::hasColumn('bravo_bookings', 'is_refund_wallet')) {
                $table->tinyInteger('is_refund_wallet')->nullable();// Credit used
            }
        });

        Schema::table('bravo_booking_payments', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_booking_payments', 'code')) {
                $table->string('code', 64)->nullable();
                $table->bigInteger('object_id')->nullable();
                $table->string('object_model', 40)->nullable();
                $table->text('meta')->nullable();
            }
            if (!Schema::hasColumn('bravo_booking_payments', 'deleted_at')) {
                $table->softDeletes();
            }
            if (!Schema::hasColumn('bravo_booking_payments', 'wallet_transaction_id')) {
                $table->bigInteger('wallet_transaction_id')->nullable();
            }
        });

        Schema::table('bravo_spaces', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_spaces', 'min_day_before_booking')) {
                $table->integer('min_day_before_booking')->nullable();
            }
            if (!Schema::hasColumn('bravo_spaces', 'min_day_stays')) {
                $table->integer('min_day_stays')->nullable();
            }
        });

        Schema::table('bravo_hotels', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_hotels', 'min_day_before_booking')) {
                $table->integer('min_day_before_booking')->nullable();
            }
            if (!Schema::hasColumn('bravo_hotels', 'min_day_stays')) {
                $table->integer('min_day_stays')->nullable();
            }
        });

        Settings::store('update_to_182', true);

    }

    public function updateTo190()
    {
        if (setting_item('update_to_190')) {
            return "Updated Up 1.9.0";
        }

        Artisan::call('migrate', [
            '--force' => true,
        ]);

        $this->__seedLocationCategory();
        Settings::store('update_to_190', true);
        Artisan::call('cache:clear');
    }

    public function updateTo200()
    {
        $version = '2.0.9';
        if (version_compare(setting_item('update_to_200'), $version, '>=')) return;

        Artisan::call('migrate', [
            '--force' => true,
        ]);

        Schema::table('bravo_attrs', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_attrs', 'hide_in_filter_search')) {
                $table->tinyInteger('hide_in_filter_search')->nullable();
            }
        });
        Schema::table('core_pages', function (Blueprint $table) {
            if (!Schema::hasColumn('core_pages', 'header_style')) {
                $table->string('header_style',255)->nullable();
            }
            if (!Schema::hasColumn('core_pages', 'custom_logo')) {
                $table->integer('custom_logo')->nullable();
            }
        });

        Schema::table('bravo_events', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_events', 'end_time')) {
                $table->string('end_time',255)->nullable();
            }
            if (!Schema::hasColumn('bravo_events', 'duration_unit')) {
                $table->string('duration_unit',255)->nullable();
            }
        });

        if (!Schema::hasTable("bravo_booking_time_slots")) {
            Schema::create("bravo_booking_time_slots", function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->integer('booking_id')->nullable();
                $table->bigInteger('object_id')->nullable();
                $table->string('object_model', 40)->nullable();
                $table->time('start_time')->nullable();
                $table->time('end_time')->nullable();
                $table->float('duration',255)->nullable();
                $table->string('duration_unit',255)->nullable();

                $table->integer('create_user')->nullable();
                $table->integer('update_user')->nullable();
                $table->timestamps();
            });
        }

        Schema::table('bravo_event_dates', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_event_dates', 'price')) {
                $table->decimal('price')->nullable();
            }
        });

        Schema::table('bravo_tours', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_tours', 'min_day_before_booking')) {
                $table->integer('min_day_before_booking')->nullable();
            }
        });

        Schema::table('bravo_hotel_rooms', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_hotel_rooms', 'min_day_stays')) {
                $table->integer('min_day_stays')->nullable();
            }
        });

        Schema::table('bravo_attrs', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_attrs', 'position')) {
                $table->smallInteger('position')->nullable();
            }
        });

        setting_update_item('update_to_200',$version);
        Artisan::call('cache:clear');
    }

    public function updateTo210()
    {
        $version = '2.1.0';
        if (version_compare(setting_item('update_to_210'), $version, '>=')) return;

        Artisan::call('migrate', [
            '--force' => true,
        ]);

        // Vendor
        $vendor = Role::firstOrCreate(['name'=>'vendor']);
        $vendor->givePermission('flight_create');
        $vendor->givePermission('flight_view');
        $vendor->givePermission('flight_update');
        $vendor->givePermission('flight_delete');
        // Admin
        $role = Role::firstOrCreate(['name'=>'administrator']);
        $role->givePermission('flight_view');
        $role->givePermission('flight_create');
        $role->givePermission('flight_update');
        $role->givePermission('flight_delete');
        $role->givePermission('flight_manage_others');
        $role->givePermission('flight_manage_attributes');

        Schema::table('bravo_cars', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_cars', 'min_day_before_booking')) {
                $table->integer('min_day_before_booking')->nullable();
            }
            if (!Schema::hasColumn('bravo_cars', 'min_day_stays')) {
                $table->integer('min_day_stays')->nullable();
            }
        });

        if (Schema::hasTable("user_wallets")) {
            Schema::table('user_wallets', function (Blueprint $table) {
                if (!Schema::hasColumn('user_wallets', 'meta')) {
                    $table->text('meta')->nullable();
                }
            });
        }

        setting_update_item('update_to_210',$version);
        Artisan::call('cache:clear');
    }

    public function updateTo220()
    {
        $version = '2.2.0.1';
        if (version_compare(setting_item('update_to_220'), $version, '>=')) return;

        Artisan::call('migrate', [
            '--force' => true,
        ]);
        Schema::table('bravo_service_translations', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_service_translations', 'deleted_at')) {
                $table->softDeletes();
            }
        });
        Schema::table('bravo_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_bookings', 'is_paid')) {
                $table->tinyInteger('is_paid')->nullable();
            }
        });

        $allServices = get_bookable_services();
        foreach ($allServices as $service) {
            $alls = $service::query()->orderBy('id', 'desc')->get();
            if (!empty($alls)) {
                foreach ($alls as $item) {  $item->save();$item->update_service_rate();
                }
            }
        }

        setting_update_item("search_open_tab",'current_tab');
        setting_update_item("map_clustering",'on');
        setting_update_item("map_fit_bounds",'on');

        Schema::table('media_files',function (Blueprint $table){
            if(!Schema::hasColumn('media_files','file_edit')){
                $table->tinyInteger('file_edit')->default(0)->nullable();
            }
        });

        $role = Role::firstOrCreate(['name'=>'administrator']);
        $role->givePermission(PermissionHelper::all());


        Schema::table('bravo_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_bookings', 'total_before_discount')) {
                $table->decimal('total_before_discount',10,2)->nullable()->default(0);
            }
            if (!Schema::hasColumn('bravo_bookings', 'coupon_amount')) {
                $table->decimal('coupon_amount',10,2)->nullable()->default(0);
            }
        });


        setting_update_item('update_to_220',$version);
        Artisan::call('cache:clear');
    }
    public function updateTo230()
    {
        $version = '2.3.0';
        if (version_compare(setting_item('update_to_230'), $version, '>=')) return;

        Artisan::call('migrate', [
            '--force' => true,
        ]);

        $role = Role::firstOrCreate(['name'=>'administrator']);
        $role->givePermission(PermissionHelper::all());

        setting_update_item('update_to_230',$version);
        Artisan::call('cache:clear');
    }
    public function updateTo240()
    {
        $version = '1.0.6';
        if (version_compare(setting_item('update_to_240'), $version, '>=')) return;

        Artisan::call('migrate', [
            '--force' => true,
        ]);

        $role = Role::firstOrCreate(['name'=>'administrator']);
        $role->givePermission(PermissionHelper::all());

        // Vendor
        $vendor = Role::firstOrCreate(['name'=>'vendor']);
        $vendor->givePermission('boat_create');
        $vendor->givePermission('boat_view');
        $vendor->givePermission('boat_update');
        $vendor->givePermission('boat_delete');

        DB::statement('ALTER TABLE bravo_coupons MODIFY only_for_user varchar(191)');

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'stripe_customer_id')) {
                $table->string('stripe_customer_id')->nullable();
            }
        });

        Schema::table('bravo_boats', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_boats', 'include')) {
                $table->text('include')->nullable();
            }
            if (!Schema::hasColumn('bravo_boats', 'exclude')) {
                $table->text('exclude')->nullable();
            }
        });
        Schema::table('bravo_boat_translations', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_boat_translations', 'include')) {
                $table->text('include')->nullable();
            }
            if (!Schema::hasColumn('bravo_boat_translations', 'exclude')) {
                $table->text('exclude')->nullable();
            }
        });
        Schema::table(NotificationPush::getTableName(),function (Blueprint $table){
            if(!Schema::hasColumn(NotificationPush::getTableName(),'for_admin')){
                $table->boolean('for_admin')->default(0)->nullable();
            }
        });

        setting_update_item('update_to_240',$version);

        Artisan::call('cache:clear');
    }


    protected function __updateReviewVendorId()
    {
        $all = Review::query()->whereNull('vendor_id')->get();
        if (!empty($all)) {
            foreach ($all as $item) {
                switch ($item->object_model) {
                    case "tour":
                        $tour = Tour::find($item->object_id);
                        if ($tour) {
                            $item->vendor_id = $tour->author_id;
                            $item->save();
                        }
                        break;
                    case "space":
                        $tour = Space::find($item->object_id);
                        if ($tour) {
                            $item->vendor_id = $tour->author_id;
                            $item->save();
                        }
                        break;
                }
            }
        }
    }

    protected function __seedLocationCategory()
    {
        if (LocationCategory::query()->count() == 0) {
            $argv = [
                [
                    'name'       => 'Education',
                    'icon_class' => 'icofont-education',
                    'status'     => 'publish'
                ],
                [
                    'name'       => 'Health',
                    'icon_class' => 'fa fa-hospital-o',
                    'status'     => 'publish'
                ],
                [
                    'name'       => 'Transportation',
                    'icon_class' => 'fa fa-subway',
                    'status'     => 'publish'
                ],
            ];
            LocationCategory::insert($argv);
        }
    }
    protected function removeForeignKey(){
        try {
            $flightForeignKey = $this->getForeignKeyByTable(Flight::getTableName());
            Schema::table(Flight::getTableName(),function(Blueprint $blueprint)use ($flightForeignKey){
                foreach ($flightForeignKey as $key){
                    $blueprint->dropForeign($key);

                }
            });
            $flightSeatForeignKey = $this->getForeignKeyByTable(FlightSeat::getTableName());
            Schema::table(FlightSeat::getTableName(),function(Blueprint $blueprint) use ($flightSeatForeignKey){
                foreach ($flightSeatForeignKey as $key){
                    $blueprint->dropForeign($key);

                }
            });
            $bookingPassengersForeignKey = $this->getForeignKeyByTable(FlightSeat::getTableName());
            Schema::table(BookingPassengers::getTableName(),function(Blueprint $blueprint) use ($bookingPassengersForeignKey){
                foreach ($bookingPassengersForeignKey as $key){
                    $blueprint->dropForeign($key);

                }
            });
        }catch (\Exception $exception){
        }

    }

    protected function getForeignKeyByTable($tableName){
        $conn = Schema::getConnection()->getDoctrineSchemaManager();
        return array_map(function($key) {
            return $key->getName();
        }, $conn->listTableForeignKeys($tableName));
    }
}
