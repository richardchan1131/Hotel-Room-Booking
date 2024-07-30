<?php
namespace Themes\GoTrip\Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Media\Models\MediaFile;

class General extends  Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $logo = [
            'light' => DB::table('media_files')->insertGetId(['file_name' => 'logo-light', 'file_path' => 'gotrip/general/logo-light.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'dark' => DB::table('media_files')->insertGetId(['file_name' => 'logo-dark', 'file_path' => 'gotrip/general/logo-dark.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'preload' => DB::table('media_files')->insertGetId(['file_name' => 'preload', 'file_path' => 'gotrip/general/preload.svg', 'file_type' => 'image/svg', 'file_extension' => 'svg']),
        ];

        //Mega menu image
        DB::table('media_files')->insertGetId(['file_name' => 'mega-menu-bg', 'file_path' => 'gotrip/general/mega-menu-bg.png', 'file_type' => 'image/png', 'file_extension' => 'png']);

        //Setting header,footer
        $menu_items_en = $this->generalMenu();
        DB::table('core_menus')->insert([
            'name' => 'Main Menu',
            'items' => json_encode($menu_items_en),
            'create_user' => '1',
            'created_at' => date("Y-m-d H:i:s")
        ]);
        $menu_items_ja = $this->generalMenu("/ja");
        DB::table('core_menu_translations')->insert([
            'origin_id' => '1',
            'locale' => 'ja',
            'items' => json_encode($menu_items_ja),
            'create_user' => '1',
            'created_at' => date("Y-m-d H:i:s")
        ]);
        $menu_items_egy = $this->generalMenu("/egy");
        DB::table('core_menu_translations')->insert([
            'origin_id' => '1',
            'locale' => 'egy',
            'items' => json_encode($menu_items_egy),
            'create_user' => '1',
            'created_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('core_settings')->insert(
            [
                [
                    'name' => 'menu_locations',
                    'val' => '{"primary":1}',
                    'group' => "general",
                ],
                [
                    'name' => 'admin_email',
                    'val' => 'contact@gotrip.test',
                    'group' => "general",
                ],
                [
                    'name' => 'email_from_name',
                    'val' => 'Go Trip',
                    'group' => "general",
                ],
                [
                    'name' => 'email_from_address',
                    'val' => 'contact@gotrip.test',
                    'group' => "general",
                ],
                [
                    'name' => 'logo_id',
                    'val' => $logo['light'],
                    'group' => "general",
                ],
                [
                    'name' => 'logo_id_dark',
                    'val' => $logo['dark'],
                    'group' => "general",
                ],
                [
                    'name' => 'site_favicon',
                    'val' => MediaFile::findMediaByName("favicon")->id,
                    'group' => "general",
                ],
                [
                    'name' => 'footer_text_left',
                    'val' => 'Copyright © 2023 by Go Trip',
                    'group' => "general",
                ],
                [
                    'name' => 'footer_text_right',
                    'val' => 'Go Trip',
                    'group' => "general",
                ],
                [
                    'name'  => 'list_widget_footer',
                    'val'   => '[{"title":"Contact Us","size":"6","content":"<div class=\"mt-30\">\r\n     <div class=\"text-14 mt-30\">Toll Free Customer Care<\/div>\r\n     <a href=\"#\" class=\"text-18 fw-500 text-blue-1 mt-5\">+(1) 123 456 7890<\/a>\r\n<\/div>\r\n\r\n<div class=\"mt-35\">\r\n   <div class=\"text-14 mt-30\">Need live support?<\/div>\r\n    <a href=\"#\" class=\"text-18 fw-500 text-blue-1 mt-5\">hi@gotrip.com<\/a>\r\n<\/div>"},{"title":"Company","size":"6","content":"<div class=\"d-flex y-gap-10 flex-column\">\r\n                <a href=\"#\">About Us<\/a>\r\n                <a href=\"#\">Careers<\/a>\r\n                <a href=\"#\">Blog<\/a>\r\n                <a href=\"#\">Press<\/a>\r\n                <a href=\"#\">Gift Cards<\/a>\r\n                <a href=\"#\">Magazine<\/a>\r\n              <\/div>"},{"title":"Support","size":"6","content":"<div class=\"d-flex y-gap-10 flex-column\">\r\n                <a href=\"#\">Contact<\/a>\r\n                <a href=\"#\">Legal Notice<\/a>\r\n                <a href=\"#\">Privacy Policy<\/a>\r\n                <a href=\"#\">Terms and Conditions<\/a>\r\n                <a href=\"#\">Sitemap<\/a>\r\n              <\/div>"},{"title":"Other Services","size":"6","content":"<div class=\"d-flex y-gap-10 flex-column\">\r\n                <a href=\"#\">Car hire<\/a>\r\n                <a href=\"#\">Activity Finder<\/a>\r\n                <a href=\"#\">Tour List<\/a>\r\n                <a href=\"#\">Flight finder<\/a>\r\n                <a href=\"#\">Cruise Ticket<\/a>\r\n                <a href=\"#\">Holiday Rental<\/a>\r\n                <a href=\"#\">Travel Agents<\/a>\r\n              <\/div>"},{"title":"Mobile","size":"6","content":"<div class=\"d-flex items-center px-20 py-10 rounded-4 border-light\">\r\n                <div class=\"icon-apple text-24\"><\/div>\r\n                <div class=\"ml-20\">\r\n                  <div class=\"text-14 text-light-1\">Download on the<\/div>\r\n                  <div class=\"text-15 lh-1 fw-500\">Apple Store<\/div>\r\n                <\/div>\r\n              <\/div>\r\n<div class=\"d-flex items-center px-20 py-10 rounded-4 border-light mt-20\">\r\n                <div class=\"icon-play-market text-24\"><\/div>\r\n                <div class=\"ml-20\">\r\n                  <div class=\"text-14 text-light-1\">Get in on<\/div>\r\n                  <div class=\"text-15 lh-1 fw-500\">Google Play<\/div>\r\n                <\/div>\r\n              <\/div>"}]',
                    'group' => "general",
                ],
                [
                    'name'  => 'page_contact_title',
                    'val'   => "Contact Us",
                    'group' => "general",
                ],
                [
                    'name'  => 'page_contact_lists',
                    'val'   => '[{"title":"Address","content":"328 Queensberry Street, North Melbourne VIC 3051, Australia."},{"title":"Toll Free Customer Care","content":"+(1) 123 456 7890"},{"title":"Need live support?","content":"hi@gotrip.com"},{"title":"Follow us on social media","content":"<a href=\"#\"><i class=\"icon-facebook text-14\"><\/i><\/a>\r\n<a href=\"#\"><i class=\"icon-twitter text-14\"><\/i><\/a>\r\n<a href=\"#\"><i class=\"icon-instagram text-14\"><\/i><\/a>\r\n<a href=\"#\"><i class=\"icon-linkedin text-14\"><\/i><\/a>"}]',
                    'group' => "general",
                ],
                [
                    'name'  => 'page_contact_iframe_google_map',
                    'val'   => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835253576489!2d144.95372995111143!3d-37.817327679652266!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d4c2b349649%3A0xb6899234e561db11!2sEnvato!5e0!3m2!1sen!2sin!4v1581584770980!5m2!1sen!2sin" width="100%" height="500" frameborder="0" style="border:0;" allowfullscreen=""></iframe>',
                    'group' => "general",
                ],
                [
                    'name' => 'page_contact_sub_title',
                    'val' => "Send us a message and we'll respond as soon as possible",
                    'group' => "general",
                ],
                [
                    'name' => 'page_contact_desc',
                    'val' => "<!DOCTYPE html><html><head></head><body><h3>Go Trip</h3><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>Tell. + 00 222 444 33</p><p>Email. hello@yoursite.com</p><p>1355 Market St, Suite 900San, Francisco, CA 94103 United States</p></body></html>",
                    'group' => "general",
                ],
                [
                    'name' => 'page_contact_image',
                    'val' => MediaFile::findMediaByName("bg_contact")->id,
                    'group' => "general",
                ],
                [
                    'name' => 'api_app_layout',
                    'val' => "1",
                    'group' => "api",
                ],
                [
                    'name' => 'home_page_id',
                    'val' => '1',
                    'group' => "general",
                ],
                [
                    'name' => 'enable_preload',
                    'val' => '1',
                    'group' => "general",
                ],
                [
                    'name' => 'logo_preload_id',
                    'val' => $logo['preload'],
                    'group' => "general",
                ],
                [
                    'name' => 'page_contact_title_ja',
                    'val' => "あなたからの御一報をお待ち",
                    'group' => "general",
                ],
                [
                    'name' => 'page_contact_sub_title_ja',
                    'val' => "私たちにメッセージを送ってください、私たちはできるだ",
                    'group' => "general",
                ],
            ]
        );
        // Setting Currency
        DB::table('core_settings')->insert([
            [
                'name' => "currency_main",
                'val' => "usd",
                'group' => "payment",
            ],
            [
                'name' => "currency_format",
                'val' => "left",
                'group' => "payment",
            ],
            [
                'name' => "currency_decimal",
                'val' => ",",
                'group' => "payment",
            ],
            [
                'name' => "currency_thousand",
                'val' => ".",
                'group' => "payment",
            ],
            [
                'name' => "currency_no_decimal",
                'val' => "0",
                'group' => "payment",
            ],
            [
                'name' => "extra_currency",
                'val' => '[{"currency_main":"eur","currency_format":"left","currency_thousand":".","currency_decimal":",","currency_no_decimal":"2","rate":"0.902807"},{"currency_main":"jpy","currency_format":"right_space","currency_thousand":".","currency_decimal":",","currency_no_decimal":"0","rate":"0.00917113"}]',
                'group' => "payment",
            ]
        ]);
        //MAP
        DB::table('core_settings')->insert([
            [
                'name' => 'map_provider',
                'val' => 'gmap',
                'group' => "advance",
            ],
            [
                'name' => 'map_gmap_key',
                'val' => '',
                'group' => "advance",
            ]
        ]);
        // Payment Gateways
        DB::table('core_settings')->insert([
            [
                'name' => "g_offline_payment_enable",
                'val' => "1",
                'group' => "payment",
            ],
            [
                'name' => "g_offline_payment_name",
                'val' => "Offline Payment",
                'group' => "payment",
            ]
        ]);
        // Settings general
        DB::table('core_settings')->insert([
            [
                'name' => "date_format",
                'val' => "m/d/Y",
                'group' => "general",
            ],
            [
                'name' => "site_title",
                'val' => "Go Trip",
                'group' => "general",
            ],
            [
                'name' => "footer_style",
                'val' => "normal",
                'group' => "general",
            ],
            [
                'name' => "footer_style",
                'val' => "normal",
                'group' => "general",
            ],
            [
                'name' => "footer_content_left",
                'val' => '[{"title":"information","content":"<div class=\"row y-gap-30 justify-between pt-30\">\r\n                <div class=\"col-sm-6\">\r\n                  <div class=\"text-14\">Toll Free Customer Care<\/div>\r\n                  <a href=\"#\" class=\"text-18 fw-500 mt-5\">+(1) 123 456 7890<\/a>\r\n                <\/div>\r\n\r\n                <div class=\"col-sm-5\">\r\n                  <div class=\"text-14\">Need live support?<\/div>\r\n                  <a href=\"#\" class=\"text-18 fw-500 mt-5\">hi@gotrip.com<\/a>\r\n                <\/div>\r\n              <\/div>"},{"title":"Travel App","content":"<div class=\"row x-gap-20 y-gap-15 pt-60\">\r\n                <div class=\"col-12\">\r\n                  <h5 class=\"text-16 fw-500\">Your all-in-one travel app<\/h5>\r\n                <\/div>\r\n\r\n                <div class=\"col-auto col-lg-6\">\r\n                  <div class=\"d-flex items-center px-20 py-10 rounded-4 bg-white-10\">\r\n                    <div class=\"icon-apple text-24\"><\/div>\r\n                    <div class=\"ml-20\">\r\n                      <div class=\"text-14 lh-14\">Download on the<\/div>\r\n                      <div class=\"text-15 lh-14 fw-500\">Apple Store<\/div>\r\n                    <\/div>\r\n                  <\/div>\r\n                <\/div>\r\n\r\n                <div class=\"col-auto col-lg-6\">\r\n                  <div class=\"d-flex items-center px-20 py-10 rounded-4 bg-white-10\">\r\n                    <div class=\"icon-play-market text-24\"><\/div>\r\n                    <div class=\"ml-20\">\r\n                      <div class=\"text-14 lh-14\">Get in on<\/div>\r\n                      <div class=\"text-15 lh-14 fw-500\">Google Play<\/div>\r\n                    <\/div>\r\n                  <\/div>\r\n                <\/div>\r\n              <\/div>"},{"title":"Social Media","content":"<div class=\"mt-60\">\r\n                <h5 class=\"text-16 fw-500 mb-10\">Follow us on social media<\/h5>\r\n\r\n                <div class=\"d-flex x-gap-20 items-center\">\r\n                  <a href=\"#\"><i class=\"icon-facebook text-14\"><\/i><\/a>\r\n                  <a href=\"#\"><i class=\"icon-twitter text-14\"><\/i><\/a>\r\n                  <a href=\"#\"><i class=\"icon-instagram text-14\"><\/i><\/a>\r\n                  <a href=\"#\"><i class=\"icon-linkedin text-14\"><\/i><\/a>\r\n                <\/div>\r\n              <\/div>"}]',
                'group' => "general",
            ],
            [
                'name' => "footer_content_right",
                'val' => '[{"title":"Company","content":"<div class=\"d-flex y-gap-10 flex-column\">\r\n                <a href=\"#\">About Us<\/a>\r\n                <a href=\"#\">Careers<\/a>\r\n                <a href=\"#\">Blog<\/a>\r\n                <a href=\"#\">Press<\/a>\r\n                <a href=\"#\">Gift Cards<\/a>\r\n                <a href=\"#\">Magazine<\/a>\r\n              <\/div>"},{"title":"Support","content":"<div class=\"d-flex y-gap-10 flex-column\">\r\n                <a href=\"#\">Contact<\/a>\r\n                <a href=\"#\">Legal Notice<\/a>\r\n                <a href=\"#\">Privacy Policy<\/a>\r\n                <a href=\"#\">Terms and Conditions<\/a>\r\n                <a href=\"#\">Sitemap<\/a>\r\n              <\/div>"},{"title":"Other Services","content":"<div class=\"d-flex y-gap-10 flex-column\">\r\n                <a href=\"#\">Car hire<\/a>\r\n                <a href=\"#\">Activity Finder<\/a>\r\n                <a href=\"#\">Tour List<\/a>\r\n                <a href=\"#\">Flight finder<\/a>\r\n                <a href=\"#\">Cruise Ticket<\/a>\r\n                <a href=\"#\">Holiday Rental<\/a>\r\n                <a href=\"#\">Travel Agents<\/a>\r\n              <\/div>"}]',
                'group' => "general",
            ],
            [
                'name' => "topbar_left_text",
                'val' => '<div class="row x-gap-15 y-gap-15 items-center">
                              <div class="col-auto md:d-none">
                                <a href="#" class="text-12 text-white">+(1) 123 456 7890</a>
                              </div>

                              <div class="col-auto md:d-none">
                                <div class="w-1 h-20 bg-white-20"></div>
                              </div>

                              <div class="col-auto">
                                <a href="#" class="text-12 text-white">hi@gotrip.com</a>
                              </div>
                         </div>',
                'group' => "general"
            ],
        ]);
        // Email general
        DB::table('core_settings')->insert([
            [
                'name' => "site_timezone",
                'val' => "UTC",
                'group' => "general",
            ],
            [
                'name' => "site_title",
                'val' => "Go Trip",
                'group' => "general",
            ],
            [
                'name' => "email_header",
                'val' => '<h1 class="site-title" style="text-align: center">Go Trip</h1>',
                'group' => "general",
            ],
            [
                'name' => "email_footer",
                'val' => '<p class="" style="text-align: center">&copy; 2023 Go Trip. All rights reserved</p>',
                'group' => "general",
            ],
            [
                'name' => "enable_mail_user_registered",
                'val' => 1,
                'group' => "user",
            ],
            [
                'name' => "user_content_email_registered",
                'val' => '<h1 style="text-align: center">Welcome!</h1>
                    <h3>Hello [first_name] [last_name]</h3>
                    <p>Thank you for signing up with Go Trip! We hope you enjoy your time with us.</p>
                    <p>Regards,</p>
                    <p>Go Trip</p>',
                'group' => "user",
            ],
            [
                'name' => "admin_enable_mail_user_registered",
                'val' => 1,
                'group' => "user",
            ],
            [
                'name' => "admin_content_email_user_registered",
                'val' => '<h3>Hello Administrator</h3>
                    <p>We have new registration</p>
                    <p>Full name: [first_name] [last_name]</p>
                    <p>Email: [email]</p>
                    <p>Regards,</p>
                    <p>Go Trip</p>',
                'group' => "user",
            ],
            [
                'name' => "user_content_email_forget_password",
                'val' => '<h1>Hello!</h1>
                    <p>You are receiving this email because we received a password reset request for your account.</p>
                    <p style="text-align: center">[button_reset_password]</p>
                    <p>This password reset link expire in 60 minutes.</p>
                    <p>If you did not request a password reset, no further action is required.
                    </p>
                    <p>Regards,</p>
                    <p>Go Trip</p>',
                'group' => "user",
            ]
        ]);
        // Email Setting
        DB::table('core_settings')->insert([
            [
                'name' => "email_driver",
                'val' => "log",
                'group' => "email",
            ],
            [
                'name' => "email_host",
                'val' => "smtp.mailgun.org",
                'group' => "email",
            ],
            [
                'name' => "email_port",
                'val' => "587",
                'group' => "email",
            ],
            [
                'name' => "email_encryption",
                'val' => "tls",
                'group' => "email",
            ],
            [
                'name' => "email_username",
                'val' => "",
                'group' => "email",
            ],
            [
                'name' => "email_password",
                'val' => "",
                'group' => "email",
            ],
            [
                'name' => "email_mailgun_domain",
                'val' => "",
                'group' => "email",
            ],
            [
                'name' => "email_mailgun_secret",
                'val' => "",
                'group' => "email",
            ],
            [
                'name' => "email_mailgun_endpoint",
                'val' => "api.mailgun.net",
                'group' => "email",
            ],
            [
                'name' => "email_postmark_token",
                'val' => "",
                'group' => "email",
            ],
            [
                'name' => "email_ses_key",
                'val' => "",
                'group' => "email",
            ],
            [
                'name' => "email_ses_secret",
                'val' => "",
                'group' => "email",
            ],
            [
                'name' => "email_ses_region",
                'val' => "us-east-1",
                'group' => "email",
            ],
            [
                'name' => "email_sparkpost_secret",
                'val' => "",
                'group' => "email",
            ],
        ]);
        // Email Setting
        DB::table('core_settings')->insert([
            [
                'name' => "booking_enquiry_for_hotel",
                'val' => "1",
                'group' => "enquiry",
            ],
            [
                'name' => "booking_enquiry_type_hotel",
                'val' => "booking_and_enquiry",
                'group' => "enquiry",
            ],
            [
                'name' => "booking_enquiry_for_tour",
                'val' => "1",
                'group' => "enquiry",
            ],
            [
                'name' => "booking_enquiry_type_tour",
                'val' => "booking_and_enquiry",
                'group' => "enquiry",
            ],
            [
                'name' => "booking_enquiry_for_space",
                'val' => "1",
                'group' => "enquiry",
            ],
            [
                'name' => "booking_enquiry_type_space",
                'val' => "booking_and_enquiry",
                'group' => "enquiry",
            ],
            [
                'name' => "booking_enquiry_for_car",
                'val' => "1",
                'group' => "enquiry",
            ],
            [
                'name' => "booking_enquiry_type_car",
                'val' => "booking_and_enquiry",
                'group' => "enquiry",
            ],
            [
                'name' => "booking_enquiry_for_event",
                'val' => "1",
                'group' => "enquiry",
            ],
            [
                'name' => "booking_enquiry_type_event",
                'val' => "booking_and_enquiry",
                'group' => "enquiry",
            ],
            [
                'name' => "booking_enquiry_for_boat",
                'val' => "1",
                'group' => "enquiry",
            ],
            [
                'name' => "booking_enquiry_type_boat",
                'val' => "booking_and_enquiry",
                'group' => "enquiry",
            ],
            [
                'name' => "booking_enquiry_enable_mail_to_vendor",
                'val' => "1",
                'group' => "enquiry",
            ],
            [
                'name' => "booking_enquiry_mail_to_vendor_content",
                'val' => "<h3>Hello [vendor_name]</h3>
                            <p>You get new inquiry request from [email]</p>
                            <p>Name :[name]</p>
                            <p>Emai:[email]</p>
                            <p>Phone:[phone]</p>
                            <p>Content:[note]</p>
                            <p>Service:[service_link]</p>
                            <p>Regards,</p>
                            <p>Go Trip</p>
                            </div>",
                'group' => "enquiry",
            ],
            [
                'name' => "booking_enquiry_enable_mail_to_admin",
                'val' => "1",
                'group' => "enquiry",
            ],
            [
                'name' => "booking_enquiry_mail_to_admin_content",
                'val' => "<h3>Hello Administrator</h3>
                            <p>You get new inquiry request from [email]</p>
                            <p>Name :[name]</p>
                            <p>Emai:[email]</p>
                            <p>Phone:[phone]</p>
                            <p>Content:[note]</p>
                            <p>Service:[service_link]</p>
                            <p>Vendor:[vendor_link]</p>
                            <p>Regards,</p>
                            <p>Go Trip</p>",
                'group' => "enquiry",
            ],
        ]);
        // Vendor setting
        DB::table('core_settings')->insert([
            [
                'name' => "vendor_enable",
                'val' => "1",
                'group' => "vendor",
            ],
            [
                'name' => "vendor_commission_type",
                'val' => "percent",
                'group' => "vendor",
            ],
            [
                'name' => "vendor_commission_amount",
                'val' => "10",
                'group' => "vendor",
            ],
            [
                'name' => "vendor_role",
                'val' => "2",
                'group' => "vendor",
            ],
            [
                'name' => "role_verify_fields",
                'val' => '{"phone":{"name":"Phone","type":"text","roles":["1","2","3"],"required":null,"order":null,"icon":"fa fa-phone"},"id_card":{"name":"ID Card","type":"file","roles":["1","2","3"],"required":"1","order":"0","icon":"fa fa-id-card"},"trade_license":{"name":"Trade License","type":"multi_files","roles":["1","3"],"required":"1","order":"0","icon":"fa fa-copyright"}}',
                'group' => "vendor",
            ],
            [
                'name' => "vendor_show_email",
                'val' => "1",
                'group' => "vendor",
            ],
            [
                'name' => "vendor_show_phone",
                'val' => "1",
                'group' => "vendor",
            ],
        ]);
        DB::table('core_settings')->insert([
            'name' => 'enable_mail_vendor_registered',
            'val' => '1',
            'group' => 'vendor'
        ]);
        DB::table('core_settings')->insert([
            'name' => 'vendor_content_email_registered',
            'val' => '<h1 style="text-align: center;">Welcome!</h1>
                            <h3>Hello [first_name] [last_name]</h3>
                            <p>Thank you for signing up with Go Trip! We hope you enjoy your time with us.</p>
                            <p>Regards,</p>
                            <p>Go Trip</p>',
            'group' => 'vendor'
        ]);
        DB::table('core_settings')->insert([
            'name' => 'admin_enable_mail_vendor_registered',
            'val' => '1',
            'group' => 'vendor'
        ]);
        DB::table('core_settings')->insert([
            'name' => 'admin_content_email_vendor_registered',
            'val' => '<h3>Hello Administrator</h3>
                            <p>An user has been registered as Vendor. Please check the information bellow:</p>
                            <p>Full name: [first_name] [last_name]</p>
                            <p>Email: [email]</p>
                            <p>Registration date: [created_at]</p>
                            <p>You can approved the request here: [link_approved]</p>
                            <p>Regards,</p>
                            <p>Go Trip</p>',
            'group' => 'vendor'
        ]);
        //            Cookie agreement
        DB::table('core_settings')->insert([
            [
                'name' => "cookie_agreement_enable",
                'val' => "1",
                'group' => "advance",
            ],
            [
                'name' => "cookie_agreement_button_text",
                'val' => "Got it",
                'group' => "advance",
            ],
            [
                'name' => "cookie_agreement_content",
                'val' => "<p>This website requires cookies to provide all of its features. By using our website, you agree to our use of cookies. <a href='#'>More info</a></p>",
                'group' => "advance",
            ],
        ]);
        // Invoice setting
        DB::table('core_settings')->insert([
            [
                'name'  => 'logo_invoice_id',
                'val'   => $logo['dark'],
                'group' => "booking",
            ],
            [
                'name' => "invoice_company_info",
                'val' => "<p><span style=\"font-size: 14pt;\"><strong>Go Trip Company</strong></span></p>
                                <p>Ha Noi, Viet Nam</p>
                                <p>www.gotrip.org</p>",
                'group' => "booking",
            ],
        ]);


        // Setting Home Page
        $home1_image = [
            'img_1' => DB::table('media_files')->insertGetId(['file_name' => 'home1-bg', 'file_path' => 'gotrip/general/home1-bg.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_2' => DB::table('media_files')->insertGetId(['file_name' => 'offer-1', 'file_path' => 'gotrip/general/offer-1.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_3' => DB::table('media_files')->insertGetId(['file_name' => 'offer-2', 'file_path' => 'gotrip/general/offer-2.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_4' => DB::table('media_files')->insertGetId(['file_name' => 'feature-item-1', 'file_path' => 'gotrip/general/feature-item-1.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_5' => DB::table('media_files')->insertGetId(['file_name' => 'feature-item-2', 'file_path' => 'gotrip/general/feature-item-2.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_6' => DB::table('media_files')->insertGetId(['file_name' => 'feature-item-3', 'file_path' => 'gotrip/general/feature-item-3.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_7' => DB::table('media_files')->insertGetId(['file_name' => 'avatar-1', 'file_path' => 'gotrip/general/avatar-1.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
        ];
        $home1 = [
            [
                'type' => 'form_search_all_service',
                'name' => 'Form Search All Service',
                'model'=> [
                    'service_types' => ['hotel', 'space', 'tour', 'car', 'event', 'flight', 'boat'],
                    'title'         => 'Find Next Place To Visit',
                    'sub_title'     => 'Discover amazing places at exclusive deals',
                    'bg_image'      => $home1_image['img_1'],
                    'style'         => '',
                    'list_slider'   => [],
                    'title_for_hotel' => '',
                    'title_for_space' => '',
                    'title_for_car'   => '',
                    'title_for_event' => '',
                    'title_for_tour' => '',
                    "title_for_flight"=>"",
                    "title_for_boat"=>"",
                    "hide_form_search"=>""
                ],
                "component"=>"RegularBlock",
                "open"=>true,
                "is_container"=>false
            ],
            [
                "type"=>"list_locations",
                "name"=>"List Locations",
                "model"=>[
                    "service_type"=>["hotel", "space", "car", "event", "tour", "boat"],
                    "title"=>"Popular Destinations",
                    "desc"=>"These popular destinations have a lot to offer",
                    "number"=>5,
                    "layout"=>"style_1",
                    "order"=>"id",
                    "order_by"=>"desc",
                    "custom_ids"=>[],
                    "to_location_detail"=>""
                ],
                "component"=>"RegularBlock",
                "open"=>true
            ],
            [
                "type"=>"offer_block",
                "name"=>"Offer Block",
                "model"=>[
                    "list_item"=>[
                        [
                            "_active"=>false,
                            "title"=>"Things to do on your trip",
                            "desc"=>null,
                            "background_image"=>$home1_image['img_2'],
                            "link_title"=>"Experiences",
                            "link_more"=>"#",
                            "featured_text"=>null,
                            "featured_icon"=>null
                        ],
                        [
                            "_active"=>true,
                            "title"=>"Up to 70% Discount!",
                            "desc"=>"",
                            "background_image"=>$home1_image['img_3'],
                            "link_title"=>"Learn More",
                            "link_more"=>"#",
                            "featured_text"=>"Enjoy Summer Deals",
                            "featured_icon"=>null
                        ]
                    ]
                ],
                "component"=>"RegularBlock",
                "open"=>true
            ],
            [
                "type"=>"list_hotel",
                "name"=>"Hotel: List Items",
                "model"=>[
                    "title"=>"Recommended",
                    "desc"=>"Interdum et malesuada fames ac ante ipsum",
                    "number"=>8,
                    "style"=>"carousel",
                    "location_ids"=>[],
                    "order"=>"id",
                    "order_by"=>"desc",
                    "is_featured"=>"",
                    "custom_ids"=>[]
                ],
                "component"=>"RegularBlock",
                "open"=>true
            ],
            [
                "type"=>"list_featured_item",
                "name"=>"List Featured Item",
                "model"=>[
                    "title"=>"",
                    "sub_title"=>"",
                    "list_item"=>[
                        [
                            "_active"=>true,
                            "title"=>"Best Price Guarantee",
                            "sub_title"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                            "icon_image"=>$home1_image['img_4'],
                            "order"=>1
                        ],
                        [
                            "_active"=>true,
                            "title"=>"Easy & Quick Booking",
                            "sub_title"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                            "icon_image"=>$home1_image['img_5'],
                            "order"=>2
                        ],
                        [
                            "_active"=>true,
                            "title"=>"Customer Care 24/7",
                            "sub_title"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                            "icon_image"=>$home1_image['img_6'],
                            "order"=>3
                        ]
                    ],
                    "style"=>"normal"
                ],
                "component"=>"RegularBlock",
                "open"=>true
            ],
            [
                "type"=>"testimonial",
                "name"=>"List Testimonial",
                "model"=>[
                    "title"=>"What our customers are saying us?",
                    "subtitle"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas varius tortor nibh, sit amet tempor nibh finibus et. Aenean eu enim justo.",
                    "happy_people_number"=>"13m+",
                    "happy_people_text"=>"Happy People",
                    "overall_rating_number"=>"4.88",
                    "overall_rating_text"=>"Overall rating",
                    "overall_rating_star"=>"5",
                    "style"=>"",
                    "list_item"=>[
                        [
                            "_active"=>true,
                            "title"=>"",
                            "name"=>"Annette Black",
                            "job"=>"UX / UI Designer",
                            "desc"=>"The place is in a great location in Gumbet. The area is safe and beautiful. The apartment was comfortable and the host was kind and responsive to our requests.",
                            "number_star"=>null,
                            "avatar"=>$home1_image['img_7']
                        ],
                        [
                            "_active"=>true,
                            "title"=>"",
                            "name"=>"Annette Black",
                            "job"=>"UX / UI Designer",
                            "desc"=>"The place is in a great location in Gumbet. The area is safe and beautiful. The apartment was comfortable and the host was kind and responsive to our requests.",
                            "number_star"=>null,
                            "avatar"=>$home1_image['img_7']
                        ],
                        [
                            "_active"=>true,
                            "title"=>"",
                            "name"=>"Annette Black",
                            "job"=>"UX / UI Designer",
                            "desc"=>"The place is in a great location in Gumbet. The area is safe and beautiful. The apartment was comfortable and the host was kind and responsive to our requests.",
                            "number_star"=>null,
                            "avatar"=>$home1_image['img_7']
                        ],
                    ],
                    "title_trusted"=>"",
                    "list_trusted"=>[]
                ],
                "component"=>"RegularBlock",
                "open"=>true
            ],
            [
                "type"=>"list_news",
                "name"=>"News: List Items",
                "model"=>[
                    "title"=>"Get inspiration for your next trip",
                    "header_align"=>"center",
                    "desc"=>"Interdum et malesuada fames",
                    "number"=>3,
                    "bg_image"=>"",
                    "category_id"=>"",
                    "order"=>"id",
                    "order_by"=>"desc",
                    "bg_color"=>"",
                    "style"=>""
                ],
                "component"=>"RegularBlock",
                "open"=>true
            ],
            [
                "type"=>"list_locations",
                "name"=>"List Locations",
                "model"=>[
                    "service_type"=>["hotel", "space", "car", "event", "tour", "boat"],
                    "title"=>"Destinations we love",
                    "desc"=>"Interdum et malesuada fames ac ante ipsum",
                    "number"=>20,
                    "layout"=>"style_2",
                    "order"=>"id",
                    "order_by"=>"desc",
                    "custom_ids"=>[],
                    "to_location_detail"=>""
                ],
                "component"=>"RegularBlock",
                "open"=>true
            ]
        ];
        DB::table('core_templates')->insert([
            'title'       => 'Home Page',
            'content'     => json_encode($home1),
            'create_user' => '1',
            'created_at'  => date("Y-m-d H:i:s")
        ]);
        DB::table('core_template_translations')->insert([
            'origin_id' => '1',
            'locale' => 'ja',
            'title' => 'Home Page',
            'content' => json_encode($home1),
            'create_user' => '1',
            'created_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('core_pages')->insert([
            'title' => 'Home 1',
            'slug' => 'home-1',
            'template_id' => '1',
            'header_style' => 'transparent',
            'create_user' => '1',
            'status' => 'publish',
            'created_at' => date("Y-m-d H:i:s"),
        ]);


        // Setting Home Page
        $home2_image = [
            'img_1' => DB::table('media_files')->insertGetId(['file_name' => 'home2-bg', 'file_path' => 'gotrip/general/home2-bg.png', 'file_type' => 'image/png', 'file_extension' => 'png']),

            'img_2' => DB::table('media_files')->insertGetId(['file_name' => 'home2-slider-1', 'file_path' => 'gotrip/general/home2-slider-1.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_3' => DB::table('media_files')->insertGetId(['file_name' => 'home2-slider-2', 'file_path' => 'gotrip/general/home2-slider-2.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_4' => DB::table('media_files')->insertGetId(['file_name' => 'home2-slider-3', 'file_path' => 'gotrip/general/home2-slider-3.png', 'file_type' => 'image/png', 'file_extension' => 'png']),

            'img_8' => DB::table('media_files')->insertGetId(['file_name' => 'avatar-1', 'file_path' => 'gotrip/general/avatar-1.png', 'file_type' => 'image/png', 'file_extension' => 'png']),

            'img_9' => DB::table('media_files')->insertGetId(['file_name' => 'trusted-1', 'file_path' => 'gotrip/general/trusted-1.svg', 'file_type' => 'image/svg+xml', 'file_extension' => 'svg']),
            'img_10' => DB::table('media_files')->insertGetId(['file_name' => 'trusted-2', 'file_path' => 'gotrip/general/trusted-2.svg', 'file_type' => 'image/svg+xml', 'file_extension' => 'svg']),
            'img_11' => DB::table('media_files')->insertGetId(['file_name' => 'trusted-3', 'file_path' => 'gotrip/general/trusted-3.svg', 'file_type' => 'image/svg+xml', 'file_extension' => 'svg']),
            'img_12' => DB::table('media_files')->insertGetId(['file_name' => 'trusted-4', 'file_path' => 'gotrip/general/trusted-4.svg', 'file_type' => 'image/svg+xml', 'file_extension' => 'svg']),
            'img_13' => DB::table('media_files')->insertGetId(['file_name' => 'trusted-5', 'file_path' => 'gotrip/general/trusted-5.svg', 'file_type' => 'image/svg+xml', 'file_extension' => 'svg']),
            'img_14' => DB::table('media_files')->insertGetId(['file_name' => 'trusted-6', 'file_path' => 'gotrip/general/trusted-6.svg', 'file_type' => 'image/svg+xml', 'file_extension' => 'svg']),

            'img_15' => DB::table('media_files')->insertGetId(['file_name' => 'subscribe', 'file_path' => 'gotrip/general/subscribe.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_16' => DB::table('media_files')->insertGetId(['file_name' => 'download_app', 'file_path' => 'gotrip/general/download_app.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
        ];
        // home 2
        $home2 = [
            [
                'type' => 'form_search_all_service',
                'name' => 'Form Search All Service',
                'model'=> [
                    'service_types' => ['hotel', 'space', 'tour', 'car', 'event', 'flight', 'boat'],
                    'title'         => 'Find Next Place To Visit',
                    'sub_title'     => 'Discover amazing places at exclusive deals',
                    'bg_image'      => $home2_image['img_1'],
                    'style'         => 'carousel_v2',
                    'list_slider'   => [
                        ["_active"=>true,"title"=>"",'bg_image' => $home2_image['img_2']],
                        ["_active"=>true,"title"=>"",'bg_image' => $home2_image['img_3']],
                        ["_active"=>true,"title"=>"",'bg_image' => $home2_image['img_4']]
                    ],
                    'title_for_hotel' => '',
                    'title_for_space' => '',
                    'title_for_car'   => '',
                    'title_for_event' => '',
                    'title_for_tour' => '',
                    "title_for_flight"=>"",
                    "title_for_boat"=>"",
                    "hide_form_search"=>""
                ],
                "component"=>"RegularBlock",
                "open"=>true,
                "is_container"=>false
            ],
            [
                "type"=>"list_featured_item",
                "name"=>"List Featured Item",
                "model"=>[
                    "title"=>"",
                    "sub_title"=>"",
                    "list_item"=>[
                        [
                            "_active"=>true,
                            "title"=>"Best Price Guarantee",
                            "sub_title"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                            "icon_image"=>$home1_image['img_4'],
                            "order"=>1
                        ],
                        [
                            "_active"=>true,
                            "title"=>"Easy & Quick Booking",
                            "sub_title"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                            "icon_image"=>$home1_image['img_5'],
                            "order"=>2
                        ],
                        [
                            "_active"=>true,
                            "title"=>"Customer Care 24/7",
                            "sub_title"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                            "icon_image"=>$home1_image['img_6'],
                            "order"=>3
                        ]
                    ],
                    "style"=>"normal"
                ],
                "component"=>"RegularBlock",
                "open"=>true
            ],
            [
                "type"=>"list_locations",
                "name"=>"List Locations",
                "model"=>[
                    "service_type"=>["hotel", "space", "car", "event", "tour", "boat"],
                    "title"=>"Popular Destinations",
                    "desc"=>"These popular destinations have a lot to offer",
                    "number"=>10,
                    "layout"=>"style_4",
                    "order"=>"id",
                    "order_by"=>"desc",
                    "custom_ids"=>[],
                    "to_location_detail"=>""
                ],
                "component"=>"RegularBlock",
                "open"=>true
            ],
            [
                "type" => "list_all_service",
                "name"=> "List All Service",
                "model" => [
                    "title_for_hotel"=>"",
                    "title_for_space"=>"",
                    "title_for_car"=>"",
                    "title_for_event"=>"",
                    "title_for_tour"=>"",
                    "title_for_boat"=>"",
                    "service_types"=>["hotel","space","car","event","tour","boat"],
                    "title"=>"Best Seller",
                    "sub_title"=>"Interdum et malesuada fames ac ante ipsum",
                    "style"=>"",
                    "number"=>4,
                    "order"=>"",
                    "order_by"=>""
                ],
                "component"=>"RegularBlock",
                "open"=>true
            ],
            [
                "type"=>"testimonial",
                "name"=>"List Testimonial",
                "model"=>[
                    "title"=>"What our customers are saying us?",
                    "subtitle"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas varius tortor nibh, sit amet tempor nibh finibus et. Aenean eu enim justo.",
                    "happy_people_number"=>"13m+",
                    "happy_people_text"=>"Happy People",
                    "overall_rating_number"=>"4.88",
                    "overall_rating_text"=>"Overall rating",
                    "overall_rating_star"=>"5",
                    "style"=>"style_2",
                    "list_item"=>[
                        [
                            "_active"=>true,
                            "title"=>"",
                            "name"=>"Annette Black",
                            "job"=>"UX / UI Designer",
                            "desc"=>"The place is in a great location in Gumbet. The area is safe and beautiful. The apartment was comfortable and the host was kind and responsive to our requests.",
                            "number_star"=>null,
                            "avatar"=>$home2_image['img_8']
                        ],
                        [
                            "_active"=>true,
                            "title"=>"",
                            "name"=>"Annette Black",
                            "job"=>"UX / UI Designer",
                            "desc"=>"The place is in a great location in Gumbet. The area is safe and beautiful. The apartment was comfortable and the host was kind and responsive to our requests.",
                            "number_star"=>null,
                            "avatar"=>$home2_image['img_8']
                        ],
                        [
                            "_active"=>true,
                            "title"=>"",
                            "name"=>"Annette Black",
                            "job"=>"UX / UI Designer",
                            "desc"=>"The place is in a great location in Gumbet. The area is safe and beautiful. The apartment was comfortable and the host was kind and responsive to our requests.",
                            "number_star"=>null,
                            "avatar"=>$home2_image['img_8']
                        ],
                    ],
                    "title_trusted"=>"Trusted by the world’s best",
                    "list_trusted"=>[
                        ["_active"=>true,"title"=>"","avatar"=>$home2_image['img_9']],
                        ["_active"=>true,"title"=>"","avatar"=>$home2_image['img_10']],
                        ["_active"=>true,"title"=>"","avatar"=>$home2_image['img_11']],
                        ["_active"=>true,"title"=>"","avatar"=>$home2_image['img_12']],
                        ["_active"=>true,"title"=>"","avatar"=>$home2_image['img_13']],
                        ["_active"=>true,"title"=>"","avatar"=>$home2_image['img_14']]
                    ]
                ],
                "component"=>"RegularBlock",
                "open"=>true
            ],
            [
                "type"=>"list_news",
                "name"=>"News: List Items",
                "model"=>[
                    "title"=>"Get inspiration for your next trip",
                    "header_align"=>"left",
                    "desc"=>"Interdum et malesuada fames",
                    "number"=>4,
                    "bg_image"=>"",
                    "category_id"=>"",
                    "order"=>"id",
                    "order_by"=>"desc",
                    "bg_color"=>"",
                    "style"=>"style_2"
                ],
                "component"=>"RegularBlock",
                "open"=>true
            ],
            [
                "type"=>"subscribe",
                "name"=>"Subscribe",
                "model"=>[
                    "title"=>"Your Travel Journey Starts Here",
                    "sub_title"=>"Sign up and we'll send the best deals to you",
                    "bg_image"=>$home2_image['img_15'],
                    "style"=>""
                ],
                "component"=>"RegularBlock",
                "open"=>true,
                "is_container"=>false
            ],
            [
                "type" => "download_app",
                "name" => "Download App",
                "model" => [
                    "title" => "Download the App",
                    "sub_title" => "Book in advance or last-minute with GoTrip. Receive instant confirmation. Access your booking info offline.",
                    "bg_image" => $home2_image['img_16'],
                    "style" => "",
                    "list_item" => [
                        [
                            '_active' => true,
                            'title' => 'Apple Store',
                            'subtitle' => 'Download on the',
                            'icon' => 'icon-apple',
                            'link' => '#'
                        ],
                        [
                            '_active' => true,
                            'title' => 'Google Play',
                            'subtitle' => 'Get in on',
                            'icon' => 'icon-play-market',
                            'link' => '#'
                        ]
                    ]
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type"=>"login_register",
                "name"=>"Login Register",
                "model"=>[
                    "title"=>"Not a Member Yet?",
                    "sub_title"=>"Join us! Our members can access savings of up to 50% and earn Trip Coins while booking."
                ],
                "component"=>"RegularBlock",
                "open"=>true
            ]


        ];
        DB::table('core_templates')->insert([
            'title'       => 'Home 2',
            'content'     => json_encode($home2),
            'create_user' => '1',
            'created_at'  => date("Y-m-d H:i:s")
        ]);
        DB::table('core_template_translations')->insert([
            'origin_id' => '2',
            'locale' => 'ja',
            'title' => 'Home 2',
            'content' => json_encode($home2),
            'create_user' => '1',
            'created_at' => date("Y-m-d H:i:s")
        ]);


        DB::table('core_pages')->insert([
            'title' => 'Home 2',
            'slug' => 'home-2',
            'template_id' => '2',
            'header_style' => 'transparent_v2',
            'footer_style' => 'style_1',
            'disable_subscribe_default' => 1,
            'create_user' => '1',
            'status' => 'publish',
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        $home4_image = [
            'img_1' => DB::table('media_files')->insertGetId(['file_name' => 'home4-bg', 'file_path' => 'gotrip/general/home4-bg.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_2' => DB::table('media_files')->insertGetId(['file_name' => 'call-to-action-home4', 'file_path' => 'gotrip/general/call-to-action-home4.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
        ];
        $home4 = [
            [
                "type" => "form_search_hotel",
                "name" => "Hotel: Form Search",
                "model" => [
                    "list_item" => [
                        [
                            "_active" => true,
                            "title" => "Find Your Dream Luxury Hotel",
                            "sub_title" => "Discover amzaing places at exclusive deals",
                            "discover_text" => "Discover More",
                            "discover_link" => "#",
                            "bg_image" => $home4_image['img_1']
                        ],
                        [
                            "_active" => true,
                            "title" => "Find Your Dream Luxury Hotel",
                            "sub_title" => "Discover amzaing places at exclusive deals",
                            "discover_text" => "Discover More",
                            "discover_link" => "#",
                            "bg_image" => $home4_image['img_1']
                        ],
                        [
                            "_active" => true,
                            "title" => "Find Your Dream Luxury Hotel",
                            "sub_title" => "Discover amzaing places at exclusive deals",
                            "discover_text" => "Discover More",
                            "discover_link" => "#",
                            "bg_image" => $home4_image['img_1']
                        ],
                        [
                            "_active" => true,
                            "title" => "Find Your Dream Luxury Hotel",
                            "sub_title" => "Discover amzaing places at exclusive deals",
                            "discover_text" => "Discover More",
                            "discover_link" => "#",
                            "bg_image" => $home4_image['img_1']
                        ],
                    ],
                    "style" => "carousel"
                ],
                "component" => "RegularBlock",
                "open" => true
            ],
            [
                "type"=>"list_locations",
                "name"=>"List Locations",
                "model"=>[
                    "service_type"=>["hotel"],
                    "title"=>"Destinations Travellers Love",
                    "desc"=>"These popular destinations have a lot to offer",
                    "number"=>10,
                    "layout"=>"style_3",
                    "order"=>"id",
                    "order_by"=>"desc",
                    "custom_ids"=>[],
                    "to_location_detail"=>""
                ],
                "component"=>"RegularBlock",
                "open"=>true
            ],
            [
                "type" => "list_hotel",
                "name" => "Hotel: List Items",
                "model" => [
                    "title" => "Popular Hotels",
                    "desc" => "Interdum et malesuada fames ac ante ipsum",
                    "number" => 32,
                    "style" => "normal",
                    "location_ids" => [1, 2, 3, 4],
                    "order" => "id",
                    "order_by" => "desc",
                    "is_featured" => "",
                    "custom_ids" => []
                ],
                "component" => "RegularBlock",
                "open" => true
            ],
            [
                "type" => "call_to_action",
                "name" => "Call To Action",
                "model" => [
                    "title" => "Happy Holiday",
                    "sub_title" => "Get Amazing Rates at Hotels Worldwide",
                    "link_title" => "Find Deals",
                    "link_more" => "#",
                    "style" => "",
                    "bg_image" => $home4_image['img_2'],
                    "list_item" => [
                        [
                            "_active" => true,
                            "title" => "Destinations",
                            "number" => "4,958"
                        ],
                        [
                            "_active" => true,
                            "title" => "Total Properties",
                            "number" => "2,869"
                        ],
                        [
                            "_active" => true,
                            "title" => "Happy customers",
                            "number" => "2M"
                        ],
                        [
                            "_active" => true,
                            "title" => "Our Volunteers",
                            "number" => "574,974"
                        ]
                    ]
                ],
                "component" => "RegularBlock",
                "open" => true
            ],
            [
                "type"=>"list_featured_item",
                "name"=>"List Featured Item",
                "model"=>[
                    "title"=>"Why Choose Us",
                    "sub_title"=>"These popular destinations have a lot to offer",
                    "list_item"=>[
                        [
                            "_active"=>true,
                            "title"=>"Best Price Guarantee",
                            "sub_title"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                            "icon_image"=>$home1_image['img_4'],
                            "order"=>1
                        ],
                        [
                            "_active"=>true,
                            "title"=>"Easy & Quick Booking",
                            "sub_title"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                            "icon_image"=>$home1_image['img_5'],
                            "order"=>2
                        ],
                        [
                            "_active"=>true,
                            "title"=>"Customer Care 24/7",
                            "sub_title"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                            "icon_image"=>$home1_image['img_6'],
                            "order"=>3
                        ]
                    ],
                    "style"=>"normal"
                ],
                "component"=>"RegularBlock",
                "open"=>true
            ],
            [
                "type" => "list_hotel",
                "name" => "Hotel: List Items",
                "model" => [
                    "title" => "GoTrip Choice of Hotels",
                    "desc" => "Interdum et malesuada fames ac ante ipsum",
                    "number" => 4,
                    "style" => "carousel_v2",
                    "location_ids" => [],
                    "order" => "id",
                    "order_by" => "desc",
                    "is_featured" => "",
                    "custom_ids" => []
                ],
                "component" => "RegularBlock",
                "open" => true
            ],
            [
                "type"=>"testimonial",
                "name"=>"List Testimonial",
                "model"=>[
                    "title"=>"Overheard from travelers",
                    "subtitle"=>"These popular destinations have a lot to offer",
                    "happy_people_number"=>"13m+",
                    "happy_people_text"=>"Happy People",
                    "overall_rating_number"=>"4.88",
                    "overall_rating_text"=>"Overall rating",
                    "overall_rating_star"=>"5",
                    "style"=>"style_3",
                    "list_item"=>[
                        [
                            "_active"=>true,
                            "title"=>"Hotel Equatorial Melaka",
                            "name"=>"Courtney Henry",
                            "job"=>"Web Designer",
                            "desc"=>"\"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic.\"",
                            "number_star"=>null,
                            "avatar"=>$home1_image['img_7']
                        ],
                        [
                            "_active"=>true,
                            "title"=>"Hotel Equatorial Melaka",
                            "name"=>"Courtney Henry",
                            "job"=>"Web Designer",
                            "desc"=>"\"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic.\"",
                            "number_star"=>null,
                            "avatar"=>$home1_image['img_7']
                        ],
                        [
                            "_active"=>true,
                            "title"=>"Hotel Equatorial Melaka",
                            "name"=>"Courtney Henry",
                            "job"=>"Web Designer",
                            "desc"=>"\"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic.\"",
                            "number_star"=>null,
                            "avatar"=>$home1_image['img_7']
                        ],
                        [
                            "_active"=>true,
                            "title"=>"Hotel Equatorial Melaka",
                            "name"=>"Courtney Henry",
                            "job"=>"Web Designer",
                            "desc"=>"\"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic.\"",
                            "number_star"=>null,
                            "avatar"=>$home1_image['img_7']
                        ],
                        [
                            "_active"=>true,
                            "title"=>"Hotel Equatorial Melaka",
                            "name"=>"Courtney Henry",
                            "job"=>"Web Designer",
                            "desc"=>"\"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic.\"",
                            "number_star"=>null,
                            "avatar"=>$home1_image['img_7']
                        ],
                    ],
                    "title_trusted"=>"",
                    "list_trusted"=>[
                        ["avatar"=>$home2_image['img_9']],
                        ["avatar"=>$home2_image['img_10']],
                        ["avatar"=>$home2_image['img_11']],
                        ["avatar"=>$home2_image['img_12']],
                        ["avatar"=>$home2_image['img_13']],
                        ["avatar"=>$home2_image['img_14']]
                    ]
                ],
                "component"=>"RegularBlock",
                "open"=>true
            ],
            [
                "type"=>"list_news",
                "name"=>"News: List Items",
                "model"=>[
                    "title"=>"Get inspiration for your next trip",
                    "header_align"=>"center",
                    "desc"=>"Interdum et malesuada fames",
                    "number"=>4,
                    "bg_image"=>"",
                    "category_id"=>"",
                    "order"=>"id",
                    "order_by"=>"desc",
                    "bg_color"=>"",
                    "style"=>"style_2"
                ],
                "component"=>"RegularBlock",
                "open"=>true
            ],
            [
                "type"=>"subscribe",
                "name"=>"Subscribe",
                "model"=>[
                    "title"=>"Your Travel Journey Starts Here",
                    "sub_title"=>"Sign up and we'll send the best deals to you",
                    "bg_image"=>$home2_image['img_15'],
                    "style"=>"style_2"
                ],
                "component"=>"RegularBlock",
                "open"=>true,
                "is_container"=>false
            ],
        ];
        DB::table('core_templates')->insert([
            'title'       => 'Home Hotel',
            'content'     => json_encode($home4),
            'create_user' => '1',
            'created_at'  => date("Y-m-d H:i:s")
        ]);
        DB::table('core_template_translations')->insert([
            'origin_id' => '3',
            'locale' => 'ja',
            'title' => 'Home Hotel',
            'content' => json_encode($home4),
            'create_user' => '1',
            'created_at' => date("Y-m-d H:i:s")
        ]);


        DB::table('core_pages')->insert([
            'title' => 'Home Hotel',
            'slug' => 'hotel',
            'template_id' => '3',
            'header_style' => 'transparent_v3',
            'footer_style' => 'normal',
            'disable_subscribe_default' => 1,
            'create_user' => '1',
            'status' => 'publish',
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        $home5_image = [
            'img_1' => DB::table('media_files')->insertGetId(['file_name' => 'home5-bg', 'file_path' => 'gotrip/general/home5/1.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_2' => DB::table('media_files')->insertGetId(['file_name' => 'call-to-action-home5', 'file_path' => 'gotrip/general/home5/5.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_3' => DB::table('media_files')->insertGetId(['file_name' => 'home5-tour-deals', 'file_path' => 'gotrip/general/home5/6.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_4' => DB::table('media_files')->insertGetId(['file_name' => 'avt-1', 'file_path' => 'gotrip/general/home5/avt-1.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_5' => DB::table('media_files')->insertGetId(['file_name' => 'avt-2', 'file_path' => 'gotrip/general/home5/avt-2.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_6' => DB::table('media_files')->insertGetId(['file_name' => 'avt-3', 'file_path' => 'gotrip/general/home5/avt-3.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_7' => DB::table('media_files')->insertGetId(['file_name' => 'avt-4', 'file_path' => 'gotrip/general/home5/avt-4.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_8' => DB::table('media_files')->insertGetId(['file_name' => 'avt-5', 'file_path' => 'gotrip/general/home5/avt-5.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_9' => DB::table('media_files')->insertGetId(['file_name' => 'avt-bg', 'file_path' => 'gotrip/general/home5/bg.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
        ];

        $home5 = [
            [
                "type" => "form_search_tour",
                "name" => "Tour: Form Search",
                "model" => [
                    "title" => "Best Travel Experience",
                    "sub_title" => "Experience the various exciting tour and travel packages and Make hotel reservations, find vacation packages, search cheap hotels and events",
                    "style" => "",
                    "bg_image" => $home5_image['img_1'],
                    "list_slider" => []
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "list_tours",
                "name" => "Tour: List Items",
                "model" => [
                    "title" => "Most Popular Tours",
                    "desc" => "Interdum et malesuada fames ac ante ipsum",
                    "number" => 5,
                    "style" => "carousel",
                    "category_id" => "",
                    "location_id" => "",
                    "order" => "id",
                    "order_by" => "desc",
                    "is_featured" => "",
                    "custom_ids" => []
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "tour_types",
                "name" => "Tour: Tour Types",
                "model" => [
                    "title" => "Choose Tour Types",
                    "desc" => "Interdum et malesuada fames ac ante ipsum",
                    "number" => "",
                    "style" => "carousel",
                    "order" => "id",
                    "order_by" => "desc"
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "list_locations",
                "name" => "List Locations",
                "model" => [
                    "service_type" => ["tour"],
                    "title" => "Explore Hot Locations",
                    "desc" => "Interdum et malesuada fames ac ante ipsum",
                    "number" => 8,
                    "layout" => "style_5",
                    "order" => "id",
                    "order_by" => "desc",
                    "custom_ids" => "",
                    "to_location_detail" => "",
                    "view_all_url" => ""
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "tour_deals",
                "name" => "Tour: Tour Deals",
                "model" => [
                    "title" => "Deals & Discounts",
                    "desc" => "Interdum et malesuada fames ac ante ipsum",
                    "number" => 5,
                    "order" => "id",
                    "order_by" => "desc",
                    "book_title" => "Enjoy Summer Deals",
                    "book_desc" => "Book Early to Save",
                    "book_url" => "#",
                    "book_url_text" => "Book Now",
                    "book_img" => $home5_image['img_3']
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "call_to_action",
                "name" => "Call To Action",
                "model" => [
                    "title" => "",
                    "sub_title" => "",
                    "link_title" => "",
                    "link_more" => "",
                    "style" => "style_4",
                    "bg_image" => "",
                    "list_item" => [
                        [
                            "_active" => true,
                            "title" => "Destinations",
                            "number" => "4,958"
                        ],
                        [
                            "_active" => true,
                            "title" => "Total Properties",
                            "number" => "2,869"
                        ],
                        [
                            "_active" => true,
                            "title" => "Happy customers",
                            "number" => "2M"
                        ],
                        [
                            "_active" => true,
                            "title" => "Our Volunteers",
                            "number" => "574,974"
                        ]
                    ]
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "list_featured_item",
                "name" => "List Featured Item",
                "model" => [
                    "title" => "Why Choose Us",
                    "sub_title" => "These popular destinations have a lot to offer",
                    "list_item" => [
                        [
                            "_active" => true,
                            "title" => "Best Price Guarantee",
                            "sub_title" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                            "icon_image" => $home1_image['img_4'],
                            "order" => 1
                        ],
                        [
                            "_active" => true,
                            "title" => "Easy & Quick Booking",
                            "sub_title" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                            "icon_image" => $home1_image['img_5'],
                            "order" => 2
                        ],
                        [
                            "_active" => true,
                            "title" => "Customer Care 24/7",
                            "sub_title" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                            "icon_image" => $home1_image['img_6'],
                            "order" => 3
                        ]
                    ],
                    "style" => "style3",
                    "youtube_image" => $home5_image['img_2'],
                    "youtube" => ""
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "testimonial",
                "name" => "List Testimonial",
                "model" => [
                    "title" => "Customer Reviews",
                    "subtitle" => "Interdum et malesuada fames ac ante ipsum",
                    "happy_people_number" => "",
                    "happy_people_text" => "",
                    "overall_rating_number" => "",
                    "overall_rating_text" => "",
                    "overall_rating_star" => "",
                    "style" => "style_4",
                    "list_item" => [
                        [
                            "_active" => true,
                            "title" => "Hotel Equatorial Melaka",
                            "name" => "Brooklyn Simmons",
                            "job" => "Web Developer",
                            "desc" => "\"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic. \"",
                            "number_star" => null,
                            "avatar" => $home5_image['img_4']
                        ],
                        [
                            "_active" => true,
                            "title" => "Hotel Equatorial Melaka",
                            "name" => "Brooklyn Simmons",
                            "job" => "Web Developer",
                            "desc" => "\"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic. \"",
                            "number_star" => null,
                            "avatar" => $home5_image['img_5']
                        ],
                        [
                            "_active" => true,
                            "title" => "Hotel Equatorial Melaka",
                            "name" => "Brooklyn Simmons",
                            "job" => "Web Developer",
                            "desc" => "\"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic. \"",
                            "number_star" => null,
                            "avatar" => $home5_image['img_6']
                        ],
                        [
                            "_active" => true,
                            "title" => "Hotel Equatorial Melaka",
                            "name" => "Brooklyn Simmons",
                            "job" => "Web Developer",
                            "desc" => "\"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic. \"",
                            "number_star" => null,
                            "avatar" => $home5_image['img_7']
                        ],
                        [
                            "_active" => true,
                            "title" => "Hotel Equatorial Melaka",
                            "name" => "Brooklyn Simmons",
                            "job" => "Web Developer",
                            "desc" => "\"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic. \"",
                            "number_star" => null,
                            "avatar" => $home5_image['img_8']
                        ],
                    ],
                    "title_trusted" => "Trusted by the world’s best",
                    "list_trusted"=>[
                        ["_active"=>true,"title"=>"","avatar"=>$home2_image['img_9']],
                        ["_active"=>true,"title"=>"","avatar"=>$home2_image['img_10']],
                        ["_active"=>true,"title"=>"","avatar"=>$home2_image['img_11']],
                        ["_active"=>true,"title"=>"","avatar"=>$home2_image['img_12']],
                        ["_active"=>true,"title"=>"","avatar"=>$home2_image['img_13']],
                        ["_active"=>true,"title"=>"","avatar"=>$home2_image['img_14']]
                    ],
                    "testimonial_bg" => $home5_image['img_9']
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type"=>"list_news",
                "name"=>"News: List Items",
                "model"=>[
                    "title"=>"Get inspiration for your next trip",
                    "header_align"=>"center",
                    "desc"=>"Interdum et malesuada fames",
                    "number"=>3,
                    "bg_image"=>"",
                    "category_id"=>"",
                    "order"=>"id",
                    "order_by"=>"desc",
                    "bg_color"=>"",
                    "style"=>""
                ],
                "component"=>"RegularBlock",
                "open"=>true
            ],
            [
                "type"=>"login_register",
                "name"=>"Login Register",
                "model"=>[
                    "title"=>"Not a Member Yet?",
                    "sub_title"=>"Join us! Our members can access savings of up to 50% and earn Trip Coins while booking.",
                    "style" => 'style_1'
                ],
                "component"=>"RegularBlock",
                "open"=>true
            ]
        ];

        DB::table('core_templates')->insert([
            'title'       => 'Home Tour',
            'content'     => json_encode($home5),
            'create_user' => '1',
            'created_at'  => date("Y-m-d H:i:s")
        ]);
        DB::table('core_template_translations')->insert([
            'origin_id' => '2',
            'locale' => 'ja',
            'title' => 'Home Tour',
            'content' => json_encode($home5),
            'create_user' => '1',
            'created_at' => date("Y-m-d H:i:s")
        ]);


        DB::table('core_pages')->insert([
            'title' => 'Home Tour',
            'slug' => 'home-tour',
            'template_id' => '4',
            'header_style' => 'transparent_v4',
            'footer_style' => 'style_4',
            'disable_subscribe_default' => 1,
            'create_user' => '1',
            'status' => 'publish',
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        $home7_image = [
            'img_1' => DB::table('media_files')->insertGetId(['file_name' => 'home7-bg', 'file_path' => 'gotrip/general/home7/bg-1.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_2' => DB::table('media_files')->insertGetId(['file_name' => 'testimonial-home7', 'file_path' => 'gotrip/general/home7/testimonial-1.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_3' => DB::table('media_files')->insertGetId(['file_name' => 'avatar-home7', 'file_path' => 'gotrip/general/home7/avatar-1.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_4' => DB::table('media_files')->insertGetId(['file_name' => 'subscribe-home7', 'file_path' => 'gotrip/general/home7/subscribe-1.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
        ];

        $home7 = [
            [
                "type" => "form_search_space",
                "name" => "Space: Form Search",
                "model" => [
                    "list_slider" => [
                        [
                            "_active" => true,
                            "title" => 'Unique Houses Are Waiting<br class="lg:d-none"> For You',
                            "sub_title" => "Discover amzaing places at exclusive deals",
                            "bg_image" => $home7_image['img_1']
                        ],
                        [
                            "_active" => true,
                            "title" => 'Unique Houses Are Waiting<br class="lg:d-none"> For You',
                            "sub_title" => "Discover amzaing places at exclusive deals",
                            "bg_image" => $home7_image['img_1']
                        ],
                        [
                            "_active" => true,
                            "title" => 'Unique Houses Are Waiting<br class="lg:d-none"> For You',
                            "sub_title" => "Discover amzaing places at exclusive deals",
                            "bg_image" => $home7_image['img_1']
                        ],
                        [
                            "_active" => true,
                            "title" => 'Unique Houses Are Waiting<br class="lg:d-none"> For You',
                            "sub_title" => "Discover amzaing places at exclusive deals",
                            "bg_image" => $home7_image['img_1']
                        ],
                        [
                            "_active" => true,
                            "title" => 'Unique Houses Are Waiting<br class="lg:d-none"> For You',
                            "sub_title" => "Discover amzaing places at exclusive deals",
                            "bg_image" => $home7_image['img_1']
                        ],
                    ],
                    "style" => ""
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "list_locations",
                "name" => "List Locations",
                "model" => [
                    "service_type" => ["space"],
                    "title" => "Explore by Locations of Stays",
                    "desc" => "These popular destinations have a lot to offer",
                    "number" => 5,
                    "layout" => "style_7",
                    "order" => "id",
                    "order_by" => "desc",
                    "custom_ids" => "",
                    "to_location_detail" => "",
                    "view_all_url" => ""
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "list_space",
                "name" => "Space: List Items",
                "model" => [
                    "title" => "Homes Guests Love",
                    "desc" => "Interdum et malesuada fames ac ante ipsum",
                    "number" => 4,
                    "style" => "normal",
                    "location_id" => "",
                    "order" => "id",
                    "order_by" => "desc",
                    "is_featured" => "",
                    "custom_ids" => ""
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "list_locations",
                "name" => "List Locations",
                "model" => [
                    "service_type" => [
                        "space"
                    ],
                    "title" => "Top Destinations",
                    "desc" => "These popular destinations have a lot to offer",
                    "number" => 6,
                    "layout" => "style_8",
                    "order" => "id",
                    "order_by" => "desc",
                    "custom_ids" => [1, 10, 4, 13, 12, 11],
                    "to_location_detail" => false,
                    "view_all_url" => ""
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "testimonial",
                "name" => "List Testimonial",
                "model" => [
                    "title" => "Testimonials",
                    "subtitle" => "Interdum et malesuada fames ac ante ipsum",
                    "happy_people_number" => "",
                    "happy_people_text" => "",
                    "overall_rating_number" => "",
                    "overall_rating_text" => "",
                    "overall_rating_star" => "",
                    "style" => "style_6",
                    "list_item" => [
                        [
                            "_active" => true,
                            "title" => "",
                            "name" => "Ali Tufan",
                            "job" => "Product Manager, Apple Inc",
                            "desc" => '"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic."',
                            "number_star" => null,
                            "avatar" => $home7_image['img_3']
                        ],
                        [
                            "_active" => true,
                            "title" => "",
                            "name" => "Ali Tufan",
                            "job" => "Product Manager, Apple Inc",
                            "desc" => '"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic."',
                            "number_star" => null,
                            "avatar" => $home7_image['img_3']
                        ],
                        [
                            "_active" => true,
                            "title" => "",
                            "name" => "Ali Tufan",
                            "job" => "Product Manager, Apple Inc",
                            "desc" => '"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic."',
                            "number_star" => null,
                            "avatar" => $home7_image['img_3']
                        ],
                        [
                            "_active" => true,
                            "title" => "",
                            "name" => "Ali Tufan",
                            "job" => "Product Manager, Apple Inc",
                            "desc" => '"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic."',
                            "number_star" => null,
                            "avatar" => $home7_image['img_3']
                        ],
                        [
                            "_active" => true,
                            "title" => "",
                            "name" => "Ali Tufan",
                            "job" => "Product Manager, Apple Inc",
                            "desc" => '"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic."',
                            "number_star" => null,
                            "avatar" => $home7_image['img_3']
                        ],
                    ],
                    "title_trusted" => "",
                    "list_trusted" => [
                    ],
                    "testimonial_bg" => $home7_image['img_2']
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "call_to_action",
                "name" => "Call To Action",
                "model" => [
                    "title" => "",
                    "sub_title" => "",
                    "link_title" => "",
                    "link_more" => "",
                    "style" => "style_5",
                    "bg_image" => "",
                    "list_item" => [
                        [
                            "_active" => true,
                            "title" => "Destinations",
                            "number" => "4,958"
                        ],
                        [
                            "_active" => true,
                            "title" => "Total Properties",
                            "number" => "2,869"
                        ],
                        [
                            "_active" => true,
                            "title" => "Happy customers",
                            "number" => "2M"
                        ],
                        [
                            "_active" => true,
                            "title" => "Our Volunteers",
                            "number" => "574,974"
                        ]
                    ],
                    "border" => "bottom"
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "list_news",
                "name" => "News: List Items",
                "model" => [
                    "title" => "Get inspiration for your next trip",
                    "header_align" => "center",
                    "desc" => "Interdum et malesuada fames",
                    "number" => 3,
                    "bg_image" => "",
                    "category_id" => "",
                    "order" => "id",
                    "order_by" => "desc",
                    "bg_color" => "",
                    "style" => "style_6",
                    "link_title" => "",
                    "link_more" => ""
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type"=>"list_featured_item",
                "name"=>"List Featured Item",
                "model"=>[
                    "title"=>"Why Choose Us",
                    "sub_title"=>"These popular destinations have a lot to offer",
                    "list_item"=>[
                        [
                            "_active"=>true,
                            "title"=>"Best Price Guarantee",
                            "sub_title"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                            "icon_image"=>$home1_image['img_4'],
                            "order"=>1
                        ],
                        [
                            "_active"=>true,
                            "title"=>"Easy & Quick Booking",
                            "sub_title"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                            "icon_image"=>$home1_image['img_5'],
                            "order"=>2
                        ],
                        [
                            "_active"=>true,
                            "title"=>"Customer Care 24/7",
                            "sub_title"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                            "icon_image"=>$home1_image['img_6'],
                            "order"=>3
                        ]
                    ],
                    "style"=>"normal"
                ],
                "component"=>"RegularBlock",
                "open"=>true
            ],
            [
                "type"=>"subscribe",
                "name"=>"Subscribe",
                "model"=>[
                    "title"=>"Your Travel Journey Starts Here",
                    "sub_title"=>"Sign up and we'll send the best deals to you",
                    "bg_image"=>$home7_image['img_4'],
                    "style"=>""
                ],
                "component"=>"RegularBlock",
                "open"=>true,
                "is_container"=>false
            ]
        ];

        DB::table('core_templates')->insert([
            'title'       => 'Home Space',
            'content'     => json_encode($home7),
            'create_user' => '1',
            'created_at'  => date("Y-m-d H:i:s")
        ]);
        DB::table('core_template_translations')->insert([
            'origin_id' => '2',
            'locale' => 'ja',
            'title' => 'Home Space',
            'content' => json_encode($home7),
            'create_user' => '1',
            'created_at' => date("Y-m-d H:i:s")
        ]);


        DB::table('core_pages')->insert([
            'title' => 'Home Space',
            'slug' => 'home-space',
            'template_id' => '5',
            'header_style' => 'transparent_v5',
            'footer_style' => 'normal',
            'disable_subscribe_default' => 1,
            'create_user' => '1',
            'status' => 'publish',
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        $home_car_images = [
            'hero_slider' => DB::table('media_files')->insertGetId(['file_name' => 'hero-slider', 'file_path' => 'gotrip/general/home6/hero-slider.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'hero_bg' => DB::table('media_files')->insertGetId(['file_name' => 'hero-bg', 'file_path' => 'gotrip/general/home6/hero-bg.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'feature_item_4' => DB::table('media_files')->insertGetId(['file_name' => 'feature-item-4', 'file_path' => 'gotrip/general/home6/feature-item-4.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'feature_item_5' => DB::table('media_files')->insertGetId(['file_name' => 'feature-item-5', 'file_path' => 'gotrip/general/home6/feature-item-5.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'feature_item_6' => DB::table('media_files')->insertGetId(['file_name' => 'feature-item-6', 'file_path' => 'gotrip/general/home6/feature-item-6.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'amazon' => DB::table('media_files')->insertGetId(['file_name' => 'amazon', 'file_path' => 'gotrip/general/home6/amazon.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'amd' => DB::table('media_files')->insertGetId(['file_name' => 'amd', 'file_path' => 'gotrip/general/home6/amd.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'cisco' => DB::table('media_files')->insertGetId(['file_name' => 'cisco', 'file_path' => 'gotrip/general/home6/cisco.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'dropcam' => DB::table('media_files')->insertGetId(['file_name' => 'dropcam', 'file_path' => 'gotrip/general/home6/dropcam.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'download_app' => DB::table('media_files')->insertGetId(['file_name' => 'download-app', 'file_path' => 'gotrip/general/home6/download-app.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
        ];

        $home_car = [
            [
                'type' => 'form_search_car',
                'name' => 'Car: Form Search',
                'model' => [
                    'title' => 'Search for the Best Car Hire Deals',
                    'sub_title' => 'Book better cars from local hosts across the US and around the world.',
                    'style' => 'carousel',
                    'bg_image' => $home_car_images['hero_bg'],
                    'list_slider' => [
                        [
                            '_active' => true,
                            'bg_image' => $home_car_images['hero_slider'],
                        ],
                        [
                            '_active' => true,
                            'bg_image' => $home_car_images['hero_slider'],
                        ],
                    ],
                ],
                'component' => 'RegularBlock',
                'open' => true,
                'is_container' => false,
            ],
            [
                'type' => 'list_featured_item',
                'name' => 'List Featured Item',
                'model' => [
                    'title' => 'Why Choose Us',
                    'sub_title' => 'These popular destinations have a lot to offer',
                    'list_item' => [
                        [
                            '_active' => true,
                            'title' => 'Best Price Guarantee',
                            'sub_title' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                            'icon_image' => $home_car_images['feature_item_4'],
                            'order' => NULL,
                        ],
                        [
                            '_active' => true,
                            'title' => 'Easy & Quick Booking',
                            'sub_title' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                            'icon_image' => $home_car_images['feature_item_5'],
                            'order' => NULL,
                        ],
                        [
                            '_active' => true,
                            'title' => 'Customer Care 24/7',
                            'sub_title' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                            'icon_image' => $home_car_images['feature_item_6'],
                            'order' => NULL,
                        ],
                    ],
                    'style' => 'style4',
                    'youtube_image' => '',
                    'youtube' => '',
                ],
                'component' => 'RegularBlock',
                'open' => true,
                'is_container' => false,
            ],
            [
                'type' => 'list_car',
                'name' => 'Car: List Items',
                'model' => [
                    'title' => 'Popular Car Hire',
                    'desc' => 'Interdum et malesuada fames ac ante ipsum',
                    'number' => 8,
                    'style' => 'style_2',
                    'location_id' => '',
                    'order' => 'title',
                    'order_by' => 'asc',
                    'is_featured' => '',
                    'custom_ids' => [],
                ],
                'component' => 'RegularBlock',
                'open' => true,
                'is_container' => false,
            ],
            [
                'type' => 'list_locations',
                'name' => 'List Locations',
                'model' => [
                    'service_type' => [
                        'hotel',
                        'space',
                        'car',
                        'event',
                        'tour',
                        'boat',
                    ],
                    'title' => 'Top Destinations in UK',
                    'desc' => 'These popular destinations have a lot to offer',
                    'number' => 6,
                    'layout' => 'style_6',
                    'order' => 'id',
                    'order_by' => 'desc',
                    'custom_ids' => [
                    ],
                    'to_location_detail' => false,
                    'view_all_url' => '',
                ],
                'component' => 'RegularBlock',
                'open' => true,
                'is_container' => false,
            ],
            [
                'type' => 'testimonial',
                'name' => 'List Testimonial',
                'model' => [
                    'title' => 'Customer Reviews',
                    'subtitle' => 'These popular destinations have a lot to offer',
                    'happy_people_number' => '13m+',
                    'happy_people_text' => 'Happy People',
                    'overall_rating_number' => '4.88',
                    'overall_rating_text' => 'Overall rating',
                    'overall_rating_star' => '5',
                    'style' => 'style_5',
                    'list_item' => [
                        [
                            '_active' => false,
                            'title' => 'Hotel Equatorial Melaka',
                            'name' => 'Courtney Henry',
                            'job' => 'Web Designer',
                            'desc' => '"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic."',
                            'number_star' => 5,
                            'avatar' => $home1_image['img_7'],
                        ],
                        [
                            '_active' => false,
                            'title' => 'Hotel Equatorial Melaka',
                            'name' => 'Courtney Henry',
                            'job' => 'Web Designer',
                            'desc' => '"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic."',
                            'number_star' => 5,
                            'avatar' => $home1_image['img_7'],
                        ],
                        [
                            '_active' => false,
                            'title' => 'Hotel Equatorial Melaka',
                            'name' => 'Courtney Henry',
                            'job' => 'Web Designer',
                            'desc' => '"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic."',
                            'number_star' => 5,
                            'avatar' => $home1_image['img_7'],
                        ],
                        [
                            '_active' => false,
                            'title' => 'Hotel Equatorial Melaka',
                            'name' => 'Courtney Henry',
                            'job' => 'Web Designer',
                            'desc' => '"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic."',
                            'number_star' => 5,
                            'avatar' => $home1_image['img_7'],
                        ],
                    ],
                    'title_trusted' => '',
                    'list_trusted' => [
                        [
                            '_active' => true,
                            'avatar' => $home_car_images['amazon'],
                        ],
                        [
                            '_active' => true,
                            'avatar' => $home_car_images['amd'],
                        ],
                        [
                            '_active' => true,
                            'avatar' => $home_car_images['cisco'],
                        ],
                        [
                            '_active' => true,
                            'avatar' => $home_car_images['dropcam'],
                        ],
                    ],
                    'testimonial_bg' => '',
                ],
                'component' => 'RegularBlock',
                'open' => true,
                'is_container' => false,
            ],
            [
                'type' => 'text_featured_box',
                'name' => 'Text Featured Box',
                'model' => [
                    'title' => 'GoTrip is a World Leading Car Hire Booking Platform',
                    'desc' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                    'link_title' => 'Learn More',
                    'link_more' => '#',
                    'list_item' => [
                        [
                            '_active' => false,
                            'title' => 'Destinations',
                            'number' => '4,958',
                        ],
                        [
                            '_active' => false,
                            'title' => 'Total Properties',
                            'number' => '2,869',
                        ],
                        [
                            '_active' => false,
                            'title' => 'Happy customers',
                            'number' => '2M',
                        ],
                        [
                            '_active' => false,
                            'title' => 'Our Volunteers',
                            'number' => '574,974',
                        ],
                    ],
                ],
                'component' => 'RegularBlock',
                'open' => true,
                'is_container' => false,
            ],
            [
                'type' => 'list_news',
                'name' => 'News: List Items',
                'model' => [
                    'title' => 'Get inspiration for your next trip',
                    'header_align' => 'left',
                    'desc' => 'Interdum et malesuada fames',
                    'number' => 4,
                    'bg_image' => '',
                    'category_id' => '',
                    'order' => 'id',
                    'order_by' => 'desc',
                    'bg_color' => '',
                    'style' => 'style_5',
                    'link_title' => 'More',
                    'link_more' => '#',
                ],
                'component' => 'RegularBlock',
                'open' => true,
                'is_container' => false,
            ],
            [
                "type" => "download_app",
                "name" => "Download App",
                "model" => [
                    "title" => "Download the App",
                    "sub_title" => "Book in advance or last-minute with GoTrip. Receive instant confirmation. Access your booking info offline.",
                    "bg_image" => $home_car_images['download_app'],
                    "style" => "style_2",
                    "list_item" => [
                        [
                            '_active' => true,
                            'title' => 'Apple Store',
                            'subtitle' => 'Download on the',
                            'icon' => 'icon-apple',
                            'link' => '#'
                        ],
                        [
                            '_active' => true,
                            'title' => 'Google Play',
                            'subtitle' => 'Get in on',
                            'icon' => 'icon-play-market',
                            'link' => '#'
                        ]
                    ]
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                'type' => 'faqs',
                'name' => 'FAQ List',
                'model' => [
                    'title' => 'Frequently Asked Questions',
                    'desc' => 'Interdum et malesuada fames',
                    'list_item' => [
                        [
                            '_active' => false,
                            'title' => 'What do I need to hire a car?',
                            'sub_title' => '<p><span style="color: #697488; font-family: Jost, sans-serif; font-size: 15px; background-color: #ffffff;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</span></p>',
                        ],
                        [
                            '_active' => false,
                            'title' => 'How old do I have to be to rent a car?',
                            'sub_title' => '<p><span style="color: #697488; font-family: Jost, sans-serif; font-size: 15px; background-color: #ffffff;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</span></p>',
                        ],
                        [
                            '_active' => false,
                            'title' => ' Can I book a hire car for someone else?',
                            'sub_title' => '<p><span style="color: #697488; font-family: Jost, sans-serif; font-size: 15px; background-color: #ffffff;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</span></p>',
                        ],
                        [
                            '_active' => false,
                            'title' => 'How do I find the cheapest car hire deal?',
                            'sub_title' => '<p><span style="color: #697488; font-family: Jost, sans-serif; font-size: 15px; background-color: #ffffff;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</span></p>',
                        ],
                        [
                            '_active' => false,
                            'title' => 'What should I look for when I\'m choosing a car?',
                            'sub_title' => '<p><span style="color: #697488; font-family: Jost, sans-serif; font-size: 15px; background-color: #ffffff;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</span></p>',
                        ],
                    ],
                ],
                'component' => 'RegularBlock',
                'open' => true,
            ],
        ];

        DB::table('core_templates')->insert([
            'title'       => 'Home Car',
            'content'     => json_encode($home_car),
            'create_user' => '1',
            'created_at'  => date("Y-m-d H:i:s")
        ]);
        DB::table('core_template_translations')->insert([
            'origin_id' => '6',
            'locale' => 'ja',
            'title' => 'Home Car',
            'content' => json_encode($home_car),
            'create_user' => '1',
            'created_at' => date("Y-m-d H:i:s")
        ]);


        DB::table('core_pages')->insert([
            'title' => 'Home Car',
            'slug' => 'home-car',
            'template_id' => '6',
            'header_style' => 'transparent_v6',
            'footer_style' => 'style_3',
            'disable_subscribe_default' => 1,
            'create_user' => '1',
            'status' => 'publish',
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        //Home Boat
        $home_boat_images = [
            'boat_hero_bg' => DB::table('media_files')->insertGetId(['file_name' => 'boat-hero-bg', 'file_path' => 'gotrip/general/home-boat/boat-hero-bg.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'boat_text_image_1' => DB::table('media_files')->insertGetId(['file_name' => 'boat-text-image-1', 'file_path' => 'gotrip/general/home-boat/boat-text-image-1.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'boat_text_image_2' => DB::table('media_files')->insertGetId(['file_name' => 'boat-text-image-2', 'file_path' => 'gotrip/general/home-boat/boat-text-image-2.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'boat_why_1' => DB::table('media_files')->insertGetId(['file_name' => 'boat-why-1', 'file_path' => 'gotrip/general/home-boat/boat-why-1.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'boat_why_2' => DB::table('media_files')->insertGetId(['file_name' => 'boat-why-2', 'file_path' => 'gotrip/general/home-boat/boat-why-2.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'boat_why_3' => DB::table('media_files')->insertGetId(['file_name' => 'boat-why-3', 'file_path' => 'gotrip/general/home-boat/boat-why-3.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'boat_why_4' => DB::table('media_files')->insertGetId(['file_name' => 'boat-why-4', 'file_path' => 'gotrip/general/home-boat/boat-why-4.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'boat_quote_2' => DB::table('media_files')->insertGetId(['file_name' => 'boat-quote-2', 'file_path' => 'gotrip/general/home-boat/boat-quote-2.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'boat_testimonial_bg' => DB::table('media_files')->insertGetId(['file_name' => 'boat-testimonial-bg', 'file_path' => 'gotrip/general/home-boat/boat-testimonial-bg.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
        ];
        $home_boat = [
            [
                "type" => "form_search_boat",
                "name" => "Boat: Form Search",
                "model" => [
                    "title" => "",
                    "sub_title" => "",
                    "style" => "boatousel",
                    "bg_image" => "",
                    "list_slider" => [
                        [
                            "_active" => false,
                            "title" => "Find The Best Cruise<br class=\"md:d-none\"> For You",
                            "sub_title" => "TOUR EXPERIENCE",
                            "bg_image" => $home_boat_images['boat_hero_bg']
                        ],
                        [
                            "_active" => true,
                            "title" => "Find The Best Cruise<br class=\"md:d-none\"> For You",
                            "sub_title" => "TOUR EXPERIENCE",
                            "bg_image" => $home_boat_images['boat_hero_bg']
                        ]
                    ],
                    "scroll_down_id" => "#secondSection"
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "list_locations",
                "name" => "List Locations",
                "model" => [
                    "layout" => "style_9",
                    "service_type" => [
                        "hotel",
                        "space",
                        "car",
                        "event",
                        "tour",
                        "boat"
                    ],
                    "title" => "Popular Destinations",
                    "desc" => "Interdum et malesuada fames ac ante ipsum",
                    "number" => 7,
                    "order" => "id",
                    "order_by" => "desc",
                    "custom_ids" => [
                    ],
                    "to_location_detail" => true,
                    "view_all_url" => ""
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "list_boat",
                "name" => "Boat: List Items",
                "model" => [
                    "style" => "style_1",
                    "title" => "Featured Cruise Deals",
                    "desc" => "Interdum et malesuada fames ac ante ipsum",
                    "number" => 4,
                    "location_id" => "",
                    "order" => "id",
                    "order_by" => "desc",
                    "is_featured" => "",
                    "custom_ids" => "",
                    "columns" => "4"
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "text_image",
                "name" => "Text Image",
                "model" => [
                    "title" => "GoTrip is a World Leading Cruise Booking Platform",
                    "desc" => "Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
                    "link_title" => "Learn More",
                    "link_more" => "Learn More",
                    "bg_image_1" => $home_boat_images['boat_text_image_1'],
                    "bg_image_2" => $home_boat_images['boat_text_image_2']
                ],
                "component" => "RegularBlock",
                "open" => true
            ],
            [
                "type" => "list_featured_item",
                "name" => "List Featured Item",
                "model" => [
                    "style" => "style6",
                    "title" => "Why Choose Us",
                    "sub_title" => "These popular destinations have a lot to offer",
                    "description" => "Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
                    "link_title" => "",
                    "link_more" => "#",
                    "list_item" => [
                        [
                            "_active" => false,
                            "title" => "Best Price Guarantee",
                            "sub_title" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                            "icon_image" => $home_boat_images['boat_why_1'],
                            "order" => null
                        ],
                        [
                            "_active" => false,
                            "title" => "Best Price Guarantee",
                            "sub_title" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                            "icon_image" => $home_boat_images['boat_why_2'],
                            "order" => null
                        ],
                        [
                            "_active" => false,
                            "title" => "Best Price Guarantee",
                            "sub_title" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                            "icon_image" => $home_boat_images['boat_why_3'],
                            "order" => null
                        ],
                        [
                            "_active" => false,
                            "title" => "Best Price Guarantee",
                            "sub_title" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                            "icon_image" => $home_boat_images['boat_why_4'],
                            "order" => null
                        ]
                    ],
                    "youtube_image" => "",
                    "youtube" => ""
                ],
                "component" => "RegularBlock",
                "open" => true
            ],
            [
                "type" => "list_boat",
                "name" => "Boat: List Items",
                "model" => [
                    "style" => "style_2",
                    "columns" => "3",
                    "title" => "Recommended Cruise",
                    "desc" => "Interdum et malesuada fames ac ante ipsum",
                    "number" => 3,
                    "location_id" => "",
                    "order" => "id",
                    "order_by" => "desc",
                    "is_featured" => true,
                    "custom_ids" => ""
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "testimonial",
                "name" => "List Testimonial",
                "model" => [
                    "style" => "style_7",
                    "title" => "",
                    "subtitle" => "",
                    "happy_people_number" => "",
                    "happy_people_text" => "",
                    "overall_rating_number" => "",
                    "overall_rating_text" => "",
                    "overall_rating_star" => "",
                    "list_item" => [
                        [
                            "_active" => false,
                            "title" => "",
                            "name" => "Ali Tufan",
                            "job" => "Product Manager, Apple Inc",
                            "desc" => "\"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic.\"",
                            "number_star" => 5,
                            "avatar" => $home_boat_images['boat_quote_2']
                        ],
                        [
                            "_active" => false,
                            "title" => null,
                            "name" => "Ali Tufan",
                            "job" => "Product Manager, VinGroup Inc",
                            "desc" => "\"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic.\"",
                            "number_star" => 5,
                            "avatar" => $home_boat_images['boat_quote_2']
                        ],
                        [
                            "_active" => false,
                            "title" => null,
                            "name" => "Ali Tufan",
                            "job" => "Product Manager, VinGroup Inc",
                            "desc" => "\"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic.\"",
                            "number_star" => 5,
                            "avatar" => $home_boat_images['boat_quote_2']
                        ]
                    ],
                    "title_trusted" => "",
                    "list_trusted" => [
                    ],
                    "testimonial_bg" => $home_boat_images['boat_testimonial_bg']
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "list_news",
                "name" => "News: List Items",
                "model" => [
                    "title" => "Get inspiration for your next trip",
                    "header_align" => "center",
                    "desc" => "Interdum et malesuada fames",
                    "number" => 4,
                    "category_id" => "",
                    "order" => "id",
                    "order_by" => "desc",
                    "style" => "style_5",
                    "link_title" => "",
                    "link_more" => ""
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ]
        ];

        $home_boat_id = DB::table('core_templates')->insertGetId([
            'title'       => 'Home Boat',
            'content'     => json_encode($home_boat),
            'create_user' => '1',
            'created_at'  => date("Y-m-d H:i:s")
        ]);

        DB::table('core_template_translations')->insert([
            'origin_id' => $home_boat_id,
            'locale' => 'ja',
            'title' => 'Home Boat',
            'content' => json_encode($home_boat),
            'create_user' => '1',
            'created_at' => date("Y-m-d H:i:s")
        ]);


        DB::table('core_pages')->insert([
            'title' => 'Home Boat',
            'slug' => 'home-boat',
            'template_id' => $home_boat_id,
            'header_style' => 'transparent_v8',
            'footer_style' => 'style_6',
            'disable_subscribe_default' => 0,
            'create_user' => '1',
            'status' => 'publish',
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        $home10_images = [
            'flight_1' => DB::table('media_files')->insertGetId(['file_name' => 'flight-1', 'file_path' => 'gotrip/general/home10/flight-1.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'flight_2' => DB::table('media_files')->insertGetId(['file_name' => 'flight-2', 'file_path' => 'gotrip/general/home10/flight-2.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
        ];

        $home10 = [
            [
                "type" => "form_search_flight",
                "name" => "Flight Form Search",
                "model" => [
                    "title" => "Where do You Want To Fly",
                    "sub_title" => "Discover amzaing places at exclusive deals",
                    "style" => "carousel_v2",
                    "bg_image" => "",
                    "list_slider" => [
                        [
                            "_active" => true,
                            "bg_image" => $home10_images['flight_1']
                        ],
                        [
                            "_active" => true,
                            "bg_image" => $home10_images['flight_2']
                        ]
                    ]
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "list_featured_item",
                "name" => "List Featured Item",
                "model" => [
                    "style" => "normal",
                    "title" => "Why Choose Us",
                    "sub_title" => "These popular destinations have a lot to offer",
                    "list_item" => [
                        [
                            "_active" => true,
                            "title" => "Best Price Guarantee",
                            "sub_title" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                            "icon_image" => $home1_image['img_4'],
                            "order" => null
                        ],
                        [
                            "_active" => true,
                            "title" => "Easy & Quick Booking",
                            "sub_title" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                            "icon_image" => $home1_image['img_5'],
                            "order" => null
                        ],
                        [
                            "_active" => true,
                            "title" => "Customer Care 24/7",
                            "sub_title" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                            "icon_image" => $home1_image['img_6'],
                            "order" => null
                        ]
                    ],
                    "youtube_image" => "",
                    "youtube" => ""
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "list_locations",
                "name" => "List Locations",
                "model" => [
                    "layout" => "style_1",
                    "service_type" => [
                        "hotel",
                        "space",
                        "car",
                        "tour",
                        "event",
                        "boat"
                    ],
                    "title" => "Top Destinations",
                    "desc" => "These popular destinations have a lot to offer",
                    "number" => 5,
                    "order" => "id",
                    "order_by" => "desc",
                    "custom_ids" => [13,12,11,8,10,5],
                    "to_location_detail" => false,
                    "view_all_url" => ""
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "testimonial",
                "name" => "List Testimonial",
                "model" => [
                    "title" => "What our customers are saying us?",
                    "subtitle" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas varius tortor nibh, sit amet tempor nibh finibus et. Aenean eu enim justo.",
                    "happy_people_number" => "13M+",
                    "happy_people_text" => "Happy People",
                    "overall_rating_number" => "4.88",
                    "overall_rating_text" => "Overall rating",
                    "overall_rating_star" => "5",
                    "style" => "style_2",
                    "list_item" => [
                        [
                            "_active" => false,
                            "title" => null,
                            "name" => "Annette Black",
                            "job" => "UX / UI Designer",
                            "desc" => "The place is in a great location in Gumbet. The area is safe and beautiful. The apartment was comfortable and the host was kind and responsive to our requests.",
                            "number_star" => 5,
                            "avatar" => $home1_image['img_7']
                        ],
                        [
                            "_active" => false,
                            "title" => null,
                            "name" => "Annette Black",
                            "job" => "UX / UI Designer",
                            "desc" => "The place is in a great location in Gumbet. The area is safe and beautiful. The apartment was comfortable and the host was kind and responsive to our requests.",
                            "number_star" => 4,
                            "avatar" => $home1_image['img_7']
                        ],
                        [
                            "_active" => false,
                            "title" => null,
                            "name" => "Annette Black",
                            "job" => "UX / UI Designer",
                            "desc" => "The place is in a great location in Gumbet. The area is safe and beautiful. The apartment was comfortable and the host was kind and responsive to our requests.",
                            "number_star" => null,
                            "avatar" => $home1_image['img_7']
                        ]
                    ],
                    "title_trusted" => "",
                    "list_trusted" => [],
                    "testimonial_bg" => ""
                ],
                "component" => "RegularBlock",
                "open" => true
            ],
            [
                "type" => "list_hotel",
                "name" => "Hotel: List Items",
                "model" => [
                    "title" => "Popular Routes",
                    "desc" => "These popular destinations have a lot to offer",
                    "number" => 4,
                    "style" => "normal2",
                    "location_ids" => "",
                    "order" => "id",
                    "order_by" => "desc",
                    "is_featured" => false,
                    "custom_ids" => "",
                ],
                "component" => "RegularBlock",
                "open" => true,
            ],
            [
                "type" => "download_app",
                "name" => "Download App",
                "model" => [
                    "title" => "Download the App",
                    "sub_title" => "Book in advance or last-minute with GoTrip. Receive instant confirmation. Access your booking info offline.",
                    "bg_image" => $home2_image['img_16'],
                    "style" => "style_4",
                    "list_item" => [
                        [
                            '_active' => true,
                            'title' => 'Apple Store',
                            'subtitle' => 'Download on the',
                            'icon' => 'icon-apple',
                            'link' => '#'
                        ],
                        [
                            '_active' => true,
                            'title' => 'Google Play',
                            'subtitle' => 'Get in on',
                            'icon' => 'icon-play-market',
                            'link' => '#'
                        ]
                    ]
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "list_news",
                "name" => "News List Items",
                "model" => [
                    "title" => "Get inspiration for your next trip",
                    "header_align" => "center",
                    "desc" => "Interdum et malesuada fames",
                    "number" => 3,
                    "category_id" => 3,
                    "order" => "id",
                    "order_by" => "desc",
                    "style" => ""
                ],
                "component" => "RegularBlock",
                "open" => true
            ]
        ];

        $home10_id = DB::table('core_templates')->insertGetId([
            'title'       => 'Home Flight',
            'content'     => json_encode($home10),
            'create_user' => '1',
            'created_at'  => date("Y-m-d H:i:s")
        ]);
        DB::table('core_template_translations')->insert([
            'origin_id' => $home10_id,
            'locale' => 'ja',
            'title' => 'Home Flight',
            'content' => json_encode($home10),
            'create_user' => '1',
            'created_at' => date("Y-m-d H:i:s")
        ]);


        DB::table('core_pages')->insert([
            'title' => 'Home Flight',
            'slug' => 'home-flight',
            'template_id' => $home10_id,
            'header_style' => 'transparent_v9',
            'footer_style' => 'style_8',
            'disable_subscribe_default' => 1,
            'create_user' => '1',
            'status' => 'publish',
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        $home3_images = [
            'home3_bg' => DB::table('media_files')->insertGetId(['file_name' => 'home3-bg', 'file_path' => 'gotrip/general/home3-bg.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'offer_3'  => DB::table('media_files')->insertGetId(['file_name' => 'offer-3', 'file_path' => 'gotrip/general/offer-3.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'localtion_6'  => DB::table('media_files')->insertGetId(['file_name' => 'localtion-6', 'file_path' => 'gotrip/location/6.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
        ];

         $home3 = [
             [
                 "type" => "form_search_all_service",
                 "name" => "Form Search All Service",
                 "model" => [
                     "service_types" => [
                         "hotel",
                         "space",
                         "car",
                         "event",
                         "tour",
                         "flight",
                         "boat"
                     ],
                     "title" => "Discover Your World",
                     "sub_title" => "Discover amzaing places at exclusive deals",
                     "style" => "normal2",
                     "bg_image" => $home3_images['home3_bg'],
                     "list_slider" => [
                     ],
                     "hide_form_search" => false
                 ],
                 "component" => "RegularBlock",
                 "open" => true,
                 "is_container" => false
             ],
             [
                 "type" => "offer_block",
                 "name" => "Offer Block",
                 "model" => [
                     "list_item" => [
                         [
                             "_active" => true,
                             "title" => "Things To Do On Your Trip",
                             "desc" => "",
                             "background_image" => $home1_image['img_2'],
                             "link_title" => "Experiences",
                             "link_more" => "#",
                             "featured_text" => "",
                             "featured_icon" => null,
                             "offer_overLay" => true
                         ],
                         [
                             "_active" => true,
                             "title" => "Let Your Curiosity Do The Booking",
                             "background_image" => $home3_images['offer_3'],
                             "link_title" => "Learn More",
                             "link_more" => null,
                             "featured_text" => null,
                             "featured_icon" => null,
                             "offer_overLay" => true
                         ],
                         [
                             "_active" => true,
                             "title" => "Up to 70% Discount!",
                             "background_image" => $home1_image['img_3'],
                             "link_title" => "Learn More",
                             "link_more" => null,
                             "featured_text" => "Enjoy Summer Deals",
                             "featured_icon" => null,
                             "offer_overLay" => true
                         ]
                     ],
                     "title" => "Special Offers",
                     "subtitle" => "These popular destinations have a lot to offer",
                     "style" => "style2"
                 ],
                 "component" => "RegularBlock",
                 "open" => true,
                 "is_container" => false
             ],
             [
                 "type" => "list_featured_item",
                 "name" => "List Featured Item",
                 "model" => [
                     "style" => "normal",
                     "title" => "Why Choose Us",
                     "sub_title" => "These popular destinations have a lot to offer",
                     "list_item" => [
                         [
                             "_active" => true,
                             "title" => "Best Price Guarantee",
                             "sub_title" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                             "icon_image" => $home_boat_images['boat_why_1'],
                             "order" => 1
                         ],
                         [
                             "_active" => true,
                             "title" => "Easy & Quick Booking",
                             "sub_title" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                             "icon_image" => $home_boat_images['boat_why_2'],
                             "order" => 2
                         ],
                         [
                             "_active" => true,
                             "title" => "Customer Care 24/7",
                             "sub_title" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                             "icon_image" => $home_boat_images['boat_why_3'],
                             "order" => 3
                         ]
                     ],
                     "youtube_image" => "",
                     "youtube" => "",
                     "description" => "",
                     "link_title" => "",
                     "link_more" => ""
                 ],
                 "component" => "RegularBlock",
                 "open" => true,
                 "is_container" => false
             ],
             [
                 "type" => "list_locations",
                 "name" => "List Locations",
                 "model" => [
                     "layout" => "style_10",
                     "service_type" => [
                         "hotel",
                         "space",
                         "car",
                         "event",
                         "tour",
                         "boat"
                     ],
                     "title" => "Top Destinations",
                     "desc" => "These popular destinations have a lot to offer",
                     "number" => 3,
                     "order" => "id",
                     "order_by" => "desc",
                     "custom_ids" => [
                         4,
                         10,
                         14,
                         1,
                         3,
                         6
                     ],
                     "to_location_detail" => "",
                     "view_all_url" => ""
                 ],
                 "component" => "RegularBlock",
                 "open" => true,
                 "is_container" => false
             ],
             [
                 "type" => "list_hotel",
                 "name" => "Hotel: List Items",
                 "model" => [
                     "title" => "Recommended Hotels",
                     "desc" => "Interdum et malesuada fames ac ante ipsum",
                     "number" => 4,
                     "style" => "normal2",
                     "location_ids" => [
                         4,
                         13,
                         10
                     ],
                     "order" => "id",
                     "order_by" => "desc",
                     "is_featured" => false,
                     "custom_ids" => ""
                 ],
                 "component" => "RegularBlock",
                 "open" => true,
                 "is_container" => false
             ],
             [
                 "type" => "list_tours",
                 "name" => "Tour: List Items",
                 "model" => [
                     "title" => "Most Popular Tours",
                     "desc" => "Interdum et malesuada fames ac ante ipsum",
                     "number" => 4,
                     "style" => "normal",
                     "category_id" => "",
                     "location_id" => "",
                     "order" => "id",
                     "order_by" => "desc",
                     "is_featured" => "",
                     "custom_ids" => ""
                 ],
                 "component" => "RegularBlock",
                 "open" => true,
                 "is_container" => false
             ],
             [
                 "type" => "list_event",
                 "name" => "Event: List Items",
                 "model" => [
                     "title" => "Trending Activity",
                     "desc" => "Interdum et malesuada fames ac ante ipsum",
                     "number" => 4,
                     "style" => "style_1",
                     "location_id" => "",
                     "order" => "id",
                     "order_by" => "desc",
                     "is_featured" => "",
                     "custom_ids" => "",
                     "header_align" => "left",
                     "is_view_more" => true
                 ],
                 "component" => "RegularBlock",
                 "open" => true,
                 "is_container" => false
             ],
             [
                 "type" => "list_space",
                 "name" => "Space: List Items",
                 "model" => [
                     "title" => "Featured Holiday Rentals",
                     "desc" => "Interdum et malesuada fames ac ante ipsum",
                     "number" => 4,
                     "style" => "style_1",
                     "location_id" => "",
                     "order" => "id",
                     "order_by" => "desc",
                     "is_featured" => "",
                     "custom_ids" => "",
                     "header_align" => "left",
                     "is_view_more" => true
                 ],
                 "component" => "RegularBlock",
                 "open" => true,
                 "is_container" => false
             ],
             [
                 "type" => "list_car",
                 "name" => "Car: List Items",
                 "model" => [
                     "title" => "Popular Car Hire",
                     "desc" => "Interdum et malesuada fames ac ante ipsum",
                     "number" => 4,
                     "style" => "style_3",
                     "location_id" => "",
                     "order" => "id",
                     "order_by" => "desc",
                     "is_featured" => "",
                     "custom_ids" => "",
                     "header_align" => "left",
                     "is_view_more" => true
                 ],
                 "component" => "RegularBlock",
                 "open" => true,
                 "is_container" => false
             ],
             [
                 "type" => "list_boat",
                 "name" => "Boat: List Items",
                 "model" => [
                     "style" => "style_3",
                     "columns" => "4",
                     "title" => "Featured Cruise Deals",
                     "desc" => "Interdum et malesuada fames ac ante ipsum",
                     "number" => 4,
                     "location_id" => "",
                     "order" => "id",
                     "order_by" => "desc",
                     "is_featured" => "",
                     "custom_ids" => "",
                     "header_align" => "left",
                     "is_view_more" => true
                 ],
                 "component" => "RegularBlock",
                 "open" => true,
                 "is_container" => false
             ]
         ];

        $home3_id = DB::table('core_templates')->insertGetId([
            'title'       => 'Home 3',
            'content'     => json_encode($home3),
            'create_user' => '1',
            'created_at'  => date("Y-m-d H:i:s")
        ]);
        DB::table('core_template_translations')->insert([
            'origin_id' => $home3_id,
            'locale' => 'ja',
            'title' => 'Home 3',
            'content' => json_encode($home3),
            'create_user' => '1',
            'created_at' => date("Y-m-d H:i:s")
        ]);


        DB::table('core_pages')->insert([
            'title' => 'Home 3',
            'slug' => 'home-3',
            'template_id' => $home3_id,
            'header_style' => 'normal_white',
            'footer_style' => 'style_7',
            'disable_subscribe_default' => 1,
            'create_user' => '1',
            'status' => 'publish',
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        setting_update_item('user_role', 3);
        setting_update_item('vendor_team_enable', 1);
        setting_update_item('user_plans_enable', 1);


        //Become An Expert
        $page_become_image = [
            'img_1' => DB::table('media_files')->insertGetId(['file_name' => 'become-call-to-action', 'file_path' => 'gotrip/general/become-call-to-action.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_2' => DB::table('media_files')->insertGetId(['file_name' => 'become-youtube', 'file_path' => 'gotrip/general/become-youtube.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_3' => DB::table('media_files')->insertGetId(['file_name' => 'become-icon-1', 'file_path' => 'gotrip/general/become-icon-1.svg', 'file_type' => 'image/svg', 'file_extension' => 'svg']),
            'img_4' => DB::table('media_files')->insertGetId(['file_name' => 'become-icon-2', 'file_path' => 'gotrip/general/become-icon-2.svg', 'file_type' => 'image/svg', 'file_extension' => 'svg']),
            'img_5' => DB::table('media_files')->insertGetId(['file_name' => 'become-icon-3', 'file_path' => 'gotrip/general/become-icon-3.svg', 'file_type' => 'image/svg', 'file_extension' => 'svg']),
        ];
        $page_become_vendor = [
            [
                'type' => 'call_to_action',
                'name' => 'Call To Action',
                'model' => [
                    'title' => 'Let\'s Show the Beauty of Your <br> City to the World',
                    'sub_title' => 'Discover amzaing places at exclusive deals',
                    'link_title' => 'Register',
                    'link_more' => '#',
                    'style' => 'style_2',
                    'bg_image' => $page_become_image['img_1'],
                    'list_item' => [
                    ],
                ],
                'component' => 'RegularBlock',
                'open' => true,
            ],
            [
                "type" => "vendor_register_form",
                "name" => "Vendor Register Form",
                "model" => [
                    "title" => "Become a vendor",
                    "desc" => "Join our community to unlock your greatest asset and welcome paying guests into your home.",
                    "youtube" => "https://www.youtube.com/watch?v=AmZ0WrEaf34&t=2s",
                    "bg_image" => $home1_image['img_2']
                ],
                "component" => "RegularBlock",
                "open" => true
            ],
            [
                'type' => 'list_featured_item',
                'name' => 'List Featured Item',
                'model' => [
                    'title' => 'How does it work?',
                    'sub_title' => 'These popular destinations have a lot to offer',
                    'list_item' => [
                        0 => [
                            '_active' => true,
                            'title' => 'Sign up',
                            'sub_title' => 'Lorem ipsum dolor sit amet',
                            'icon_image' =>  $page_become_image['img_3'],
                            'order' => 1,
                        ],
                        1 => [
                            '_active' => true,
                            'title' => 'Add your services',
                            'sub_title' => 'Lorem ipsum dolor sit amet',
                            'icon_image' => $page_become_image['img_4'],
                            'order' => 2,
                        ],
                        2 => [
                            '_active' => true,
                            'title' => 'Get bookings',
                            'sub_title' => 'Lorem ipsum dolor sit amet',
                            'icon_image' => $page_become_image['img_5'],
                            'order' => 3,
                        ],
                    ],
                    'style' => 'style2',
                    'youtube_image' => '',
                    'youtube' => '',
                ],
                'component' => 'RegularBlock',
                'open' => true,
            ],
            [
                'type' => 'list_featured_item',
                'name' => 'List Featured Item',
                'model' => [
                    'title' => 'Why be a Local Expert',
                    'sub_title' => 'These popular destinations have a lot to offer',
                    'list_item' => [
                        0 => [
                            '_active' => true,
                            'title' => 'Best Price Guarantee',
                            'sub_title' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                            'icon_image' => $home1_image['img_4'],
                            'order' => NULL,
                        ],
                        1 => [
                            '_active' => true,
                            'title' => 'Easy & Quick Booking',
                            'sub_title' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                            'icon_image' => $home1_image['img_5'],
                            'order' => NULL,
                        ],
                        2 => [
                            '_active' => true,
                            'title' => 'Customer Care 24/7',
                            'sub_title' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                            'icon_image' => $home1_image['img_6'],
                            'order' => NULL,
                        ],
                    ],
                    'style' => 'style3',
                    'youtube_image' => $page_become_image['img_2'],
                    'youtube' => 'https://www.youtube.com/watch?v=DIgv-e18OzA',
                ],
                'component' => 'RegularBlock',
                'open' => true,
            ],
            [
                'type' => 'faqs',
                'name' => 'FAQ List',
                'model' => [
                    'title' => 'Frequently Asked Questions',
                    'desc' => 'Interdum et malesuada fames',
                    'list_item' => [
                        0 => [
                            '_active' => true,
                            'title' => 'What do I need to hire a car?',
                            'sub_title' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>',
                        ],
                        1 => [
                            '_active' => true,
                            'title' => 'How old do I have to be to rent a car?',
                            'sub_title' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>',
                        ],
                        2 => [
                            '_active' => true,
                            'title' => 'Can I book a hire car for someone else?',
                            'sub_title' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>',
                        ],
                        3 => [
                            '_active' => true,
                            'title' => 'How do I find the cheapest car hire deal?',
                            'sub_title' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>',
                        ],
                        4 => [
                            '_active' => true,
                            'title' => 'What should I look for when I\'m choosing a car?',
                            'sub_title' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>',
                        ],
                    ],
                ],
                'component' => 'RegularBlock',
                'open' => true,
            ],
        ];
        $page_become_vendor_id = DB::table('core_templates')->insertGetId([
            'title'       => 'Become An Expert',
            'content'     => json_encode($page_become_vendor),
            'create_user' => '1',
            'created_at'  => date("Y-m-d H:i:s")
        ]);

        DB::table('core_pages')->insert([
            'title' => 'Become An Expert',
            'slug' => 'become-an-expert',
            'template_id' => $page_become_vendor_id,
            'create_user' => '1',
            'status' => 'publish',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        setting_update_item('vendor_page_become_an_expert', $page_become_vendor_id);


        $page_terms_id = DB::table('core_templates')->insertGetId([
            'title'       => 'Terms',
            'content'     => '[{"type":"list_terms","name":"List Terms","model":{"list_item":[{"_active":true,"title":"Terms And Conditions","desc":" <h2 class=\"text-16 fw-500\">1. Your Agreement</h2>\n                                    <p class=\"text-15 text-dark-1 mt-5\">\n                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.\n                                        <br><br>\n                                        It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n                                    </p>\n\n                                    <h2 class=\"text-16 fw-500 mt-35\">2. Change of Terms of Use</h2>\n                                    <p class=\"text-15 text-dark-1 mt-5\">\n                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.\n                                        <br><br>\n                                        It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n                                    </p>\n\n                                    <h2 class=\"text-16 fw-500 mt-35\">3. Access and Use of the Services</h2>\n                                    <p class=\"text-15 text-dark-1 mt-5\">\n                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.\n                                        <br><br>\n                                        It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n                                    </p>"},{"_active":true,"title":"Privacy policy","desc":"<h2 class=\"text-16 fw-500\">1. Your Agreement</h2>\n<p class=\"text-15 text-dark-1 mt-5\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<br /><br />It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\n<h2 class=\"text-16 fw-500 mt-35\">2. Change of Terms of Use</h2>\n<p class=\"text-15 text-dark-1 mt-5\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<br /><br />It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\n<h2 class=\"text-16 fw-500 mt-35\">3. Access and Use of the Services</h2>\n<p class=\"text-15 text-dark-1 mt-5\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<br /><br />It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>"},{"_active":true,"title":"Cookie Policy","desc":"<h2 class=\"text-16 fw-500\">1. Your Agreement</h2>\n<p class=\"text-15 text-dark-1 mt-5\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<br /><br />It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\n<h2 class=\"text-16 fw-500 mt-35\">2. Change of Terms of Use</h2>\n<p class=\"text-15 text-dark-1 mt-5\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<br /><br />It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\n<h2 class=\"text-16 fw-500 mt-35\">3. Access and Use of the Services</h2>\n<p class=\"text-15 text-dark-1 mt-5\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<br /><br />It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>"},{"_active":true,"title":"Best Price Guarantee","desc":"<h2 class=\"text-16 fw-500\">1. Your Agreement</h2>\n<p class=\"text-15 text-dark-1 mt-5\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<br /><br />It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\n<h2 class=\"text-16 fw-500 mt-35\">2. Change of Terms of Use</h2>\n<p class=\"text-15 text-dark-1 mt-5\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<br /><br />It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\n<h2 class=\"text-16 fw-500 mt-35\">3. Access and Use of the Services</h2>\n<p class=\"text-15 text-dark-1 mt-5\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<br /><br />It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>"}]},"component":"RegularBlock","open":true,"is_container":false}]',
            'create_user' => '1',
            'created_at'  => date("Y-m-d H:i:s")
        ]);

        DB::table('core_pages')->insert([
            'title' => 'Terms',
            'slug' => 'terms',
            'template_id' => $page_terms_id,
            'create_user' => '1',
            'status' => 'publish',
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('core_settings')->insert(
            [
                [
                    'name' => 'page_contact_why_choose_us_title',
                    'val' => "Why Choose Us",
                    'group' => "general",
                ],
                [
                    'name' => 'page_contact_why_choose_us_desc',
                    'val' => "These popular destinations have a lot to offer",
                    'group' => "general",
                ],
                [
                    'name' => 'page_contact_why_choose_us',
                    'val' => '[{"image_id":"'.$home1_image['img_4'].'","title":"Best Price Guarantee","desc":"Lorem ipsum dolor sit amet, consectetur adipiscing elit."},{"image_id":"'.$home1_image['img_5'].'","title":"Easy & Quick Booking","desc":"Lorem ipsum dolor sit amet, consectetur adipiscing elit."},{"image_id":"'.$home1_image['img_6'].'","title":"Customer Care 24\/7","desc":"Lorem ipsum dolor sit amet, consectetur adipiscing elit."}]',
                    'group' => "general",
                ],
            ]
        );

        $image_map = DB::table('media_files')->insertGetId(['file_name' => 'icon-map', 'file_path' => 'gotrip/general/icon-map.png', 'file_type' => 'image/png', 'file_extension' => 'png']);
        DB::table('core_settings')->insert([
            [
                'name' => "hotel_map_image",
                'val' => $image_map,
                'group' => "hotel",
            ],
            [
                'name' => "space_map_image",
                'val' => $image_map,
                'group' => "space",
            ],
            [
                'name' => "car_map_image",
                'val' => $image_map,
                'group' => "car",
            ],
        ]);

        //homepage6
        $home_event_images = [
            'img_1' => DB::table('media_files')->insertGetId(['file_name' => 'home-event-bg', 'file_path' => 'gotrip/general/home-event/bg.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_2' => DB::table('media_files')->insertGetId(['file_name' => 'feature-item-1', 'file_path' => 'gotrip/general/home-event/ft-1.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_3' => DB::table('media_files')->insertGetId(['file_name' => 'feature-item-2', 'file_path' => 'gotrip/general/home-event/ft-2.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_4' => DB::table('media_files')->insertGetId(['file_name' => 'feature-item-3', 'file_path' => 'gotrip/general/home-event/ft-3.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_5' => DB::table('media_files')->insertGetId(['file_name' => 'avatar-1', 'file_path' => 'gotrip/general/home-event/avatar-1.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_6' => DB::table('media_files')->insertGetId(['file_name' => 'avatar-2', 'file_path' => 'gotrip/general/home-event/avatar-2.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_7' => DB::table('media_files')->insertGetId(['file_name' => 'avatar-3', 'file_path' => 'gotrip/general/home-event/avatar-3.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_8' => DB::table('media_files')->insertGetId(['file_name' => 'avatar-4', 'file_path' => 'gotrip/general/home-event/avatar-4.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_9' => DB::table('media_files')->insertGetId(['file_name' => 'avatar-5', 'file_path' => 'gotrip/general/home-event/avatar-5.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_10' => DB::table('media_files')->insertGetId(['file_name' => 'download-app', 'file_path' => 'gotrip/general/home-event/2-1.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
        ];
        $home_event = [
            [
                "type" => "form_search_event",
                "name" => "Event: Form Search",
                "model" => [
                    "title" => "The World is Waiting For You",
                    "sub_title" => "Discover amzaing places at exclusive deals",
                    "style" => "",
                    "bg_image" => $home_event_images['img_1']
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "list_featured_item",
                "name" => "List Featured Item",
                "model" => [
                    "style" => "style5",
                    "title" => "",
                    "sub_title" => "",
                    "list_item" => [
                        [
                            "_active" => true,
                            "title" => "Best Price Guarantee",
                            "sub_title" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                            "icon_image" => $home1_image['img_4'],
                            "order" => 0
                        ],
                        [
                            "_active" => true,
                            "title" => "Easy & Quick Booking",
                            "sub_title" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                            "icon_image" => $home1_image['img_5'],
                            "order" => 2
                        ],
                        [
                            "_active" => true,
                            "title" => "Customer Care 24/7",
                            "sub_title" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                            "icon_image" => $home1_image['img_6'],
                            "order" => 3
                        ]
                    ],
                    "youtube_image" => "",
                    "youtube" => "",
                    "description" => "",
                    "link_title" => "",
                    "link_more" => ""
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "offer_block",
                "name" => "Offer Block",
                "model" => [
                    "list_item" => [
                        [
                            "_active" => true,
                            "title" => "Things To Do On <br> Your Trip",
                            "desc" => null,
                            "background_image" => $home_event_images['img_2'],
                            "link_title" => "Experiences",
                            "link_more" => "#",
                            "featured_text" => null,
                            "featured_icon" => null
                        ],
                        [
                            "_active" => true,
                            "title" => "Up To 70% Discount!",
                            "desc" => null,
                            "background_image" => $home_event_images['img_3'],
                            "link_title" => "Learn More",
                            "link_more" => "#",
                            "featured_text" => "Enjoy Summer Deals",
                            "featured_icon" => '<i class="icofont-beverage"></i>'
                        ],
                        [
                            "_active" => true,
                            "title" => "Let Your Vuriosity Do <br> Yhe Booking",
                            "desc" => null,
                            "background_image" => $home_event_images['img_4'],
                            "link_title" => "Learn More",
                            "link_more" => "#",
                            "featured_text" => null,
                            "featured_icon" => null
                        ]
                    ],
                    "style" => "style1",
                    "title" => "Special Offers",
                    "subtitle" => "These popular destinations have a lot to offer"
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "list_event",
                "name" => "Event: List Items",
                "model" => [
                    "title" => "Trending Activity",
                    "desc" => "Interdum et malesuada fames ac ante ipsum",
                    "number" => 4,
                    "style" => "normal",
                    "location_id" => "",
                    "order" => "id",
                    "order_by" => "desc",
                    "is_featured" => "",
                    "custom_ids" => ""
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                'type' => 'event_term_feature_box',
                'name' => 'Event: Term Feature Box',
                'model' => [
                    'title' => 'Adventure & Activity',
                    'desc' => 'Interdum et malesuada fames ac ante ipsum',
                    'term_event' => [83,84,85,86,87],
                    'component' => 'RegularBlock',
                    'open' => true
                ]
            ],
            [
                "type" => "list_locations",
                "name" => "List Locations",
                "model" => [
                    "layout" => "style_1",
                    "service_type" => [
                        "event"
                    ],
                    "title" => "Explore Hot Locations",
                    "desc" => "Interdum et malesuada fames ac ante ipsum",
                    "number" => 5,
                    "order" => "id",
                    "order_by" => "desc",
                    "custom_ids" => "",
                    "to_location_detail" => true,
                    "view_all_url" => ""
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "testimonial",
                "name" => "List Testimonial",
                "model" => [
                    "style" => "style_8",
                    "title" => "Testimonials",
                    "subtitle" => "Interdum et malesuada fames ac ante ipsum",
                    "happy_people_number" => "",
                    "happy_people_text" => "",
                    "overall_rating_number" => "",
                    "overall_rating_text" => "",
                    "overall_rating_star" => "",
                    "list_item" => [
                        [
                            "_active" => true,
                            "title" => null,
                            "name" => "Ali Tufan",
                            "job" => "Product Manager, Apple Inc",
                            "desc" => '"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic."',
                            "number_star" => null,
                            "avatar" => $home_event_images['img_5']
                        ],
                        [
                            "_active" => true,
                            "title" => null,
                            "name" => "Ali Tufan",
                            "job" => "Product Manager, Apple Inc",
                            "desc" => '"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic."',
                            "number_star" => null,
                            "avatar" => $home_event_images['img_6']
                        ],
                        [
                            "_active" => true,
                            "title" => null,
                            "name" => "Ali Tufan",
                            "job" => "Product Manager, Apple Inc",
                            "desc" => '"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic."',
                            "number_star" => null,
                            "avatar" => $home_event_images['img_7']
                        ],
                        [
                            "_active" => true,
                            "title" => null,
                            "name" => "Ali Tufan",
                            "job" => "Product Manager, Apple Inc",
                            "desc" => '"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic."',
                            "number_star" => null,
                            "avatar" => $home_event_images['img_8']
                        ],
                        [
                            "_active" => true,
                            "title" => null,
                            "name" => "Ali Tufan",
                            "job" => "Product Manager, Apple Inc",
                            "desc" => '"Our family was traveling via bullet train between cities in Japan with our luggage - the location for this hotel made that so easy. Agoda price was fantastic."',
                            "number_star" => null,
                            "avatar" => $home_event_images['img_9']
                        ],
                    ],
                    "title_trusted" => "",
                    "list_trusted" => [
                    ],
                    "testimonial_bg" => ""
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "list_event",
                "name" => "Event: List Items",
                "model" => [
                    "title" => "Recommended Activity",
                    "desc" => "Interdum et malesuada fames ac ante ipsum",
                    "number" => 5,
                    "style" => "normal",
                    "location_id" => "",
                    "order" => "id",
                    "order_by" => "desc",
                    "is_featured" => "",
                    "custom_ids" => ""
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "download_app",
                "name" => "Download App",
                "model" => [
                    "title" => "Download the App",
                    "sub_title" => "Book in advance or last-minute with GoTrip. Receive instant confirmation. Access your booking info offline.",
                    "bg_image" => $home_event_images['img_10'],
                    "style" => "style_3",
                    "list_item" => [
                        [
                            '_active' => true,
                            'title' => 'Apple Store',
                            'subtitle' => 'Download on the',
                            'icon' => 'icon-apple',
                            'link' => '#'
                        ],
                        [
                            '_active' => true,
                            'title' => 'Google Play',
                            'subtitle' => 'Get in on',
                            'icon' => 'icon-play-market',
                            'link' => '#'
                        ]
                    ]
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ],
            [
                "type" => "list_news",
                "name" => "News: List Items",
                "model" => [
                    "style" => "style_6",
                    "title" => "Get inspiration for your next trip",
                    "header_align" => "center",
                    "desc" => "Interdum et malesuada fames",
                    "number" => 2,
                    "category_id" => "",
                    "order" => "id",
                    "order_by" => "desc",
                    "link_title" => "",
                    "link_more" => ""
                ],
                "component" => "RegularBlock",
                "open" => true,
                "is_container" => false
            ]
        ];
        $home_event_id = DB::table('core_templates')->insertGetId([
            'title'       => 'Home Event',
            'content'     => json_encode($home_event),
            'create_user' => '1',
            'created_at'  => date("Y-m-d H:i:s")
        ]);

        DB::table('core_template_translations')->insert([
            'origin_id' => $home_event_id,
            'locale' => 'ja',
            'title' => 'Home Event',
            'content' => json_encode($home_event),
            'create_user' => '1',
            'created_at' => date("Y-m-d H:i:s")
        ]);


        DB::table('core_pages')->insert([
            'title' => 'Home Event',
            'slug' => 'home-event',
            'template_id' => $home_event_id,
            'header_style' => 'transparent_v7',
            'footer_style' => 'style_5',
            'disable_subscribe_default' => 1,
            'create_user' => '1',
            'status' => 'publish',
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        //reset
        setting_update_item('cookie_agreement_enable', 0);
        setting_update_item('news_page_list_banner', "");
        setting_update_item('page_contact_image', "");
        setting_update_item('page_contact_desc', "");
        setting_update_item('page_contact_sub_title', "");
        setting_update_item('hotel_page_search_banner', "");
        setting_update_item('space_page_search_banner', "");
        setting_update_item('tour_page_search_banner', "");
        setting_update_item('car_page_search_banner', "");
        setting_update_item('event_page_search_banner', "");
        setting_update_item('boat_page_search_banner', "");

        setting_update_item('hotel_map_search_fields', "");
        setting_update_item('space_map_search_fields', "");
        setting_update_item('tour_map_search_fields', "");
        setting_update_item('car_map_search_fields', "");
        setting_update_item('event_map_search_fields', "");
        setting_update_item('boat_map_search_fields', "");
    }

    public function generalMenu($locale = ''){
        return  array(
            array(
                'name'       => 'Home',
                'url'        => $locale.'/',
                'item_model' => 'custom',
                'model_name' => 'Custom',
                'children'   => array(
                    array(
                        'name'       => 'Home 1',
                        'url'        => $locale.'/',
                        'item_model' => 'custom',
                        'children'   => array(),
                    ),
                    array(
                        'name'       => 'Home 2',
                        'url'        => $locale.'/page/home-2',
                        'item_model' => 'custom',
                        'children'   => array(),
                    ),
                    array(
                        'name'       => 'Home 3',
                        'url'        => $locale.'/page/home-3',
                        'item_model' => 'custom',
                        'children'   => array(),
                    ),
                    array(
                        'name'       => 'Home Hotel',
                        'url'        => $locale.'/page/hotel',
                        'item_model' => 'custom',
                        'children'   => array(),
                    ),
                    array(
                        'name'       => 'Home Tour',
                        'url'        => $locale.'/page/home-tour',
                        'item_model' => 'custom',
                        'children'   => array(),
                    ),
                    array(
                        'name'       => 'Home Space',
                        'url'        => $locale.'/page/home-space',
                        'item_model' => 'custom',
                        'children'   => array(),
                    ),
                    array(
                        'name'       => 'Home Car',
                        'url'        => $locale.'/page/home-car',
                        'item_model' => 'custom',
                        'children'   => array(),
                    ),
                    array(
                        'name'       => 'Home Boat',
                        'url'        => $locale.'/page/home-boat',
                        'item_model' => 'custom',
                        'children'   => array(),
                    ),
                    array(
                        'name'       => 'Home Event',
                        'url'        => $locale.'/page/home-event',
                        'item_model' => 'custom',
                        'children'   => array(),
                    ),
                    array(
                        'name'       => 'Home Flight',
                        'url'        => $locale.'/page/home-flight',
                        'item_model' => 'custom',
                        'children'   => array(),
                    ),
                ),
            ),
            array(
                'name'       => 'Services',
                'url'        => '#',
                'item_model' => 'custom',
                'model_name' => 'Custom',
                'mega_menu'  => true,
                'mega_columns' => '4',
                'mega_image_url' => '/uploads/gotrip/general/mega-menu-bg.png',
                'children'   => array(
                    array(
                        'name'       => 'Hotel',
                        'url'        => $locale.'/hotel',
                        'item_model' => 'custom',
                        'model_name' => 'Custom',
                        'children'   => array(
                            array(
                                'name'       => 'Hotel List',
                                'url'        => $locale.'/hotel',
                                'item_model' => 'custom',
                                'model_name' => 'Custom',
                                'children'   => array(),
                            ),
                            array(
                                'name'       => 'Hotel Grid',
                                'url'        => $locale.'/hotel?_layout=grid',
                                'item_model' => 'custom',
                                'model_name' => 'Custom',
                                'children'   => array(),
                            ),
                            array(
                                'name'       => 'Hotel Map',
                                'url'        => $locale.'/hotel?_layout=map',
                                'item_model' => 'custom',
                                'model_name' => 'Custom',
                                'children'   => array(),
                            ),
                            array(
                                'name'       => 'Hotel Detail',
                                'url'        => $locale.'/hotel/parian-holiday-villas',
                                'item_model' => 'custom',
                                'model_name' => 'Custom',
                                'children'   => array(),
                            ),
                        ),
                    ),
                    array(
                        'name'       => 'Tour',
                        'url'        => $locale.'/tour',
                        'item_model' => 'custom',
                        'model_name' => 'Custom',
                        'children'   => array(
                            array(
                                'name'       => 'Tour List',
                                'url'        => $locale.'/tour',
                                'item_model' => 'custom',
                                'model_name' => 'Custom',
                                'children'   => array(),
                            ),
                            array(
                                'name'       => 'Tour Grid',
                                'url'        => $locale.'/tour?_layout=grid',
                                'item_model' => 'custom',
                                'model_name' => 'Custom',
                                'children'   => array(),
                            ),
                            array(
                                'name'       => 'Tour Map',
                                'url'        => $locale.'/tour?_layout=map',
                                'item_model' => 'custom',
                                'model_name' => 'Custom',
                                'children'   => array(),
                            ),
                            array(
                                'name'       => 'Tour Detail',
                                'url'        => $locale.'/tour/paris-vacation-travel',
                                'item_model' => 'custom',
                                'model_name' => 'Custom',
                                'children'   => array(),
                            ),
                        ),
                    ),
                    array(
                        'name'       => 'Space',
                        'url'        => $locale.'/space',
                        'item_model' => 'custom',
                        'model_name' => 'Custom',
                        'children'   => array(
                            array(
                                'name'       => 'Space List',
                                'url'        => $locale.'/space',
                                'item_model' => 'custom',
                                'model_name' => 'Custom',
                                'children'   => array(),
                            ),
                            array(
                                'name'       => 'Space Gird',
                                'url'        => $locale.'/space?_layout=grid',
                                'item_model' => 'custom',
                                'model_name' => 'Custom',
                                'children'   => array(),
                            ),
                            array(
                                'name'       => 'Space Map',
                                'url'        => $locale.'/space?_layout=map',
                                'item_model' => 'custom',
                                'model_name' => 'Custom',
                                'children'   => array(),
                            ),
                            array(
                                'name'       => 'Space Detail',
                                'url'        => $locale.'/space/stay-greenwich-village',
                                'item_model' => 'custom',
                                'model_name' => 'Custom',
                                'children'   => array(),
                            ),
                        ),
                    ),
                    array(
                        'name'       => 'Car',
                        'url'        => $locale.'/car',
                        'item_model' => 'custom',
                        'model_name' => 'Custom',
                        'children'   => array(
                            array(
                                'name'       => 'Car List',
                                'url'        => $locale.'/car',
                                'item_model' => 'custom',
                                'model_name' => 'Custom',
                                'children'   => array(),
                            ),
                            array(
                                'name'       => 'Car Grid',
                                'url'        => $locale.'/car?_layout=grid',
                                'item_model' => 'custom',
                                'model_name' => 'Custom',
                                'children'   => array(),
                            ),
                            array(
                                'name'       => 'Car Map',
                                'url'        => $locale.'/car?_layout=map',
                                'item_model' => 'custom',
                                'model_name' => 'Custom',
                                'children'   => array(),
                            ),
                            array(
                                'name'       => 'Car Detail',
                                'url'        => $locale.'/car/vinfast-lux-a20-plus',
                                'item_model' => 'custom',
                                'model_name' => 'Custom',
                                'children'   => array(),
                            ),
                        ),
                    ),
                    array(
                        'name'       => 'Event',
                        'url'        => $locale.'/event',
                        'item_model' => 'custom',
                        'model_name' => 'Custom',
                        'children'   => array(
                            array(
                                'name'       => 'Event List',
                                'url'        => $locale.'/event',
                                'item_model' => 'custom',
                                'model_name' => 'Custom',
                                'children'   => array(),
                            ),
                            array(
                                'name'       => 'Event Grid',
                                'url'        => $locale.'/event?_layout=grid',
                                'item_model' => 'custom',
                                'model_name' => 'Custom',
                                'children'   => array(),
                            ),
                            array(
                                'name'       => 'Event Map',
                                'url'        => $locale.'/event?_layout=map',
                                'item_model' => 'custom',
                                'model_name' => 'Custom',
                                'children'   => array(),
                            ),
                            array(
                                'name'       => 'Event Detail',
                                'url'        => $locale.'/event/aspen-glade-weddings-events',
                                'item_model' => 'custom',
                                'model_name' => 'Custom',
                                'children'   => array(),
                            ),
                        ),
                    ),
                    array(
                        'name'       => 'Boat',
                        'url'        => $locale.'/boat',
                        'item_model' => 'custom',
                        'model_name' => 'Custom',
                        'children'   => array(
                            array(
                                'name'       => 'Boat List',
                                'url'        => $locale.'/boat',
                                'item_model' => 'custom',
                                'model_name' => 'Custom',
                                'children'   => array(),
                            ),
                            array(
                                'name'       => 'Boat Grid',
                                'url'        => $locale.'/boat?_layout=grid',
                                'item_model' => 'custom',
                                'model_name' => 'Custom',
                                'children'   => array(),
                            ),
                            array(
                                'name'       => 'Boat Map',
                                'url'        => $locale.'/boat?_layout=map',
                                'item_model' => 'custom',
                                'model_name' => 'Custom',
                                'children'   => array(),
                            ),
                            array(
                                'name'       => 'Boat Detail',
                                'url'        => $locale.'/boat/blue-moon-yc-300',
                                'item_model' => 'custom',
                                'model_name' => 'Custom',
                                'children'   => array(),
                            ),
                        ),
                    ),
                    array(
                        'name'       => 'Flight',
                        'url'        => $locale.'/flight',
                        'item_model' => 'custom',
                        'model_name' => 'Custom',
                        'children'   => array(
                            array(
                                'name'       => 'Flight List',
                                'url'        => $locale.'/flight',
                                'item_model' => 'custom',
                                'model_name' => 'Custom'
                            )
                        )
                    )
                )
            ),
            array(
                'name'       => 'Destinations',
                'url'        => $locale.'/location/paris',
                'item_model' => 'custom',
                'children'   => array(),
            ),
            array(
                'name'       => 'Blog',
                'url'        => $locale.'/news',
                'item_model' => 'custom',
                'model_name' => 'Custom',
                'children'   => array(
                    array(
                        'name'       => 'Blog List',
                        'url'        => $locale.'/news',
                        'item_model' => 'custom',
                        'model_name' => 'Custom',
                        'children'   => array(),
                    ),
                    array(
                        'name'       => 'Blog Detail',
                        'url'        => $locale.'/news/morning-in-the-northern-sea',
                        'item_model' => 'custom',
                        'model_name' => 'Custom',
                        'children'   => array(),
                    ),
                ),
            ),
            array(
                'name'       => 'Pages',
                'url'        => '#',
                'item_model' => 'custom',
                'model_name' => 'Custom',
                'children'   => array(
                    array(
                        'name'       => 'Plan',
                        'url'        => $locale.'/plan',
                        'item_model' => 'custom',
                        'model_name' => 'Custom',
                        'children'   => array(),
                    ),
                    array(
                        'name'       => 'Become an expert',
                        'url'        => $locale.'/page/become-an-expert',
                        'item_model' => 'custom',
                        'children'   => array(),
                    ),
                    array(
                        'name'       => 'Terms',
                        'url'        => $locale.'/page/terms',
                        'item_model' => 'custom',
                        'model_name' => 'Custom',
                        'children'   => array(),
                    ),
                ),
            ),
            array(
                'name'       => 'Contact',
                'url'        => $locale.'/contact',
                'item_model' => 'custom',
                'model_name' => 'Custom',
                'children'   => array(),
            ),
        );
    }
}
