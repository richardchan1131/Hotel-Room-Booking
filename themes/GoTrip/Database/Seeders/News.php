<?php
namespace Themes\GoTrip\Database\Seeders;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class News extends \Database\Seeders\News
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        parent::run();

        $news_image = [
            'img_1' => DB::table('media_files')->insertGetId(['file_name' => 'news-1', 'file_path' => 'gotrip/news/news-1.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_2' => DB::table('media_files')->insertGetId(['file_name' => 'news-2', 'file_path' => 'gotrip/news/news-2.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_3' => DB::table('media_files')->insertGetId(['file_name' => 'news-3', 'file_path' => 'gotrip/news/news-3.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
            'img_4' => DB::table('media_files')->insertGetId(['file_name' => 'news-4', 'file_path' => 'gotrip/news/news-4.png', 'file_type' => 'image/png', 'file_extension' => 'png']),
        ];


        DB::table('core_news')->insert([
            'title' => 'The best times & places to see the Northern Lights in Iceland',
            'slug' => Str::slug('The best times & places to see the Northern Lights in Iceland', '-'),
            'content' => ' From the iconic to the unexpected, the city of San Francisco never ceases to surprise. Kick-start your effortlessly delivered Northern California holiday in the cosmopolitan hills of  The City . Join your Travel Director and fellow travellers for a Welcome Reception at your hotel.Welcome Reception  From the iconic to the unexpected, the city of San Francisco never ceases to surprise. Kick-start your effortlessly delivered Northern California holiday in the cosmopolitan hills of  The City . Join your Travel Director and fellow travellers for a Welcome Reception at your hotel.Welcome Reception <br/>From the iconic to the unexpected, the city of San Francisco never ceases to surprise. Kick-start your effortlessly delivered Northern California holiday in the cosmopolitan hills of  The City . Join your Travel Director and fellow travellers for a Welcome Reception at your hotel.Welcome Reception<br/>
    From the iconic to the unexpected, the city of San Francisco never ceases to surprise. Kick-start your effortlessly delivered Northern California holiday in the cosmopolitan hills of  The City . Join your Travel Director and fellow travellers for a Welcome Reception at your hotel.Welcome Reception',
            'status' => "publish",
            'cat_id' => rand(1, 4),
            'image_id' => $news_image['img_4'],
            'create_user' => '1',
            'author_id' => '1',
            'created_at' =>  date("Y-m-d H:i:s")
        ]);

        DB::table('core_news')->insert([
            'title' => 'Where can I go? 5 amazing countries that are open right now',
            'slug' => Str::slug('Where can I go? 5 amazing countries that are open right now', '-'),
            'content' => ' From the iconic to the unexpected, the city of San Francisco never ceases to surprise. Kick-start your effortlessly delivered Northern California holiday in the cosmopolitan hills of  The City . Join your Travel Director and fellow travellers for a Welcome Reception at your hotel.Welcome Reception  From the iconic to the unexpected, the city of San Francisco never ceases to surprise. Kick-start your effortlessly delivered Northern California holiday in the cosmopolitan hills of  The City . Join your Travel Director and fellow travellers for a Welcome Reception at your hotel.Welcome Reception <br/>From the iconic to the unexpected, the city of San Francisco never ceases to surprise. Kick-start your effortlessly delivered Northern California holiday in the cosmopolitan hills of  The City . Join your Travel Director and fellow travellers for a Welcome Reception at your hotel.Welcome Reception<br/>
    From the iconic to the unexpected, the city of San Francisco never ceases to surprise. Kick-start your effortlessly delivered Northern California holiday in the cosmopolitan hills of  The City . Join your Travel Director and fellow travellers for a Welcome Reception at your hotel.Welcome Reception',
            'status' => "publish",
            'cat_id' => rand(1, 4),
            'image_id' => $news_image['img_3'],
            'create_user' => '1',
            'author_id' => '1',
            'created_at' =>  date("Y-m-d H:i:s")
        ]);
        DB::table('core_news')->insert([
            'title' => 'Booking travel during Corona: good advice in an uncertain time',
            'slug' => Str::slug('Booking travel during Corona: good advice in an uncertain time', '-'),
            'content' => ' From the iconic to the unexpected, the city of San Francisco never ceases to surprise. Kick-start your effortlessly delivered Northern California holiday in the cosmopolitan hills of  The City . Join your Travel Director and fellow travellers for a Welcome Reception at your hotel.Welcome Reception <br/>From the iconic to the unexpected, the city of San Francisco never ceases to surprise. Kick-start your effortlessly delivered Northern California holiday in the cosmopolitan hills of  The City . Join your Travel Director and fellow travellers for a Welcome Reception at your hotel.Welcome Reception<br/>
    From the iconic to the unexpected, the city of San Francisco never ceases to surprise. Kick-start your effortlessly delivered Northern California holiday in the cosmopolitan hills of  The City . Join your Travel Director and fellow travellers for a Welcome Reception at your hotel.Welcome Reception',
            'status' => "publish",
            'cat_id' => rand(1, 4),
            'image_id' => $news_image['img_2'],
            'create_user' => '1',
            'author_id' => '1',
            'created_at' =>  date("Y-m-d H:i:s")
        ]);
        DB::table('core_news')->insert([
            'title' => '10 European ski destinations you should visit this winter',
            'slug' => Str::slug('10 European ski destinations you should visit this winter', '-'),
            'content' => ' From the iconic to the unexpected, the city of San Francisco never ceases to surprise. Kick-start your effortlessly delivered Northern California holiday in the cosmopolitan hills of  The City . Join your Travel Director and fellow travellers for a Welcome Reception at your hotel.Welcome Reception  From the iconic to the unexpected, the city of San Francisco never ceases to surprise. Kick-start your effortlessly delivered Northern California holiday in the cosmopolitan hills of  The City . Join your Travel Director and fellow travellers for a Welcome Reception at your hotel.Welcome Reception <br/>From the iconic to the unexpected, the city of San Francisco never ceases to surprise. Kick-start your effortlessly delivered Northern California holiday in the cosmopolitan hills of  The City . Join your Travel Director and fellow travellers for a Welcome Reception at your hotel.Welcome Reception<br/>
    From the iconic to the unexpected, the city of San Francisco never ceases to surprise. Kick-start your effortlessly delivered Northern California holiday in the cosmopolitan hills of  The City . Join your Travel Director and fellow travellers for a Welcome Reception at your hotel.Welcome Reception',
            'status' => "publish",
            'cat_id' => rand(1, 4),
            'image_id' => $news_image['img_1'],
            'create_user' => '1',
            'author_id' => '1',
            'created_at' =>  date("Y-m-d H:i:s")
        ]);
    }
}
