<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DiscussionPostUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('discussions_users')->delete();

        \DB::table('discussions_users')->insert(array(
            0 =>
            array(
                'created_at' => '2023-04-27 12:24:06',
                'discussion_post_id' => 1,
                'id' => 1,
                'read' => 0,
                'updated_at' => '2023-04-27 12:24:06',
                'user_id' => 1,
            ),
            1 =>
            array(
                'created_at' => NULL,
                'discussion_post_id' => 3,
                'id' => 2,
                'read' => 0,
                'updated_at' => NULL,
                'user_id' => 3,
            ),
        ));
    }
}
