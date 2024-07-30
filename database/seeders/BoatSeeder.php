<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Media\Models\MediaFile;

use Modules\Review\Models\Review;
use Modules\Review\Models\ReviewMeta;


class BoatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('media_files')->insert([
            ['file_name' => 'banner-boat-single', 'file_path' => 'demo/boat/banner-single.jpg', 'file_type' => 'image/jpg', 'file_extension' => 'jpg'],
            ['file_name' => 'banner-search-boat', 'file_path' => 'demo/boat/banner-search-boat.jpg', 'file_type' => 'image/jpg', 'file_extension' => 'jpg'],
        ]);

        for ($i=1 ; $i <= 12 ; $i++){
            DB::table('media_files')->insert([
                ['file_name' => 'boat-'.$i, 'file_path' => 'demo/boat/boat-'.$i.'.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ]);
        }
        for ($i=1 ; $i <= 6 ; $i++){
            DB::table('media_files')->insert([
                ['file_name' => 'boat-gallery-'.$i, 'file_path' => 'demo/boat/gallery-'.$i.'.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ]);
        }

        $list_gallery = [];
        for($i=1 ; $i <=6 ; $i++){
            $list_gallery[] = MediaFile::findMediaByName("boat-gallery-".$i)->id;
        }

        $IDs_vendor[] = $create_user =   '1';
        $IDs[] = DB::table('bravo_boats')->insertGetId(
            [
                'title' => 'Cruising Yacht',
                'slug' => Str::slug('Cruising Yacht', '-'),
                'content' => "<p>Libero sem vitae sed donec conubia integer nisi integer rhoncus imperdiet orci odio libero est integer a integer tincidunt sollicitudin blandit fusce nibh leo vulputate lobortis egestas dapibus faucibus metus conubia maecenas cras potenti cum hac arcu rhoncus nullam eros dictum torquent integer cursus bibendum sem sociis molestie tellus purus</p><p>Quam fusce convallis ipsum malesuada amet velit aliquam urna nullam vehicula fermentum id morbi dis magnis porta sagittis euismod etiam</p><h4>HIGHLIGHTS</h4><ul><li>Visit the Museum of Modern Art in Manhattan</li><li>See amazing works of contemporary art, including Vincent van Gogh's The Starry Night</li><li>Check out Campbell's Soup Cans by Warhol and The Dance (I) by Matisse</li><li>Behold masterpieces by Gauguin, Dali, Picasso, and Pollock</li><li>Enjoy free audio guides available in English, French, German, Italian, Spanish, Portuguese</li></ul>",
                'image_id' => MediaFile::findMediaByName("boat-1")->id,
                'banner_image_id' => MediaFile::findMediaByName('banner-boat-single')->id,
                'location_id' => 1,
                'address' => "Arrondissement de Paris",
                'is_featured' => rand(0,1),
                'gallery' => implode(",",$list_gallery),
                'video' => "https://www.youtube.com/watch?v=UfEiKK-iX70",
                'number' => 1,
                'price_per_hour' => "100",
                'price_per_day' => "500",
                'min_price' => "100",
                'map_lat' => "21.054831",
                'map_lng' => "105.796077",
                'map_zoom' => "12",
                'faqs' => '[{"title":"When should I check the transmission fluid?","content":"You should check the transmission fluid regularly. Try to check it at least once a month or at the sign of any trouble, for instance if there is any hesitation when you shift gears in an automatic."},{"title":"How do I check the transmission fluid?","content":"It\u2019s not hard to check your transmission fluid if the vehicle is an automatic. This link to the Dummies guide to checking your transmission fluid has step-by-step instructions and illustrations that show you where to locate the dipstick. What you want is clear, pink transmission fluid. If it is low, top it up. If it is dark, smells burnt or has bits in it then you need to get it changed by at a reliable auto repair shop."},{"title":"Is it really that important to check the transmission fluid?","content":"Yes, it can be. Often times the symptoms you\u2019ll experience from low or dirty transmission fluid will be the same as transmission problems. If you check the fluid levels regularly and refill as necessary then you\u2019ll know if there are any symptoms of trouble that it\u2019s not because the fluid levels are low and you need to see a mechanic."},{"title":"Are there different types of transmission fluid?","content":"How do I know what to buy? Yes, there are many different types of transmission fluid, each designed for a certain transmission. Different vehicles require different transmission fluids and the age of the boat can also be a factor because newer transmissions take different types of transmission fluids than older vehicles. Don\u2019t guess! Find out which type of transmission fluid is required for your vehicle by checking your owner\u2019s manual."},{"title":"What is a transmission flush and should I get one?","content":"A transmission flush is used by some auto repair shops with the goal of flushing out debris.  Auto Tech does not do any sort of transmission flush.  Flushing an older transmission can cause harmful sediment to get stuck in the solenoids of the transmission. We heavily favor regular maintenance to lengthen the life of your transmission.  We service the transmission by changing fluid and the filter and do not recommend having your transmission flushed."},{"title":"How do I know I have a fluid leak from the transmission?","content":"Transmission fluid is slightly pink in color \u2013 it will appear pink or red, or possibly more brownish if the transmission fluid is dirty and needs to be replaced. When you feel transmission fluid it will be slick and oily on your fingers. It smells much like oil unless it is dirty, in which case it will smell burnt. Usually transmission fluid leaks around the front or middle of your vehicle, so if you find puddles of reddish liquid there it is probably transmission fluid. Another clue is if in addition to the leak your transmission is not working well and you notice changes in the way it sounds when you shift gears, or if shifting gears is not working as well. In this case you likely have a leak of transmission fluid that is impacting how your transmission operates."}]',
                'status' => "publish",
                'create_user' => $create_user,
                'author_id' => $create_user,
                'created_at' =>  date("Y-m-d H:i:s"),
                'max_guest'=>rand(5,15),
                'cabin'=>rand(1,5),
                'length'=>rand(10,20)."m",
                'speed'=>rand(25,35)."km/h",
                'specs'=>'{"0":{"title":"Manufacturer","content":"Sunrise"},"1":{"title":"Boat skipper","content":"Bareboat"},"2":{"title":"Model","content":"Summer Breeze"},"3":{"title":"Year","content":"2010"},"4":{"title":"Number of crew","content":"5"},"5":{"title":"Engines","content":"Diesel"},"6":{"title":"Fuel","content":"Composite"}}',
                'cancel_policy'=>"Full refund up to 4 days prior.",
                'terms_information'=>"<p>For Sanitary purposes ONLY, although there is a working toilet and shower, we've deactivated the shower and the toliet is for limited use (urine only..pardon the graphic detail!). This keeps the boat clean and odor-free for all of our guests.&nbsp; Sinks can be used.</p>
<p>Booking is weather pending. Because of the safety factors associated with the boat and inclement weather, If forecast shows rain, strong winds etc, the Host will communicate with Guest 24-48hrs in advance to mutually cancel/reschedule reservation. No smoking in boat cabin.</p>",
                'enable_extra_price' => '1',
                'extra_price' => '[{"name":"Child Toddler Seat","price":"100","type":"one_time"},{"name":"Infant Child Seat","price":"100","type":"one_time"},{"name":"GPS Satellite","price":"200","type":"one_time"}]',
            ]);
        $IDs_vendor[] = $create_user =   '1';
        $IDs[] = DB::table('bravo_boats')->insertGetId(
            [
                'title' => 'Summer Breeze',
                'slug' => Str::slug('Summer Breeze', '-'),
                'content' => "<p>Libero sem vitae sed donec conubia integer nisi integer rhoncus imperdiet orci odio libero est integer a integer tincidunt sollicitudin blandit fusce nibh leo vulputate lobortis egestas dapibus faucibus metus conubia maecenas cras potenti cum hac arcu rhoncus nullam eros dictum torquent integer cursus bibendum sem sociis molestie tellus purus</p><p>Quam fusce convallis ipsum malesuada amet velit aliquam urna nullam vehicula fermentum id morbi dis magnis porta sagittis euismod etiam</p><h4>HIGHLIGHTS</h4><ul><li>Visit the Museum of Modern Art in Manhattan</li><li>See amazing works of contemporary art, including Vincent van Gogh's The Starry Night</li><li>Check out Campbell's Soup Cans by Warhol and The Dance (I) by Matisse</li><li>Behold masterpieces by Gauguin, Dali, Picasso, and Pollock</li><li>Enjoy free audio guides available in English, French, German, Italian, Spanish, Portuguese</li></ul>",
                'image_id' => MediaFile::findMediaByName("boat-2")->id,
                'banner_image_id' => MediaFile::findMediaByName('banner-boat-single')->id,
                'location_id' => 1,
                'address' => "Arrondissement de Paris",
                'is_featured' => rand(0,1),
                'gallery' => implode(",",$list_gallery),
                'video' => "https://www.youtube.com/watch?v=UfEiKK-iX70",
                'number' => 1,
                'price_per_hour' => "150",
                'price_per_day' => "500",
                'min_price' => "150",
                'map_lat' => "21.039771",
                'map_lng' => "105.777203",
                'map_zoom' => "12",
                'faqs' => '[{"title":"When should I check the transmission fluid?","content":"You should check the transmission fluid regularly. Try to check it at least once a month or at the sign of any trouble, for instance if there is any hesitation when you shift gears in an automatic."},{"title":"How do I check the transmission fluid?","content":"It\u2019s not hard to check your transmission fluid if the vehicle is an automatic. This link to the Dummies guide to checking your transmission fluid has step-by-step instructions and illustrations that show you where to locate the dipstick. What you want is clear, pink transmission fluid. If it is low, top it up. If it is dark, smells burnt or has bits in it then you need to get it changed by at a reliable auto repair shop."},{"title":"Is it really that important to check the transmission fluid?","content":"Yes, it can be. Often times the symptoms you\u2019ll experience from low or dirty transmission fluid will be the same as transmission problems. If you check the fluid levels regularly and refill as necessary then you\u2019ll know if there are any symptoms of trouble that it\u2019s not because the fluid levels are low and you need to see a mechanic."},{"title":"Are there different types of transmission fluid?","content":"How do I know what to buy? Yes, there are many different types of transmission fluid, each designed for a certain transmission. Different vehicles require different transmission fluids and the age of the boat can also be a factor because newer transmissions take different types of transmission fluids than older vehicles. Don\u2019t guess! Find out which type of transmission fluid is required for your vehicle by checking your owner\u2019s manual."},{"title":"What is a transmission flush and should I get one?","content":"A transmission flush is used by some auto repair shops with the goal of flushing out debris.  Auto Tech does not do any sort of transmission flush.  Flushing an older transmission can cause harmful sediment to get stuck in the solenoids of the transmission. We heavily favor regular maintenance to lengthen the life of your transmission.  We service the transmission by changing fluid and the filter and do not recommend having your transmission flushed."},{"title":"How do I know I have a fluid leak from the transmission?","content":"Transmission fluid is slightly pink in color \u2013 it will appear pink or red, or possibly more brownish if the transmission fluid is dirty and needs to be replaced. When you feel transmission fluid it will be slick and oily on your fingers. It smells much like oil unless it is dirty, in which case it will smell burnt. Usually transmission fluid leaks around the front or middle of your vehicle, so if you find puddles of reddish liquid there it is probably transmission fluid. Another clue is if in addition to the leak your transmission is not working well and you notice changes in the way it sounds when you shift gears, or if shifting gears is not working as well. In this case you likely have a leak of transmission fluid that is impacting how your transmission operates."}]',
                'status' => "publish",
                'create_user' => $create_user,
                'author_id' => $create_user,
                'created_at' =>  date("Y-m-d H:i:s"),
                'max_guest'=>rand(5,15),
                'cabin'=>rand(1,5),
                'length'=>rand(10,20)."m",
                'speed'=>rand(25,35)."km/h",
                'specs'=>'{"0":{"title":"Manufacturer","content":"Sunrise"},"1":{"title":"Boat skipper","content":"Bareboat"},"2":{"title":"Model","content":"Summer Breeze"},"3":{"title":"Year","content":"2010"},"4":{"title":"Number of crew","content":"5"},"5":{"title":"Engines","content":"Diesel"},"6":{"title":"Fuel","content":"Composite"}}',
                'cancel_policy'=>"Full refund up to 4 days prior.",
                'terms_information'=>"<p>For Sanitary purposes ONLY, although there is a working toilet and shower, we've deactivated the shower and the toliet is for limited use (urine only..pardon the graphic detail!). This keeps the boat clean and odor-free for all of our guests.&nbsp; Sinks can be used.</p>
<p>Booking is weather pending. Because of the safety factors associated with the boat and inclement weather, If forecast shows rain, strong winds etc, the Host will communicate with Guest 24-48hrs in advance to mutually cancel/reschedule reservation. No smoking in boat cabin.</p>",
                'enable_extra_price' => '1',
                'extra_price' => '[{"name":"Child Toddler Seat","price":"100","type":"one_time"},{"name":"Infant Child Seat","price":"100","type":"one_time"},{"name":"GPS Satellite","price":"200","type":"one_time"}]',
            ]);
        $IDs_vendor[] = $create_user =   '1';
        $IDs[] = DB::table('bravo_boats')->insertGetId(
            [
                'title' => 'Blue Moon Cruising',
                'slug' => Str::slug('Blue Moon Cruising', '-'),
                'content' => "<p>Libero sem vitae sed donec conubia integer nisi integer rhoncus imperdiet orci odio libero est integer a integer tincidunt sollicitudin blandit fusce nibh leo vulputate lobortis egestas dapibus faucibus metus conubia maecenas cras potenti cum hac arcu rhoncus nullam eros dictum torquent integer cursus bibendum sem sociis molestie tellus purus</p><p>Quam fusce convallis ipsum malesuada amet velit aliquam urna nullam vehicula fermentum id morbi dis magnis porta sagittis euismod etiam</p><h4>HIGHLIGHTS</h4><ul><li>Visit the Museum of Modern Art in Manhattan</li><li>See amazing works of contemporary art, including Vincent van Gogh's The Starry Night</li><li>Check out Campbell's Soup Cans by Warhol and The Dance (I) by Matisse</li><li>Behold masterpieces by Gauguin, Dali, Picasso, and Pollock</li><li>Enjoy free audio guides available in English, French, German, Italian, Spanish, Portuguese</li></ul>",
                'image_id' => MediaFile::findMediaByName("boat-2")->id,
                'banner_image_id' => MediaFile::findMediaByName('banner-boat-single')->id,
                'location_id' => 3,
                'address' => "Arrondissement de Paris",
                'is_featured' => rand(0,1),
                'gallery' => implode(",",$list_gallery),
                'video' => "https://www.youtube.com/watch?v=UfEiKK-iX70",
                'number' => 1,
                'price_per_hour' => "200",
                'price_per_day' => "800",
                'min_price' => "200",
                'map_lat' => "21.031217",
                'map_lng' => "105.773698",
                'map_zoom' => "12",
                'faqs' => '[{"title":"When should I check the transmission fluid?","content":"You should check the transmission fluid regularly. Try to check it at least once a month or at the sign of any trouble, for instance if there is any hesitation when you shift gears in an automatic."},{"title":"How do I check the transmission fluid?","content":"It\u2019s not hard to check your transmission fluid if the vehicle is an automatic. This link to the Dummies guide to checking your transmission fluid has step-by-step instructions and illustrations that show you where to locate the dipstick. What you want is clear, pink transmission fluid. If it is low, top it up. If it is dark, smells burnt or has bits in it then you need to get it changed by at a reliable auto repair shop."},{"title":"Is it really that important to check the transmission fluid?","content":"Yes, it can be. Often times the symptoms you\u2019ll experience from low or dirty transmission fluid will be the same as transmission problems. If you check the fluid levels regularly and refill as necessary then you\u2019ll know if there are any symptoms of trouble that it\u2019s not because the fluid levels are low and you need to see a mechanic."},{"title":"Are there different types of transmission fluid?","content":"How do I know what to buy? Yes, there are many different types of transmission fluid, each designed for a certain transmission. Different vehicles require different transmission fluids and the age of the boat can also be a factor because newer transmissions take different types of transmission fluids than older vehicles. Don\u2019t guess! Find out which type of transmission fluid is required for your vehicle by checking your owner\u2019s manual."},{"title":"What is a transmission flush and should I get one?","content":"A transmission flush is used by some auto repair shops with the goal of flushing out debris.  Auto Tech does not do any sort of transmission flush.  Flushing an older transmission can cause harmful sediment to get stuck in the solenoids of the transmission. We heavily favor regular maintenance to lengthen the life of your transmission.  We service the transmission by changing fluid and the filter and do not recommend having your transmission flushed."},{"title":"How do I know I have a fluid leak from the transmission?","content":"Transmission fluid is slightly pink in color \u2013 it will appear pink or red, or possibly more brownish if the transmission fluid is dirty and needs to be replaced. When you feel transmission fluid it will be slick and oily on your fingers. It smells much like oil unless it is dirty, in which case it will smell burnt. Usually transmission fluid leaks around the front or middle of your vehicle, so if you find puddles of reddish liquid there it is probably transmission fluid. Another clue is if in addition to the leak your transmission is not working well and you notice changes in the way it sounds when you shift gears, or if shifting gears is not working as well. In this case you likely have a leak of transmission fluid that is impacting how your transmission operates."}]',
                'status' => "publish",
                'create_user' => $create_user,
                'author_id' => $create_user,
                'created_at' =>  date("Y-m-d H:i:s"),
                'max_guest'=>rand(5,15),
                'cabin'=>rand(1,5),
                'length'=>rand(10,20)."m",
                'speed'=>rand(25,35)."km/h",
                'specs'=>'{"0":{"title":"Manufacturer","content":"Sunrise"},"1":{"title":"Boat skipper","content":"Bareboat"},"2":{"title":"Model","content":"Summer Breeze"},"3":{"title":"Year","content":"2010"},"4":{"title":"Number of crew","content":"5"},"5":{"title":"Engines","content":"Diesel"},"6":{"title":"Fuel","content":"Composite"}}',
                'cancel_policy'=>"Full refund up to 4 days prior.",
                'terms_information'=>"<p>For Sanitary purposes ONLY, although there is a working toilet and shower, we've deactivated the shower and the toliet is for limited use (urine only..pardon the graphic detail!). This keeps the boat clean and odor-free for all of our guests.&nbsp; Sinks can be used.</p>
<p>Booking is weather pending. Because of the safety factors associated with the boat and inclement weather, If forecast shows rain, strong winds etc, the Host will communicate with Guest 24-48hrs in advance to mutually cancel/reschedule reservation. No smoking in boat cabin.</p>",
                'enable_extra_price' => '1',
                'extra_price' => '[{"name":"Child Toddler Seat","price":"100","type":"one_time"},{"name":"Infant Child Seat","price":"100","type":"one_time"},{"name":"GPS Satellite","price":"200","type":"one_time"}]',
            ]);
        $IDs_vendor[] = $create_user =   '1';
        $IDs[] = DB::table('bravo_boats')->insertGetId(
            [
                'title' => 'BOAT 1992 ALISON',
                'slug' => Str::slug('BOAT 1992 ALISON', '-'),
                'content' => "<p>Libero sem vitae sed donec conubia integer nisi integer rhoncus imperdiet orci odio libero est integer a integer tincidunt sollicitudin blandit fusce nibh leo vulputate lobortis egestas dapibus faucibus metus conubia maecenas cras potenti cum hac arcu rhoncus nullam eros dictum torquent integer cursus bibendum sem sociis molestie tellus purus</p><p>Quam fusce convallis ipsum malesuada amet velit aliquam urna nullam vehicula fermentum id morbi dis magnis porta sagittis euismod etiam</p><h4>HIGHLIGHTS</h4><ul><li>Visit the Museum of Modern Art in Manhattan</li><li>See amazing works of contemporary art, including Vincent van Gogh's The Starry Night</li><li>Check out Campbell's Soup Cans by Warhol and The Dance (I) by Matisse</li><li>Behold masterpieces by Gauguin, Dali, Picasso, and Pollock</li><li>Enjoy free audio guides available in English, French, German, Italian, Spanish, Portuguese</li></ul>",
                'image_id' => MediaFile::findMediaByName("boat-3")->id,
                'banner_image_id' => MediaFile::findMediaByName('banner-boat-single')->id,
                'location_id' => 1,
                'address' => "Arrondissement de Paris",
                'is_featured' => rand(0,1),
                'gallery' => implode(",",$list_gallery),
                'video' => "https://www.youtube.com/watch?v=UfEiKK-iX70",
                'number' => 1,
                'price_per_hour' => "50",
                'price_per_day' => "300",
                'min_price' => "50",
                'map_lat' => "21.020161",
                'map_lng' => "105.789655",
                'map_zoom' => "12",
                'faqs' => '[{"title":"When should I check the transmission fluid?","content":"You should check the transmission fluid regularly. Try to check it at least once a month or at the sign of any trouble, for instance if there is any hesitation when you shift gears in an automatic."},{"title":"How do I check the transmission fluid?","content":"It\u2019s not hard to check your transmission fluid if the vehicle is an automatic. This link to the Dummies guide to checking your transmission fluid has step-by-step instructions and illustrations that show you where to locate the dipstick. What you want is clear, pink transmission fluid. If it is low, top it up. If it is dark, smells burnt or has bits in it then you need to get it changed by at a reliable auto repair shop."},{"title":"Is it really that important to check the transmission fluid?","content":"Yes, it can be. Often times the symptoms you\u2019ll experience from low or dirty transmission fluid will be the same as transmission problems. If you check the fluid levels regularly and refill as necessary then you\u2019ll know if there are any symptoms of trouble that it\u2019s not because the fluid levels are low and you need to see a mechanic."},{"title":"Are there different types of transmission fluid?","content":"How do I know what to buy? Yes, there are many different types of transmission fluid, each designed for a certain transmission. Different vehicles require different transmission fluids and the age of the boat can also be a factor because newer transmissions take different types of transmission fluids than older vehicles. Don\u2019t guess! Find out which type of transmission fluid is required for your vehicle by checking your owner\u2019s manual."},{"title":"What is a transmission flush and should I get one?","content":"A transmission flush is used by some auto repair shops with the goal of flushing out debris.  Auto Tech does not do any sort of transmission flush.  Flushing an older transmission can cause harmful sediment to get stuck in the solenoids of the transmission. We heavily favor regular maintenance to lengthen the life of your transmission.  We service the transmission by changing fluid and the filter and do not recommend having your transmission flushed."},{"title":"How do I know I have a fluid leak from the transmission?","content":"Transmission fluid is slightly pink in color \u2013 it will appear pink or red, or possibly more brownish if the transmission fluid is dirty and needs to be replaced. When you feel transmission fluid it will be slick and oily on your fingers. It smells much like oil unless it is dirty, in which case it will smell burnt. Usually transmission fluid leaks around the front or middle of your vehicle, so if you find puddles of reddish liquid there it is probably transmission fluid. Another clue is if in addition to the leak your transmission is not working well and you notice changes in the way it sounds when you shift gears, or if shifting gears is not working as well. In this case you likely have a leak of transmission fluid that is impacting how your transmission operates."}]',
                'status' => "publish",
                'create_user' => $create_user,
                'author_id' => $create_user,
                'created_at' =>  date("Y-m-d H:i:s"),
                'max_guest'=>rand(5,15),
                'cabin'=>rand(1,5),
                'length'=>rand(10,20)."m",
                'speed'=>rand(25,35)."km/h",
                'specs'=>'{"0":{"title":"Manufacturer","content":"Sunrise"},"1":{"title":"Boat skipper","content":"Bareboat"},"2":{"title":"Model","content":"Summer Breeze"},"3":{"title":"Year","content":"2010"},"4":{"title":"Number of crew","content":"5"},"5":{"title":"Engines","content":"Diesel"},"6":{"title":"Fuel","content":"Composite"}}',
                'cancel_policy'=>"Full refund up to 4 days prior.",
                'terms_information'=>"<p>For Sanitary purposes ONLY, although there is a working toilet and shower, we've deactivated the shower and the toliet is for limited use (urine only..pardon the graphic detail!). This keeps the boat clean and odor-free for all of our guests.&nbsp; Sinks can be used.</p>
<p>Booking is weather pending. Because of the safety factors associated with the boat and inclement weather, If forecast shows rain, strong winds etc, the Host will communicate with Guest 24-48hrs in advance to mutually cancel/reschedule reservation. No smoking in boat cabin.</p>",
                'enable_extra_price' => '1',
                'extra_price' => '[{"name":"Child Toddler Seat","price":"100","type":"one_time"},{"name":"Infant Child Seat","price":"100","type":"one_time"},{"name":"GPS Satellite","price":"200","type":"one_time"}]',
            ]);
        $IDs_vendor[] = $create_user =   '1';
        $IDs[] = DB::table('bravo_boats')->insertGetId(
            [
                'title' => 'Andiamo MX-3',
                'slug' => Str::slug('Andiamo MX-3', '-'),
                'content' => "<p>Libero sem vitae sed donec conubia integer nisi integer rhoncus imperdiet orci odio libero est integer a integer tincidunt sollicitudin blandit fusce nibh leo vulputate lobortis egestas dapibus faucibus metus conubia maecenas cras potenti cum hac arcu rhoncus nullam eros dictum torquent integer cursus bibendum sem sociis molestie tellus purus</p><p>Quam fusce convallis ipsum malesuada amet velit aliquam urna nullam vehicula fermentum id morbi dis magnis porta sagittis euismod etiam</p><h4>HIGHLIGHTS</h4><ul><li>Visit the Museum of Modern Art in Manhattan</li><li>See amazing works of contemporary art, including Vincent van Gogh's The Starry Night</li><li>Check out Campbell's Soup Cans by Warhol and The Dance (I) by Matisse</li><li>Behold masterpieces by Gauguin, Dali, Picasso, and Pollock</li><li>Enjoy free audio guides available in English, French, German, Italian, Spanish, Portuguese</li></ul>",
                'image_id' => MediaFile::findMediaByName("boat-4")->id,
                'banner_image_id' => MediaFile::findMediaByName('banner-boat-single')->id,
                'location_id' => 5,
                'address' => "Arrondissement de Paris",
                'is_featured' => rand(0,1),
                'gallery' => implode(",",$list_gallery),
                'video' => "https://www.youtube.com/watch?v=UfEiKK-iX70",
                'number' => 1,
                'price_per_hour' => "250",
                'price_per_day' => "650",
                'min_price' => "250",
                'map_lat' => "21.014873",
                'map_lng' => "105.794117",
                'map_zoom' => "12",
                'faqs' => '[{"title":"When should I check the transmission fluid?","content":"You should check the transmission fluid regularly. Try to check it at least once a month or at the sign of any trouble, for instance if there is any hesitation when you shift gears in an automatic."},{"title":"How do I check the transmission fluid?","content":"It\u2019s not hard to check your transmission fluid if the vehicle is an automatic. This link to the Dummies guide to checking your transmission fluid has step-by-step instructions and illustrations that show you where to locate the dipstick. What you want is clear, pink transmission fluid. If it is low, top it up. If it is dark, smells burnt or has bits in it then you need to get it changed by at a reliable auto repair shop."},{"title":"Is it really that important to check the transmission fluid?","content":"Yes, it can be. Often times the symptoms you\u2019ll experience from low or dirty transmission fluid will be the same as transmission problems. If you check the fluid levels regularly and refill as necessary then you\u2019ll know if there are any symptoms of trouble that it\u2019s not because the fluid levels are low and you need to see a mechanic."},{"title":"Are there different types of transmission fluid?","content":"How do I know what to buy? Yes, there are many different types of transmission fluid, each designed for a certain transmission. Different vehicles require different transmission fluids and the age of the boat can also be a factor because newer transmissions take different types of transmission fluids than older vehicles. Don\u2019t guess! Find out which type of transmission fluid is required for your vehicle by checking your owner\u2019s manual."},{"title":"What is a transmission flush and should I get one?","content":"A transmission flush is used by some auto repair shops with the goal of flushing out debris.  Auto Tech does not do any sort of transmission flush.  Flushing an older transmission can cause harmful sediment to get stuck in the solenoids of the transmission. We heavily favor regular maintenance to lengthen the life of your transmission.  We service the transmission by changing fluid and the filter and do not recommend having your transmission flushed."},{"title":"How do I know I have a fluid leak from the transmission?","content":"Transmission fluid is slightly pink in color \u2013 it will appear pink or red, or possibly more brownish if the transmission fluid is dirty and needs to be replaced. When you feel transmission fluid it will be slick and oily on your fingers. It smells much like oil unless it is dirty, in which case it will smell burnt. Usually transmission fluid leaks around the front or middle of your vehicle, so if you find puddles of reddish liquid there it is probably transmission fluid. Another clue is if in addition to the leak your transmission is not working well and you notice changes in the way it sounds when you shift gears, or if shifting gears is not working as well. In this case you likely have a leak of transmission fluid that is impacting how your transmission operates."}]',
                'status' => "publish",
                'create_user' => $create_user,
                'author_id' => $create_user,
                'created_at' =>  date("Y-m-d H:i:s"),
                'max_guest'=>rand(5,15),
                'cabin'=>rand(1,5),
                'length'=>rand(10,20)."m",
                'speed'=>rand(25,35)."km/h",
                'specs'=>'{"0":{"title":"Manufacturer","content":"Sunrise"},"1":{"title":"Boat skipper","content":"Bareboat"},"2":{"title":"Model","content":"Summer Breeze"},"3":{"title":"Year","content":"2010"},"4":{"title":"Number of crew","content":"5"},"5":{"title":"Engines","content":"Diesel"},"6":{"title":"Fuel","content":"Composite"}}',
                'cancel_policy'=>"Full refund up to 4 days prior.",
                'terms_information'=>"<p>For Sanitary purposes ONLY, although there is a working toilet and shower, we've deactivated the shower and the toliet is for limited use (urine only..pardon the graphic detail!). This keeps the boat clean and odor-free for all of our guests.&nbsp; Sinks can be used.</p>
<p>Booking is weather pending. Because of the safety factors associated with the boat and inclement weather, If forecast shows rain, strong winds etc, the Host will communicate with Guest 24-48hrs in advance to mutually cancel/reschedule reservation. No smoking in boat cabin.</p>",
                'enable_extra_price' => '1',
                'extra_price' => '[{"name":"Child Toddler Seat","price":"100","type":"one_time"},{"name":"Infant Child Seat","price":"100","type":"one_time"},{"name":"GPS Satellite","price":"200","type":"one_time"}]',
            ]);
        $IDs_vendor[] = $create_user =   rand(4,6);
        $IDs[] = DB::table('bravo_boats')->insertGetId(
            [
                'title' => 'Blue Dream TC-20',
                'slug' => Str::slug('Blue Dream TC-20', '-'),
                'content' => "<p>Libero sem vitae sed donec conubia integer nisi integer rhoncus imperdiet orci odio libero est integer a integer tincidunt sollicitudin blandit fusce nibh leo vulputate lobortis egestas dapibus faucibus metus conubia maecenas cras potenti cum hac arcu rhoncus nullam eros dictum torquent integer cursus bibendum sem sociis molestie tellus purus</p><p>Quam fusce convallis ipsum malesuada amet velit aliquam urna nullam vehicula fermentum id morbi dis magnis porta sagittis euismod etiam</p><h4>HIGHLIGHTS</h4><ul><li>Visit the Museum of Modern Art in Manhattan</li><li>See amazing works of contemporary art, including Vincent van Gogh's The Starry Night</li><li>Check out Campbell's Soup Cans by Warhol and The Dance (I) by Matisse</li><li>Behold masterpieces by Gauguin, Dali, Picasso, and Pollock</li><li>Enjoy free audio guides available in English, French, German, Italian, Spanish, Portuguese</li></ul>",
                'image_id' => MediaFile::findMediaByName("boat-5")->id,
                'banner_image_id' => MediaFile::findMediaByName('banner-boat-single')->id,
                'location_id' => 1,
                'address' => "Arrondissement de Paris",
                'is_featured' => rand(0,1),
                'gallery' => implode(",",$list_gallery),
                'video' => "https://www.youtube.com/watch?v=UfEiKK-iX70",
                'number' => 1,
                'price_per_hour' => "130",
                'price_per_day' => "670",
                'min_price' => "130",
                'map_lat' => "21.018398",
                'map_lng' => "105.812820",
                'map_zoom' => "12",
                'faqs' => '[{"title":"When should I check the transmission fluid?","content":"You should check the transmission fluid regularly. Try to check it at least once a month or at the sign of any trouble, for instance if there is any hesitation when you shift gears in an automatic."},{"title":"How do I check the transmission fluid?","content":"It\u2019s not hard to check your transmission fluid if the vehicle is an automatic. This link to the Dummies guide to checking your transmission fluid has step-by-step instructions and illustrations that show you where to locate the dipstick. What you want is clear, pink transmission fluid. If it is low, top it up. If it is dark, smells burnt or has bits in it then you need to get it changed by at a reliable auto repair shop."},{"title":"Is it really that important to check the transmission fluid?","content":"Yes, it can be. Often times the symptoms you\u2019ll experience from low or dirty transmission fluid will be the same as transmission problems. If you check the fluid levels regularly and refill as necessary then you\u2019ll know if there are any symptoms of trouble that it\u2019s not because the fluid levels are low and you need to see a mechanic."},{"title":"Are there different types of transmission fluid?","content":"How do I know what to buy? Yes, there are many different types of transmission fluid, each designed for a certain transmission. Different vehicles require different transmission fluids and the age of the boat can also be a factor because newer transmissions take different types of transmission fluids than older vehicles. Don\u2019t guess! Find out which type of transmission fluid is required for your vehicle by checking your owner\u2019s manual."},{"title":"What is a transmission flush and should I get one?","content":"A transmission flush is used by some auto repair shops with the goal of flushing out debris.  Auto Tech does not do any sort of transmission flush.  Flushing an older transmission can cause harmful sediment to get stuck in the solenoids of the transmission. We heavily favor regular maintenance to lengthen the life of your transmission.  We service the transmission by changing fluid and the filter and do not recommend having your transmission flushed."},{"title":"How do I know I have a fluid leak from the transmission?","content":"Transmission fluid is slightly pink in color \u2013 it will appear pink or red, or possibly more brownish if the transmission fluid is dirty and needs to be replaced. When you feel transmission fluid it will be slick and oily on your fingers. It smells much like oil unless it is dirty, in which case it will smell burnt. Usually transmission fluid leaks around the front or middle of your vehicle, so if you find puddles of reddish liquid there it is probably transmission fluid. Another clue is if in addition to the leak your transmission is not working well and you notice changes in the way it sounds when you shift gears, or if shifting gears is not working as well. In this case you likely have a leak of transmission fluid that is impacting how your transmission operates."}]',
                'status' => "publish",
                'create_user' => $create_user,
                'author_id' => $create_user,
                'created_at' =>  date("Y-m-d H:i:s"),
                'max_guest'=>rand(5,15),
                'cabin'=>rand(1,5),
                'length'=>rand(10,20)."m",
                'speed'=>rand(25,35)."km/h",
                'specs'=>'{"0":{"title":"Manufacturer","content":"Sunrise"},"1":{"title":"Boat skipper","content":"Bareboat"},"2":{"title":"Model","content":"Summer Breeze"},"3":{"title":"Year","content":"2010"},"4":{"title":"Number of crew","content":"5"},"5":{"title":"Engines","content":"Diesel"},"6":{"title":"Fuel","content":"Composite"}}',
                'cancel_policy'=>"Full refund up to 4 days prior.",
                'terms_information'=>"<p>For Sanitary purposes ONLY, although there is a working toilet and shower, we've deactivated the shower and the toliet is for limited use (urine only..pardon the graphic detail!). This keeps the boat clean and odor-free for all of our guests.&nbsp; Sinks can be used.</p>
<p>Booking is weather pending. Because of the safety factors associated with the boat and inclement weather, If forecast shows rain, strong winds etc, the Host will communicate with Guest 24-48hrs in advance to mutually cancel/reschedule reservation. No smoking in boat cabin.</p>",
                'enable_extra_price' => '1',
                'extra_price' => '[{"name":"Child Toddler Seat","price":"100","type":"one_time"},{"name":"Infant Child Seat","price":"100","type":"one_time"},{"name":"GPS Satellite","price":"200","type":"one_time"}]',
            ]);
        $IDs_vendor[] = $create_user =   rand(4,6);
        $IDs[] = DB::table('bravo_boats')->insertGetId(
            [
                'title' => 'Blue Moon YC-300',
                'slug' => Str::slug('Blue Moon YC-300', '-'),
                'content' => "<p>Libero sem vitae sed donec conubia integer nisi integer rhoncus imperdiet orci odio libero est integer a integer tincidunt sollicitudin blandit fusce nibh leo vulputate lobortis egestas dapibus faucibus metus conubia maecenas cras potenti cum hac arcu rhoncus nullam eros dictum torquent integer cursus bibendum sem sociis molestie tellus purus</p><p>Quam fusce convallis ipsum malesuada amet velit aliquam urna nullam vehicula fermentum id morbi dis magnis porta sagittis euismod etiam</p><h4>HIGHLIGHTS</h4><ul><li>Visit the Museum of Modern Art in Manhattan</li><li>See amazing works of contemporary art, including Vincent van Gogh's The Starry Night</li><li>Check out Campbell's Soup Cans by Warhol and The Dance (I) by Matisse</li><li>Behold masterpieces by Gauguin, Dali, Picasso, and Pollock</li><li>Enjoy free audio guides available in English, French, German, Italian, Spanish, Portuguese</li></ul>",
                'image_id' => MediaFile::findMediaByName("boat-6")->id,
                'banner_image_id' => MediaFile::findMediaByName('banner-boat-single')->id,
                'location_id' => 1,
                'address' => "Arrondissement de Paris",
                'is_featured' => rand(0,1),
                'gallery' => implode(",",$list_gallery),
                'video' => "https://www.youtube.com/watch?v=UfEiKK-iX70",
                'number' => 1,
                'price_per_hour' => "130",
                'price_per_day' => "800",
                'min_price' => "130",
                'map_lat' => "21.025769",
                'map_lng' => "105.829635",
                'map_zoom' => "12",
                'faqs' => '[{"title":"When should I check the transmission fluid?","content":"You should check the transmission fluid regularly. Try to check it at least once a month or at the sign of any trouble, for instance if there is any hesitation when you shift gears in an automatic."},{"title":"How do I check the transmission fluid?","content":"It\u2019s not hard to check your transmission fluid if the vehicle is an automatic. This link to the Dummies guide to checking your transmission fluid has step-by-step instructions and illustrations that show you where to locate the dipstick. What you want is clear, pink transmission fluid. If it is low, top it up. If it is dark, smells burnt or has bits in it then you need to get it changed by at a reliable auto repair shop."},{"title":"Is it really that important to check the transmission fluid?","content":"Yes, it can be. Often times the symptoms you\u2019ll experience from low or dirty transmission fluid will be the same as transmission problems. If you check the fluid levels regularly and refill as necessary then you\u2019ll know if there are any symptoms of trouble that it\u2019s not because the fluid levels are low and you need to see a mechanic."},{"title":"Are there different types of transmission fluid?","content":"How do I know what to buy? Yes, there are many different types of transmission fluid, each designed for a certain transmission. Different vehicles require different transmission fluids and the age of the boat can also be a factor because newer transmissions take different types of transmission fluids than older vehicles. Don\u2019t guess! Find out which type of transmission fluid is required for your vehicle by checking your owner\u2019s manual."},{"title":"What is a transmission flush and should I get one?","content":"A transmission flush is used by some auto repair shops with the goal of flushing out debris.  Auto Tech does not do any sort of transmission flush.  Flushing an older transmission can cause harmful sediment to get stuck in the solenoids of the transmission. We heavily favor regular maintenance to lengthen the life of your transmission.  We service the transmission by changing fluid and the filter and do not recommend having your transmission flushed."},{"title":"How do I know I have a fluid leak from the transmission?","content":"Transmission fluid is slightly pink in color \u2013 it will appear pink or red, or possibly more brownish if the transmission fluid is dirty and needs to be replaced. When you feel transmission fluid it will be slick and oily on your fingers. It smells much like oil unless it is dirty, in which case it will smell burnt. Usually transmission fluid leaks around the front or middle of your vehicle, so if you find puddles of reddish liquid there it is probably transmission fluid. Another clue is if in addition to the leak your transmission is not working well and you notice changes in the way it sounds when you shift gears, or if shifting gears is not working as well. In this case you likely have a leak of transmission fluid that is impacting how your transmission operates."}]',
                'status' => "publish",
                'create_user' => $create_user,
                'author_id' => $create_user,
                'created_at' =>  date("Y-m-d H:i:s"),
                'max_guest'=>rand(5,15),
                'cabin'=>rand(1,5),
                'length'=>rand(10,20)."m",
                'speed'=>rand(25,35)."km/h",
                'specs'=>'{"0":{"title":"Manufacturer","content":"Sunrise"},"1":{"title":"Boat skipper","content":"Bareboat"},"2":{"title":"Model","content":"Summer Breeze"},"3":{"title":"Year","content":"2010"},"4":{"title":"Number of crew","content":"5"},"5":{"title":"Engines","content":"Diesel"},"6":{"title":"Fuel","content":"Composite"}}',
                'cancel_policy'=>"Full refund up to 4 days prior.",
                'terms_information'=>"<p>For Sanitary purposes ONLY, although there is a working toilet and shower, we've deactivated the shower and the toliet is for limited use (urine only..pardon the graphic detail!). This keeps the boat clean and odor-free for all of our guests.&nbsp; Sinks can be used.</p>
<p>Booking is weather pending. Because of the safety factors associated with the boat and inclement weather, If forecast shows rain, strong winds etc, the Host will communicate with Guest 24-48hrs in advance to mutually cancel/reschedule reservation. No smoking in boat cabin.</p>",
                'enable_extra_price' => '1',
                'extra_price' => '[{"name":"Child Toddler Seat","price":"100","type":"one_time"},{"name":"Infant Child Seat","price":"100","type":"one_time"},{"name":"GPS Satellite","price":"200","type":"one_time"}]',
            ]);
        $IDs_vendor[] = $create_user =   rand(4,6);
        $IDs[] = DB::table('bravo_boats')->insertGetId(
            [
                'title' => 'Carpe Diem LA',
                'slug' => Str::slug('Carpe Diem LA', '-'),
                'content' => "<p>Libero sem vitae sed donec conubia integer nisi integer rhoncus imperdiet orci odio libero est integer a integer tincidunt sollicitudin blandit fusce nibh leo vulputate lobortis egestas dapibus faucibus metus conubia maecenas cras potenti cum hac arcu rhoncus nullam eros dictum torquent integer cursus bibendum sem sociis molestie tellus purus</p><p>Quam fusce convallis ipsum malesuada amet velit aliquam urna nullam vehicula fermentum id morbi dis magnis porta sagittis euismod etiam</p><h4>HIGHLIGHTS</h4><ul><li>Visit the Museum of Modern Art in Manhattan</li><li>See amazing works of contemporary art, including Vincent van Gogh's The Starry Night</li><li>Check out Campbell's Soup Cans by Warhol and The Dance (I) by Matisse</li><li>Behold masterpieces by Gauguin, Dali, Picasso, and Pollock</li><li>Enjoy free audio guides available in English, French, German, Italian, Spanish, Portuguese</li></ul>",
                'image_id' => MediaFile::findMediaByName("boat-7")->id,
                'banner_image_id' => MediaFile::findMediaByName('banner-boat-single')->id,
                'location_id' => 1,
                'address' => "Arrondissement de Paris",
                'is_featured' => rand(0,1),
                'gallery' => implode(",",$list_gallery),
                'video' => "https://www.youtube.com/watch?v=UfEiKK-iX70",
                'number' => 1,
                'price_per_hour' => "200",
                'price_per_day' => "750",
                'min_price' => "200",
                'map_lat' => "21.017437",
                'map_lng' => "105.831179",
                'map_zoom' => "12",
                'faqs' => '[{"title":"When should I check the transmission fluid?","content":"You should check the transmission fluid regularly. Try to check it at least once a month or at the sign of any trouble, for instance if there is any hesitation when you shift gears in an automatic."},{"title":"How do I check the transmission fluid?","content":"It\u2019s not hard to check your transmission fluid if the vehicle is an automatic. This link to the Dummies guide to checking your transmission fluid has step-by-step instructions and illustrations that show you where to locate the dipstick. What you want is clear, pink transmission fluid. If it is low, top it up. If it is dark, smells burnt or has bits in it then you need to get it changed by at a reliable auto repair shop."},{"title":"Is it really that important to check the transmission fluid?","content":"Yes, it can be. Often times the symptoms you\u2019ll experience from low or dirty transmission fluid will be the same as transmission problems. If you check the fluid levels regularly and refill as necessary then you\u2019ll know if there are any symptoms of trouble that it\u2019s not because the fluid levels are low and you need to see a mechanic."},{"title":"Are there different types of transmission fluid?","content":"How do I know what to buy? Yes, there are many different types of transmission fluid, each designed for a certain transmission. Different vehicles require different transmission fluids and the age of the boat can also be a factor because newer transmissions take different types of transmission fluids than older vehicles. Don\u2019t guess! Find out which type of transmission fluid is required for your vehicle by checking your owner\u2019s manual."},{"title":"What is a transmission flush and should I get one?","content":"A transmission flush is used by some auto repair shops with the goal of flushing out debris.  Auto Tech does not do any sort of transmission flush.  Flushing an older transmission can cause harmful sediment to get stuck in the solenoids of the transmission. We heavily favor regular maintenance to lengthen the life of your transmission.  We service the transmission by changing fluid and the filter and do not recommend having your transmission flushed."},{"title":"How do I know I have a fluid leak from the transmission?","content":"Transmission fluid is slightly pink in color \u2013 it will appear pink or red, or possibly more brownish if the transmission fluid is dirty and needs to be replaced. When you feel transmission fluid it will be slick and oily on your fingers. It smells much like oil unless it is dirty, in which case it will smell burnt. Usually transmission fluid leaks around the front or middle of your vehicle, so if you find puddles of reddish liquid there it is probably transmission fluid. Another clue is if in addition to the leak your transmission is not working well and you notice changes in the way it sounds when you shift gears, or if shifting gears is not working as well. In this case you likely have a leak of transmission fluid that is impacting how your transmission operates."}]',
                'status' => "publish",
                'create_user' => $create_user,
                'author_id' => $create_user,
                'created_at' =>  date("Y-m-d H:i:s"),
                'max_guest'=>rand(5,15),
                'cabin'=>rand(1,5),
                'length'=>rand(10,20)."m",
                'speed'=>rand(25,35)."km/h",
                'specs'=>'{"0":{"title":"Manufacturer","content":"Sunrise"},"1":{"title":"Boat skipper","content":"Bareboat"},"2":{"title":"Model","content":"Summer Breeze"},"3":{"title":"Year","content":"2010"},"4":{"title":"Number of crew","content":"5"},"5":{"title":"Engines","content":"Diesel"},"6":{"title":"Fuel","content":"Composite"}}',
                'cancel_policy'=>"Full refund up to 4 days prior.",
                'terms_information'=>"<p>For Sanitary purposes ONLY, although there is a working toilet and shower, we've deactivated the shower and the toliet is for limited use (urine only..pardon the graphic detail!). This keeps the boat clean and odor-free for all of our guests.&nbsp; Sinks can be used.</p>
<p>Booking is weather pending. Because of the safety factors associated with the boat and inclement weather, If forecast shows rain, strong winds etc, the Host will communicate with Guest 24-48hrs in advance to mutually cancel/reschedule reservation. No smoking in boat cabin.</p>",
                'enable_extra_price' => '1',
                'extra_price' => '[{"name":"Child Toddler Seat","price":"100","type":"one_time"},{"name":"Infant Child Seat","price":"100","type":"one_time"},{"name":"GPS Satellite","price":"200","type":"one_time"}]',
            ]);
        $IDs_vendor[] = $create_user =   rand(4,6);
        $IDs[] = DB::table('bravo_boats')->insertGetId(
            [
                'title' => 'Destiny 6',
                'slug' => Str::slug('Destiny 6', '-'),
                'content' => "<p>Libero sem vitae sed donec conubia integer nisi integer rhoncus imperdiet orci odio libero est integer a integer tincidunt sollicitudin blandit fusce nibh leo vulputate lobortis egestas dapibus faucibus metus conubia maecenas cras potenti cum hac arcu rhoncus nullam eros dictum torquent integer cursus bibendum sem sociis molestie tellus purus</p><p>Quam fusce convallis ipsum malesuada amet velit aliquam urna nullam vehicula fermentum id morbi dis magnis porta sagittis euismod etiam</p><h4>HIGHLIGHTS</h4><ul><li>Visit the Museum of Modern Art in Manhattan</li><li>See amazing works of contemporary art, including Vincent van Gogh's The Starry Night</li><li>Check out Campbell's Soup Cans by Warhol and The Dance (I) by Matisse</li><li>Behold masterpieces by Gauguin, Dali, Picasso, and Pollock</li><li>Enjoy free audio guides available in English, French, German, Italian, Spanish, Portuguese</li></ul>",
                'image_id' => MediaFile::findMediaByName("boat-8")->id,
                'banner_image_id' => MediaFile::findMediaByName('banner-boat-single')->id,
                'location_id' => 6,
                'address' => "Arrondissement de Paris",
                'is_featured' => rand(0,1),
                'gallery' => implode(",",$list_gallery),
                'video' => "https://www.youtube.com/watch?v=UfEiKK-iX70",
                'number' => 1,
                'price_per_hour' => "180",
                'price_per_day' => "400",
                'min_price' => "180",
                'map_lat' => "21.047879",
                'map_lng' => "105.809731",
                'map_zoom' => "12",
                'faqs' => '[{"title":"When should I check the transmission fluid?","content":"You should check the transmission fluid regularly. Try to check it at least once a month or at the sign of any trouble, for instance if there is any hesitation when you shift gears in an automatic."},{"title":"How do I check the transmission fluid?","content":"It\u2019s not hard to check your transmission fluid if the vehicle is an automatic. This link to the Dummies guide to checking your transmission fluid has step-by-step instructions and illustrations that show you where to locate the dipstick. What you want is clear, pink transmission fluid. If it is low, top it up. If it is dark, smells burnt or has bits in it then you need to get it changed by at a reliable auto repair shop."},{"title":"Is it really that important to check the transmission fluid?","content":"Yes, it can be. Often times the symptoms you\u2019ll experience from low or dirty transmission fluid will be the same as transmission problems. If you check the fluid levels regularly and refill as necessary then you\u2019ll know if there are any symptoms of trouble that it\u2019s not because the fluid levels are low and you need to see a mechanic."},{"title":"Are there different types of transmission fluid?","content":"How do I know what to buy? Yes, there are many different types of transmission fluid, each designed for a certain transmission. Different vehicles require different transmission fluids and the age of the boat can also be a factor because newer transmissions take different types of transmission fluids than older vehicles. Don\u2019t guess! Find out which type of transmission fluid is required for your vehicle by checking your owner\u2019s manual."},{"title":"What is a transmission flush and should I get one?","content":"A transmission flush is used by some auto repair shops with the goal of flushing out debris.  Auto Tech does not do any sort of transmission flush.  Flushing an older transmission can cause harmful sediment to get stuck in the solenoids of the transmission. We heavily favor regular maintenance to lengthen the life of your transmission.  We service the transmission by changing fluid and the filter and do not recommend having your transmission flushed."},{"title":"How do I know I have a fluid leak from the transmission?","content":"Transmission fluid is slightly pink in color \u2013 it will appear pink or red, or possibly more brownish if the transmission fluid is dirty and needs to be replaced. When you feel transmission fluid it will be slick and oily on your fingers. It smells much like oil unless it is dirty, in which case it will smell burnt. Usually transmission fluid leaks around the front or middle of your vehicle, so if you find puddles of reddish liquid there it is probably transmission fluid. Another clue is if in addition to the leak your transmission is not working well and you notice changes in the way it sounds when you shift gears, or if shifting gears is not working as well. In this case you likely have a leak of transmission fluid that is impacting how your transmission operates."}]',
                'status' => "publish",
                'create_user' => $create_user,
                'author_id' => $create_user,
                'created_at' =>  date("Y-m-d H:i:s"),
                'max_guest'=>rand(5,15),
                'cabin'=>rand(1,5),
                'length'=>rand(10,20)."m",
                'speed'=>rand(25,35)."km/h",
                'specs'=>'{"0":{"title":"Manufacturer","content":"Sunrise"},"1":{"title":"Boat skipper","content":"Bareboat"},"2":{"title":"Model","content":"Summer Breeze"},"3":{"title":"Year","content":"2010"},"4":{"title":"Number of crew","content":"5"},"5":{"title":"Engines","content":"Diesel"},"6":{"title":"Fuel","content":"Composite"}}',
                'cancel_policy'=>"Full refund up to 4 days prior.",
                'terms_information'=>"<p>For Sanitary purposes ONLY, although there is a working toilet and shower, we've deactivated the shower and the toliet is for limited use (urine only..pardon the graphic detail!). This keeps the boat clean and odor-free for all of our guests.&nbsp; Sinks can be used.</p>
<p>Booking is weather pending. Because of the safety factors associated with the boat and inclement weather, If forecast shows rain, strong winds etc, the Host will communicate with Guest 24-48hrs in advance to mutually cancel/reschedule reservation. No smoking in boat cabin.</p>",
                'enable_extra_price' => '1',
                'extra_price' => '[{"name":"Child Toddler Seat","price":"100","type":"one_time"},{"name":"Infant Child Seat","price":"100","type":"one_time"},{"name":"GPS Satellite","price":"200","type":"one_time"}]',
            ]);
        $IDs_vendor[] = $create_user =   rand(4,6);
        $IDs[] = DB::table('bravo_boats')->insertGetId(
            [
                'title' => 'Endless Summer W-10',
                'slug' => Str::slug('Endless Summer W-10', '-'),
                'content' => "<p>Libero sem vitae sed donec conubia integer nisi integer rhoncus imperdiet orci odio libero est integer a integer tincidunt sollicitudin blandit fusce nibh leo vulputate lobortis egestas dapibus faucibus metus conubia maecenas cras potenti cum hac arcu rhoncus nullam eros dictum torquent integer cursus bibendum sem sociis molestie tellus purus</p><p>Quam fusce convallis ipsum malesuada amet velit aliquam urna nullam vehicula fermentum id morbi dis magnis porta sagittis euismod etiam</p><h4>HIGHLIGHTS</h4><ul><li>Visit the Museum of Modern Art in Manhattan</li><li>See amazing works of contemporary art, including Vincent van Gogh's The Starry Night</li><li>Check out Campbell's Soup Cans by Warhol and The Dance (I) by Matisse</li><li>Behold masterpieces by Gauguin, Dali, Picasso, and Pollock</li><li>Enjoy free audio guides available in English, French, German, Italian, Spanish, Portuguese</li></ul>",
                'image_id' => MediaFile::findMediaByName("boat-9")->id,
                'banner_image_id' => MediaFile::findMediaByName('banner-boat-single')->id,
                'location_id' => 7,
                'address' => "Arrondissement de Paris",
                'is_featured' => rand(0,1),
                'gallery' => implode(",",$list_gallery),
                'video' => "https://www.youtube.com/watch?v=UfEiKK-iX70",
                'number' => 1,
                'price_per_hour' => "230",
                'price_per_day' => "650",
                'min_price' => "230",
                'map_lat' => "21.025449",
                'map_lng' => "105.804412",
                'map_zoom' => "12",
                'faqs' => '[{"title":"When should I check the transmission fluid?","content":"You should check the transmission fluid regularly. Try to check it at least once a month or at the sign of any trouble, for instance if there is any hesitation when you shift gears in an automatic."},{"title":"How do I check the transmission fluid?","content":"It\u2019s not hard to check your transmission fluid if the vehicle is an automatic. This link to the Dummies guide to checking your transmission fluid has step-by-step instructions and illustrations that show you where to locate the dipstick. What you want is clear, pink transmission fluid. If it is low, top it up. If it is dark, smells burnt or has bits in it then you need to get it changed by at a reliable auto repair shop."},{"title":"Is it really that important to check the transmission fluid?","content":"Yes, it can be. Often times the symptoms you\u2019ll experience from low or dirty transmission fluid will be the same as transmission problems. If you check the fluid levels regularly and refill as necessary then you\u2019ll know if there are any symptoms of trouble that it\u2019s not because the fluid levels are low and you need to see a mechanic."},{"title":"Are there different types of transmission fluid?","content":"How do I know what to buy? Yes, there are many different types of transmission fluid, each designed for a certain transmission. Different vehicles require different transmission fluids and the age of the boat can also be a factor because newer transmissions take different types of transmission fluids than older vehicles. Don\u2019t guess! Find out which type of transmission fluid is required for your vehicle by checking your owner\u2019s manual."},{"title":"What is a transmission flush and should I get one?","content":"A transmission flush is used by some auto repair shops with the goal of flushing out debris.  Auto Tech does not do any sort of transmission flush.  Flushing an older transmission can cause harmful sediment to get stuck in the solenoids of the transmission. We heavily favor regular maintenance to lengthen the life of your transmission.  We service the transmission by changing fluid and the filter and do not recommend having your transmission flushed."},{"title":"How do I know I have a fluid leak from the transmission?","content":"Transmission fluid is slightly pink in color \u2013 it will appear pink or red, or possibly more brownish if the transmission fluid is dirty and needs to be replaced. When you feel transmission fluid it will be slick and oily on your fingers. It smells much like oil unless it is dirty, in which case it will smell burnt. Usually transmission fluid leaks around the front or middle of your vehicle, so if you find puddles of reddish liquid there it is probably transmission fluid. Another clue is if in addition to the leak your transmission is not working well and you notice changes in the way it sounds when you shift gears, or if shifting gears is not working as well. In this case you likely have a leak of transmission fluid that is impacting how your transmission operates."}]',
                'status' => "publish",
                'create_user' => $create_user,
                'author_id' => $create_user,
                'created_at' =>  date("Y-m-d H:i:s"),
                'max_guest'=>rand(5,15),
                'cabin'=>rand(1,5),
                'length'=>rand(10,20)."m",
                'speed'=>rand(25,35)."km/h",
                'specs'=>'{"0":{"title":"Manufacturer","content":"Sunrise"},"1":{"title":"Boat skipper","content":"Bareboat"},"2":{"title":"Model","content":"Summer Breeze"},"3":{"title":"Year","content":"2010"},"4":{"title":"Number of crew","content":"5"},"5":{"title":"Engines","content":"Diesel"},"6":{"title":"Fuel","content":"Composite"}}',
                'cancel_policy'=>"Full refund up to 4 days prior.",
                'terms_information'=>"<p>For Sanitary purposes ONLY, although there is a working toilet and shower, we've deactivated the shower and the toliet is for limited use (urine only..pardon the graphic detail!). This keeps the boat clean and odor-free for all of our guests.&nbsp; Sinks can be used.</p>
<p>Booking is weather pending. Because of the safety factors associated with the boat and inclement weather, If forecast shows rain, strong winds etc, the Host will communicate with Guest 24-48hrs in advance to mutually cancel/reschedule reservation. No smoking in boat cabin.</p>",
                'enable_extra_price' => '1',
                'extra_price' => '[{"name":"Child Toddler Seat","price":"100","type":"one_time"},{"name":"Infant Child Seat","price":"100","type":"one_time"},{"name":"GPS Satellite","price":"200","type":"one_time"}]',
            ]);
        $IDs_vendor[] = $create_user =   rand(4,6);
        $IDs[] = DB::table('bravo_boats')->insertGetId(
            [
                'title' => 'Freedom M2',
                'slug' => Str::slug('Freedom M2', '-'),
                'content' => "<p>Libero sem vitae sed donec conubia integer nisi integer rhoncus imperdiet orci odio libero est integer a integer tincidunt sollicitudin blandit fusce nibh leo vulputate lobortis egestas dapibus faucibus metus conubia maecenas cras potenti cum hac arcu rhoncus nullam eros dictum torquent integer cursus bibendum sem sociis molestie tellus purus</p><p>Quam fusce convallis ipsum malesuada amet velit aliquam urna nullam vehicula fermentum id morbi dis magnis porta sagittis euismod etiam</p><h4>HIGHLIGHTS</h4><ul><li>Visit the Museum of Modern Art in Manhattan</li><li>See amazing works of contemporary art, including Vincent van Gogh's The Starry Night</li><li>Check out Campbell's Soup Cans by Warhol and The Dance (I) by Matisse</li><li>Behold masterpieces by Gauguin, Dali, Picasso, and Pollock</li><li>Enjoy free audio guides available in English, French, German, Italian, Spanish, Portuguese</li></ul>",
                'image_id' => MediaFile::findMediaByName("boat-10")->id,
                'banner_image_id' => MediaFile::findMediaByName('banner-boat-single')->id,
                'location_id' => 8,
                'address' => "Arrondissement de Paris",
                'is_featured' => rand(0,1),
                'gallery' => implode(",",$list_gallery),
                'video' => "https://www.youtube.com/watch?v=UfEiKK-iX70",
                'number' => 1,
                'price_per_hour' => "50",
                'price_per_day' => "200",
                'min_price' => "50",
                'map_lat' => "21.020001",
                'map_lng' => "105.836670",
                'map_zoom' => "12",
                'faqs' => '[{"title":"When should I check the transmission fluid?","content":"You should check the transmission fluid regularly. Try to check it at least once a month or at the sign of any trouble, for instance if there is any hesitation when you shift gears in an automatic."},{"title":"How do I check the transmission fluid?","content":"It\u2019s not hard to check your transmission fluid if the vehicle is an automatic. This link to the Dummies guide to checking your transmission fluid has step-by-step instructions and illustrations that show you where to locate the dipstick. What you want is clear, pink transmission fluid. If it is low, top it up. If it is dark, smells burnt or has bits in it then you need to get it changed by at a reliable auto repair shop."},{"title":"Is it really that important to check the transmission fluid?","content":"Yes, it can be. Often times the symptoms you\u2019ll experience from low or dirty transmission fluid will be the same as transmission problems. If you check the fluid levels regularly and refill as necessary then you\u2019ll know if there are any symptoms of trouble that it\u2019s not because the fluid levels are low and you need to see a mechanic."},{"title":"Are there different types of transmission fluid?","content":"How do I know what to buy? Yes, there are many different types of transmission fluid, each designed for a certain transmission. Different vehicles require different transmission fluids and the age of the boat can also be a factor because newer transmissions take different types of transmission fluids than older vehicles. Don\u2019t guess! Find out which type of transmission fluid is required for your vehicle by checking your owner\u2019s manual."},{"title":"What is a transmission flush and should I get one?","content":"A transmission flush is used by some auto repair shops with the goal of flushing out debris.  Auto Tech does not do any sort of transmission flush.  Flushing an older transmission can cause harmful sediment to get stuck in the solenoids of the transmission. We heavily favor regular maintenance to lengthen the life of your transmission.  We service the transmission by changing fluid and the filter and do not recommend having your transmission flushed."},{"title":"How do I know I have a fluid leak from the transmission?","content":"Transmission fluid is slightly pink in color \u2013 it will appear pink or red, or possibly more brownish if the transmission fluid is dirty and needs to be replaced. When you feel transmission fluid it will be slick and oily on your fingers. It smells much like oil unless it is dirty, in which case it will smell burnt. Usually transmission fluid leaks around the front or middle of your vehicle, so if you find puddles of reddish liquid there it is probably transmission fluid. Another clue is if in addition to the leak your transmission is not working well and you notice changes in the way it sounds when you shift gears, or if shifting gears is not working as well. In this case you likely have a leak of transmission fluid that is impacting how your transmission operates."}]',
                'status' => "publish",
                'create_user' => $create_user,
                'author_id' => $create_user,
                'created_at' =>  date("Y-m-d H:i:s"),
                'max_guest'=>rand(5,15),
                'cabin'=>rand(1,5),
                'length'=>rand(10,20)."m",
                'speed'=>rand(25,35)."km/h",
                'specs'=>'{"0":{"title":"Manufacturer","content":"Sunrise"},"1":{"title":"Boat skipper","content":"Bareboat"},"2":{"title":"Model","content":"Summer Breeze"},"3":{"title":"Year","content":"2010"},"4":{"title":"Number of crew","content":"5"},"5":{"title":"Engines","content":"Diesel"},"6":{"title":"Fuel","content":"Composite"}}',
                'cancel_policy'=>"Full refund up to 4 days prior.",
                'terms_information'=>"<p>For Sanitary purposes ONLY, although there is a working toilet and shower, we've deactivated the shower and the toliet is for limited use (urine only..pardon the graphic detail!). This keeps the boat clean and odor-free for all of our guests.&nbsp; Sinks can be used.</p>
<p>Booking is weather pending. Because of the safety factors associated with the boat and inclement weather, If forecast shows rain, strong winds etc, the Host will communicate with Guest 24-48hrs in advance to mutually cancel/reschedule reservation. No smoking in boat cabin.</p>",
                'enable_extra_price' => '1',
                'extra_price' => '[{"name":"Child Toddler Seat","price":"100","type":"one_time"},{"name":"Infant Child Seat","price":"100","type":"one_time"},{"name":"GPS Satellite","price":"200","type":"one_time"}]',
            ]);
        $IDs_vendor[] = $create_user =   rand(4,6);
        $IDs[] = DB::table('bravo_boats')->insertGetId(
            [
                'title' => 'Ohana 3X',
                'slug' => Str::slug('Ohana 3X', '-'),
                'content' => "<p>Libero sem vitae sed donec conubia integer nisi integer rhoncus imperdiet orci odio libero est integer a integer tincidunt sollicitudin blandit fusce nibh leo vulputate lobortis egestas dapibus faucibus metus conubia maecenas cras potenti cum hac arcu rhoncus nullam eros dictum torquent integer cursus bibendum sem sociis molestie tellus purus</p><p>Quam fusce convallis ipsum malesuada amet velit aliquam urna nullam vehicula fermentum id morbi dis magnis porta sagittis euismod etiam</p><h4>HIGHLIGHTS</h4><ul><li>Visit the Museum of Modern Art in Manhattan</li><li>See amazing works of contemporary art, including Vincent van Gogh's The Starry Night</li><li>Check out Campbell's Soup Cans by Warhol and The Dance (I) by Matisse</li><li>Behold masterpieces by Gauguin, Dali, Picasso, and Pollock</li><li>Enjoy free audio guides available in English, French, German, Italian, Spanish, Portuguese</li></ul>",
                'image_id' => MediaFile::findMediaByName("boat-11")->id,
                'banner_image_id' => MediaFile::findMediaByName('banner-boat-single')->id,
                'location_id' => 3,
                'address' => "Arrondissement de Paris",
                'is_featured' => rand(0,1),
                'gallery' => implode(",",$list_gallery),
                'video' => "https://www.youtube.com/watch?v=UfEiKK-iX70",
                'number' => 1,
                'price_per_hour' => "80",
                'price_per_day' => "200",
                'min_price' => "80",
                'map_lat' => "21.051244",
                'map_lng' => "105.777988",
                'map_zoom' => "12",
                'faqs' => '[{"title":"When should I check the transmission fluid?","content":"You should check the transmission fluid regularly. Try to check it at least once a month or at the sign of any trouble, for instance if there is any hesitation when you shift gears in an automatic."},{"title":"How do I check the transmission fluid?","content":"It\u2019s not hard to check your transmission fluid if the vehicle is an automatic. This link to the Dummies guide to checking your transmission fluid has step-by-step instructions and illustrations that show you where to locate the dipstick. What you want is clear, pink transmission fluid. If it is low, top it up. If it is dark, smells burnt or has bits in it then you need to get it changed by at a reliable auto repair shop."},{"title":"Is it really that important to check the transmission fluid?","content":"Yes, it can be. Often times the symptoms you\u2019ll experience from low or dirty transmission fluid will be the same as transmission problems. If you check the fluid levels regularly and refill as necessary then you\u2019ll know if there are any symptoms of trouble that it\u2019s not because the fluid levels are low and you need to see a mechanic."},{"title":"Are there different types of transmission fluid?","content":"How do I know what to buy? Yes, there are many different types of transmission fluid, each designed for a certain transmission. Different vehicles require different transmission fluids and the age of the boat can also be a factor because newer transmissions take different types of transmission fluids than older vehicles. Don\u2019t guess! Find out which type of transmission fluid is required for your vehicle by checking your owner\u2019s manual."},{"title":"What is a transmission flush and should I get one?","content":"A transmission flush is used by some auto repair shops with the goal of flushing out debris.  Auto Tech does not do any sort of transmission flush.  Flushing an older transmission can cause harmful sediment to get stuck in the solenoids of the transmission. We heavily favor regular maintenance to lengthen the life of your transmission.  We service the transmission by changing fluid and the filter and do not recommend having your transmission flushed."},{"title":"How do I know I have a fluid leak from the transmission?","content":"Transmission fluid is slightly pink in color \u2013 it will appear pink or red, or possibly more brownish if the transmission fluid is dirty and needs to be replaced. When you feel transmission fluid it will be slick and oily on your fingers. It smells much like oil unless it is dirty, in which case it will smell burnt. Usually transmission fluid leaks around the front or middle of your vehicle, so if you find puddles of reddish liquid there it is probably transmission fluid. Another clue is if in addition to the leak your transmission is not working well and you notice changes in the way it sounds when you shift gears, or if shifting gears is not working as well. In this case you likely have a leak of transmission fluid that is impacting how your transmission operates."}]',
                'status' => "publish",
                'create_user' => $create_user,
                'author_id' => $create_user,
                'created_at' =>  date("Y-m-d H:i:s"),
                'max_guest'=>rand(5,15),
                'cabin'=>rand(1,5),
                'length'=>rand(10,20)."m",
                'speed'=>rand(25,35)."km/h",
                'specs'=>'{"0":{"title":"Manufacturer","content":"Sunrise"},"1":{"title":"Boat skipper","content":"Bareboat"},"2":{"title":"Model","content":"Summer Breeze"},"3":{"title":"Year","content":"2010"},"4":{"title":"Number of crew","content":"5"},"5":{"title":"Engines","content":"Diesel"},"6":{"title":"Fuel","content":"Composite"}}',
                'cancel_policy'=>"Full refund up to 4 days prior.",
                'terms_information'=>"<p>For Sanitary purposes ONLY, although there is a working toilet and shower, we've deactivated the shower and the toliet is for limited use (urine only..pardon the graphic detail!). This keeps the boat clean and odor-free for all of our guests.&nbsp; Sinks can be used.</p>
<p>Booking is weather pending. Because of the safety factors associated with the boat and inclement weather, If forecast shows rain, strong winds etc, the Host will communicate with Guest 24-48hrs in advance to mutually cancel/reschedule reservation. No smoking in boat cabin.</p>",
                'enable_extra_price' => '1',
                'extra_price' => '[{"name":"Child Toddler Seat","price":"100","type":"one_time"},{"name":"Infant Child Seat","price":"100","type":"one_time"},{"name":"GPS Satellite","price":"200","type":"one_time"}]',
            ]);
        $IDs_vendor[] = $create_user =   rand(4,6);
        $IDs[] = DB::table('bravo_boats')->insertGetId(
            [
                'title' => 'My Way 100',
                'slug' => Str::slug('My Way 100', '-'),
                'content' => "<p>Libero sem vitae sed donec conubia integer nisi integer rhoncus imperdiet orci odio libero est integer a integer tincidunt sollicitudin blandit fusce nibh leo vulputate lobortis egestas dapibus faucibus metus conubia maecenas cras potenti cum hac arcu rhoncus nullam eros dictum torquent integer cursus bibendum sem sociis molestie tellus purus</p><p>Quam fusce convallis ipsum malesuada amet velit aliquam urna nullam vehicula fermentum id morbi dis magnis porta sagittis euismod etiam</p><h4>HIGHLIGHTS</h4><ul><li>Visit the Museum of Modern Art in Manhattan</li><li>See amazing works of contemporary art, including Vincent van Gogh's The Starry Night</li><li>Check out Campbell's Soup Cans by Warhol and The Dance (I) by Matisse</li><li>Behold masterpieces by Gauguin, Dali, Picasso, and Pollock</li><li>Enjoy free audio guides available in English, French, German, Italian, Spanish, Portuguese</li></ul>",
                'image_id' => MediaFile::findMediaByName("boat-12")->id,
                'banner_image_id' => MediaFile::findMediaByName('banner-boat-single')->id,
                'location_id' => 1,
                'address' => "Arrondissement de Paris",
                'is_featured' => rand(0,1),
                'gallery' => implode(",",$list_gallery),
                'video' => "https://www.youtube.com/watch?v=UfEiKK-iX70",
                'number' => 1,
                'price_per_hour' => "150",
                'price_per_day' => "300",
                'min_price' => "150",
                'map_lat' => "21.053326",
                'map_lng' => "105.841475",
                'map_zoom' => "12",
                'faqs' => '[{"title":"When should I check the transmission fluid?","content":"You should check the transmission fluid regularly. Try to check it at least once a month or at the sign of any trouble, for instance if there is any hesitation when you shift gears in an automatic."},{"title":"How do I check the transmission fluid?","content":"It\u2019s not hard to check your transmission fluid if the vehicle is an automatic. This link to the Dummies guide to checking your transmission fluid has step-by-step instructions and illustrations that show you where to locate the dipstick. What you want is clear, pink transmission fluid. If it is low, top it up. If it is dark, smells burnt or has bits in it then you need to get it changed by at a reliable auto repair shop."},{"title":"Is it really that important to check the transmission fluid?","content":"Yes, it can be. Often times the symptoms you\u2019ll experience from low or dirty transmission fluid will be the same as transmission problems. If you check the fluid levels regularly and refill as necessary then you\u2019ll know if there are any symptoms of trouble that it\u2019s not because the fluid levels are low and you need to see a mechanic."},{"title":"Are there different types of transmission fluid?","content":"How do I know what to buy? Yes, there are many different types of transmission fluid, each designed for a certain transmission. Different vehicles require different transmission fluids and the age of the boat can also be a factor because newer transmissions take different types of transmission fluids than older vehicles. Don\u2019t guess! Find out which type of transmission fluid is required for your vehicle by checking your owner\u2019s manual."},{"title":"What is a transmission flush and should I get one?","content":"A transmission flush is used by some auto repair shops with the goal of flushing out debris.  Auto Tech does not do any sort of transmission flush.  Flushing an older transmission can cause harmful sediment to get stuck in the solenoids of the transmission. We heavily favor regular maintenance to lengthen the life of your transmission.  We service the transmission by changing fluid and the filter and do not recommend having your transmission flushed."},{"title":"How do I know I have a fluid leak from the transmission?","content":"Transmission fluid is slightly pink in color \u2013 it will appear pink or red, or possibly more brownish if the transmission fluid is dirty and needs to be replaced. When you feel transmission fluid it will be slick and oily on your fingers. It smells much like oil unless it is dirty, in which case it will smell burnt. Usually transmission fluid leaks around the front or middle of your vehicle, so if you find puddles of reddish liquid there it is probably transmission fluid. Another clue is if in addition to the leak your transmission is not working well and you notice changes in the way it sounds when you shift gears, or if shifting gears is not working as well. In this case you likely have a leak of transmission fluid that is impacting how your transmission operates."}]',
                'status' => "publish",
                'create_user' => $create_user,
                'author_id' => $create_user,
                'created_at' =>  date("Y-m-d H:i:s"),
                'max_guest'=>rand(5,15),
                'cabin'=>rand(1,5),
                'length'=>rand(10,20)."m",
                'speed'=>rand(25,35)."km/h",
                'specs'=>'{"0":{"title":"Manufacturer","content":"Sunrise"},"1":{"title":"Boat skipper","content":"Bareboat"},"2":{"title":"Model","content":"Summer Breeze"},"3":{"title":"Year","content":"2010"},"4":{"title":"Number of crew","content":"5"},"5":{"title":"Engines","content":"Diesel"},"6":{"title":"Fuel","content":"Composite"}}',
                'cancel_policy'=>"Full refund up to 4 days prior.",
                'terms_information'=>"<p>For Sanitary purposes ONLY, although there is a working toilet and shower, we've deactivated the shower and the toliet is for limited use (urine only..pardon the graphic detail!). This keeps the boat clean and odor-free for all of our guests.&nbsp; Sinks can be used.</p>
<p>Booking is weather pending. Because of the safety factors associated with the boat and inclement weather, If forecast shows rain, strong winds etc, the Host will communicate with Guest 24-48hrs in advance to mutually cancel/reschedule reservation. No smoking in boat cabin.</p>",
                'enable_extra_price' => '1',
                'extra_price' => '[{"name":"Child Toddler Seat","price":"100","type":"one_time"},{"name":"Infant Child Seat","price":"100","type":"one_time"},{"name":"GPS Satellite","price":"200","type":"one_time"}]',
            ]);

        // Add meta
        foreach ($IDs as $numer_key => $boat){
            $vendor_id = $IDs_vendor[$numer_key];
            for ($i = 1 ; $i <= 5 ; $i++){
                if( rand(1,5) == $i) continue;
                if( rand(1,5) == $i) continue;
                $metaReview = [];
                $list_meta = [
                    "Equipment",
                    "Comfortable",
                    "Climate Control",
                    "Facility",
                    "Aftercare",
                ];
                $total_point = 0;
                foreach ($list_meta as $key => $value) {
                    $point = rand(4,5);
                    $total_point += $point;
                    $metaReview[] = [
                        "object_id"    => $boat,
                        "object_model" => "boat",
                        "name"         => $value,
                        "val"          => $point,
                        "create_user"  => "1",
                    ];
                }
                $rate = round($total_point / count($list_meta), 1);
                if ($rate > 5) $rate = 5;
                $titles = ["Great Boat","Good Boat","Boat was great","Easy way to discover the city"];
                $review = new Review([
                    "object_id"    => $boat,
                    "object_model" => "boat",
                    "title"        => $titles[rand(0, 3)],
                    "content"      => "Eum eu sumo albucius perfecto, commodo torquatos consequuntur pro ut, id posse splendide ius. Cu nisl putent omittantur usu, mutat atomorum ex pro, ius nibh nonumy id. Nam at eius dissentias disputando, molestie mnesarchum complectitur per te",
                    "rate_number"  => $rate,
                    "author_ip"    => "127.0.0.1",
                    "status"       => "approved",
                    "publish_date" => date("Y-m-d H:i:s"),
                    'create_user' => rand(7,16),
                    'vendor_id' => $vendor_id,
                ]);
                if ($review->save()) {
                    if (!empty($metaReview)) {
                        foreach ($metaReview as $meta) {
                            $meta['review_id'] = $review->id;
                            $reviewMeta = new ReviewMeta($meta);
                            $reviewMeta->save();
                        }
                    }
                }
            }
        }

        // Settings
        DB::table('core_settings')->insert(
            [
                [
                    'name' => 'boat_page_search_title',
                    'val' => 'Search for boat',
                    'group' => "boat",
                ],
                [
                    'name' => 'boat_page_limit_item',
                    'val' => 9,
                    'group' => "boat",
                ],
                [
                    'name' => 'boat_page_search_banner',
                    'val' => MediaFile::findMediaByName("banner-search-boat")->id,
                    'group' => "boat",
                ],
                [
                    'name' => 'boat_layout_search',
                    'val' => 'normal',
                    'group' => "boat",
                ],
                [
                    'name' => 'boat_enable_review',
                    'val' => '1',
                    'group' => "boat",
                ],
                [
                    'name' => 'boat_review_approved',
                    'val' => '0',
                    'group' => "boat",
                ],
                [
                    'name' => 'boat_review_stats',
                    'val' => '[{"title":"Equipment"},{"title":"Comfortable"},{"title":"Climate Control"},{"title":"Facility"},{"title":"Aftercare"}]',
                    'group' => "boat",
                ],
                [
                    'name' => 'boat_booking_buyer_fees',
                    'val' => '[{"name":"Equipment fee","desc":"One-time fee charged by host to cover the cost of cleaning their space.","name_ja":"\u30af\u30ea\u30fc\u30cb\u30f3\u30b0\u4ee3","desc_ja":"\u30b9\u30da\u30fc\u30b9\u3092\u6383\u9664\u3059\u308b\u8cbb\u7528\u3092\u30db\u30b9\u30c8\u304c\u8acb\u6c42\u3059\u308b1\u56de\u9650\u308a\u306e\u6599\u91d1\u3002","price":"100","type":"one_time"},{"name":"Facility fee","desc":"This helps us run our platform and offer services like 24\/7 support on your trip.","name_ja":"\u30b5\u30fc\u30d3\u30b9\u6599","desc_ja":"\u3053\u308c\u306b\u3088\u308a\u3001\u5f53\u793e\u306e\u30d7\u30e9\u30c3\u30c8\u30d5\u30a9\u30fc\u30e0\u3092\u5b9f\u884c\u3057\u3001\u65c5\u884c\u4e2d\u306b","price":"200","type":"one_time"}]',
                    'group' => "boat",
                ],
                [
                    'name'=>'boat_map_search_fields',
                    'val'=>'[{"field":"location","attr":null,"position":"1"},{"field":"attr","attr":"14","position":"2"},{"field":"date","attr":null,"position":"3"},{"field":"price","attr":null,"position":"4"},{"field":"advance","attr":null,"position":"5"}]',
                    'group'=>'boat'
                ],
                [
                    'name'=>'boat_search_fields',
                    'val'=>'[{"title":"Location","field":"location","size":"6","position":"1"},{"title":"Start Date","field":"date","size":"6","position":"2"}]',
                    'group'=>'boat'
                ]
            ]
        );

        $boat_type = new \Modules\Core\Models\Attributes([
            'name'=>'Boat Type',
            'service'=>'boat',
            'hide_in_single'=>'1',
        ]);
        $boat_type->save();

        $term_ids = [];
        foreach (['Airboat','Cabin cruiser','Cruise ship','Express cruiser','Electric boat','Ferry','Inflatable boat','Jetboat'] as $k=>$term){
            $t = new \Modules\Core\Models\Terms([
                'name'=>$term,
                'attr_id'=>$boat_type->id,
            ]);
            $t->save();
            $term_ids[] = $t->id;
        }

        foreach ($IDs as $boat_id){
            foreach ($term_ids as $k=>$term_id) {
                if( rand(0 , count($term_ids) ) == $k) continue;
                if( rand(0 , count($term_ids) ) == $k) continue;
                if( rand(0 , count($term_ids) ) == $k) continue;
                \Modules\Boat\Models\BoatTerm::firstOrCreate([
                    'term_id' => $term_id,
                    'target_id' => $boat_id
                ]);
            }
        }

        $boat_type = new \Modules\Core\Models\Attributes([
            'name'=>'Amenities',
            'service'=>'boat'
        ]);
        $boat_type->save();

        $term_ids = [];
        foreach (['Events and Meetings','Scuba Gear','Hot Tub/Jacuzzi on Deck','Sport Fishing','Speciality Classic Yacht','Gulet'] as $k=>$term){
            $t = new \Modules\Core\Models\Terms([
                'name'=>$term,
                'attr_id'=>$boat_type->id,
            ]);
            $t->save();
            $term_ids[] = $t->id;
        }
        foreach ($IDs as $boat_id){
            foreach ($term_ids as $k=>$term_id) {
                if( rand(0 , count($term_ids) ) == $k) continue;
                if( rand(0 , count($term_ids) ) == $k) continue;
                \Modules\Boat\Models\BoatTerm::firstOrCreate([
                    'term_id' => $term_id,
                    'target_id' => $boat_id
                ]);
            }
        }

        //Update Review Score
        foreach ($IDs as $service_id){
            \Modules\Boat\Models\Boat::find($service_id)->update_service_rate();
        }
    }
}
