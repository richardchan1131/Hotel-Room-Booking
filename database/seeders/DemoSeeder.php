<?php

namespace Database\Seeders;

use Database\Seeders\Demo\DemoUserSeeder;
use Database\Seeders\Demo\SupportSeeder;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DemoUserSeeder::class);
        $this->call(SupportSeeder::class);
    }
}
