<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DiscussionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('discussions')->delete();
        
        \DB::table('discussions')->insert(array (
            0 => 
            array (
                'category_id' => NULL,
                'content' => 'Hello Team,

I wanted to reach out to everyone to get your thoughts on whether we should allow the use of animated GIFs in our Slack messages. I know that there have been a few concerns raised about the use of GIFs in the past, and I want to make sure that we\'re all on the same page.

If you have any thoughts or opinions on this topic, please feel free to share them with me and the rest of the team. We can discuss the pros and cons and come to a decision together.',
                'created_at' => '2023-04-14 19:23:50',
                'deleted_at' => NULL,
                'id' => 1,
                'locked' => 0,
                'pinned' => 0,
                'private' => 0,
                'slug' => 'animated-gifs-in-chat',
                'title' => 'Animated GIFs in Chat',
                'updated_at' => '2023-04-14 19:23:50',
                'user_id' => 1,
            ),
            1 => 
            array (
                'category_id' => NULL,
                'content' => 'Hey team.

This is a quick update. Wanted to let you know we have just released the PiedPiper API version 2.0. This is a big step forward in helping our business grow and gain developer advocacy for years to come.

Excited to see how people like the new API

Good things to come!',
                'created_at' => '2023-04-27 16:42:09',
                'deleted_at' => NULL,
                'id' => 2,
                'locked' => 0,
                'pinned' => 0,
                'private' => 0,
                'slug' => 'releasing-new-version-of-pied-piper',
                'title' => 'Releasing New Version of Pied Piper',
                'updated_at' => '2023-04-27 16:42:09',
                'user_id' => 1,
            ),
            2 => 
            array (
                'category_id' => NULL,
                'content' => 'Attention, denizens of this domain, let it be known that the hour grows late and the workday draws to a close. Furthermore, it is my pleasure to inform you that there remains a surplus of cold, frothy libations within the confines of our icebox. My cohorts and I failed to fully deplete our supply, and so we offer it up to any and all who seek to imbibe over the forthcoming weekend. Please, do not hesitate to claim this bounty for yourselves, for it shall not remain unclaimed for long.',
                'created_at' => '2023-04-27 16:52:37',
                'deleted_at' => NULL,
                'id' => 3,
                'locked' => 0,
                'pinned' => 0,
                'private' => 0,
                'slug' => 'extra-6-pack-in-the-fridge',
                'title' => 'Extra 6-Pack in the Fridge 🍻',
                'updated_at' => '2023-04-27 16:52:37',
                'user_id' => 2,
            ),
        ));
        
        
    }
}