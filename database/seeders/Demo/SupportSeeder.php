<?php

namespace Database\Seeders\Demo;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SupportSeeder extends Seeder
{
    public function run()
    {
        if (!Schema::hasTable('bc_support_tickets')) return;

        $this->topics();
        $this->tickets();
    }

    public function topics()
    {
        if (!class_exists('\Modules\Support\Models\Topic')) return;
        $faker = fake();
        $cats = [];
        for ($i = 1; $i <= 5; $i++) {
            $cat = new \Modules\Support\Models\TopicCat([
                'status' => 'publish'
            ]);
            $cat->fillByAttr(['name'], ['name' => $faker->sentence()]);
            $cats[] = $cat->save();

            for ($k = 1; $k <= 6; $k++) {
                $topic = new \Modules\Support\Models\Topic([
                    'status' => 'publish'
                ]);
                $topic->fillByAttr(['title', 'cat_id', 'content'], ['title'   => $faker->sentence(),
                                                                    'cat_id'  => $cat->id,
                                                                    'content' => $faker->paragraph(5)]);
                $topic->save();
            }

        }

    }

    public function tickets()
    {
        if (!class_exists('\Modules\Support\Models\Ticket')) return;
        $faker = fake();
        $cats = [];
        for ($i = 1; $i <= 5; $i++) {
            $cat = new \Modules\Support\Models\TicketCat([
                'status' => 'publish'
            ]);
            $cat->fillByAttr(['name'], ['name' => $faker->sentence()]);
            $cats[] = $cat->save();

            for ($k = 1; $k <= 6; $k++) {
                $ticket = new \Modules\Support\Models\Ticket([
                    'status' => 'open'
                ]);
                $data = ['title'         => $faker->sentence(),
                         'cat_id'        => $cat->id,
                         'content'       => $faker->paragraph(5),
                         'customer_id'   => rand(1, 3),
                         'agent_id'      => rand(4, 6),
                         'last_reply_at' => date('Y-m-d H:i:s', strtotime('- 4 days'))
                ];
                $data['last_reply_by'] = $data['customer_id'];

                $ticket->fillByAttr(array_keys($data), $data);
                $ticket->save();
                for ($j = 1; $j <= 6; $j++) {
                    $reply = new \Modules\Support\Models\TicketReply([
                        'status' => 'publish'
                    ]);
                    $dataReply = [
                        'ticket_id' => $ticket->id,
                        'content'   => $faker->paragraph(5),
                        'user_id'   => [$data['customer_id'], $data['agent_id']][rand(0, 1)],
                    ];

                    $reply->fillByAttr(array_keys($dataReply), $dataReply);
                    $reply->save();
                }
            }

        }

    }
}
