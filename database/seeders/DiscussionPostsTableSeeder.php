<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DiscussionPostsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('discussion_posts')->delete();
        
        \DB::table('discussion_posts')->insert(array (
            0 => 
            array (
                'content' => 'Absolutely not. They\'re distracting and annoying.',
                'created_at' => '2023-04-14 19:28:27',
                'deleted_at' => NULL,
                'discussion_id' => 1,
                'id' => 1,
                'updated_at' => '2023-04-14 20:06:53',
                'user_id' => 2,
            ),
            1 => 
            array (
                'content' => 'But think about it! They could add some liveliness to our conversations. We could use them to express our emotions.

![Animated Gif](https://cdn.devdojo.com/images/april2023/donatello.gif)',
                'created_at' => '2023-04-14 20:07:57',
                'deleted_at' => NULL,
                'discussion_id' => 1,
                'id' => 2,
                'updated_at' => '2023-04-14 20:11:54',
                'user_id' => 1,
            ),
            2 => 
            array (
                'content' => 'I don\'t need a cartoon character to tell me how to feel. And besides, have you seen some of those gifs? They\'re ridiculous.',
                'created_at' => '2023-04-14 20:12:58',
                'deleted_at' => NULL,
                'discussion_id' => 1,
                'id' => 3,
                'updated_at' => '2023-04-14 20:12:58',
                'user_id' => 2,
            ),
            3 => 
            array (
                'content' => 'That\'s the point! They\'re supposed to be funny. We could use them to lighten the mood around here. Fun can actually increase productivity. When people are happy, they work better.',
                'created_at' => '2023-04-14 20:13:44',
                'deleted_at' => NULL,
                'discussion_id' => 1,
                'id' => 4,
                'updated_at' => '2023-04-14 20:13:55',
                'user_id' => 1,
            ),
            4 => 
            array (
                'content' => 'I don\'t buy it. Animated gifs are just a waste of time.',
                'created_at' => '2023-04-14 20:14:21',
                'deleted_at' => NULL,
                'discussion_id' => 1,
                'id' => 5,
                'updated_at' => '2023-04-14 20:14:21',
                'user_id' => 2,
            ),
            5 => 
            array (
                'content' => 'You\'re such a buzzkill, Gilfoyle. Can\'t you see the upside here?',
                'created_at' => '2023-04-14 20:14:44',
                'deleted_at' => NULL,
                'discussion_id' => 1,
                'id' => 6,
                'updated_at' => '2023-04-14 20:14:44',
                'user_id' => 1,
            ),
            6 => 
            array (
                'content' => 'No, I don\'t see an upside to chaos and madness. People will start sending gifs left and right, and we won\'t get anything done.',
                'created_at' => '2023-04-14 20:15:25',
                'deleted_at' => NULL,
                'discussion_id' => 1,
                'id' => 7,
                'updated_at' => '2023-04-14 20:15:42',
                'user_id' => 2,
            ),
            7 => 
            array (
                'content' => 'That\'s a risk I\'m willing to take. I think we should put it to a vote.',
                'created_at' => '2023-04-14 20:15:58',
                'deleted_at' => NULL,
                'discussion_id' => 1,
                'id' => 8,
                'updated_at' => '2023-04-14 20:15:58',
                'user_id' => 1,
            ),
            8 => 
            array (
                'content' => 'Fine. But I\'m warning you, Richard. If this goes through, I\'m leaving Slack and going back to IRC.',
                'created_at' => '2023-04-14 20:16:41',
                'deleted_at' => NULL,
                'discussion_id' => 1,
                'id' => 9,
                'updated_at' => '2023-04-14 20:16:41',
                'user_id' => 2,
            ),
            9 => 
            array (
                'content' => 'We\'ll cross that bridge when we come to it. In the meantime, let\'s rally the troops and see if we can\'t get some gifs in here!

![Excited Gif](https://cdn.devdojo.com/images/april2023/richard.gif)',
                'created_at' => '2023-04-14 20:18:57',
                'deleted_at' => NULL,
                'discussion_id' => 1,
                'id' => 10,
                'updated_at' => '2023-04-14 20:18:57',
                'user_id' => 1,
            ),
            10 => 
            array (
            'content' => '![Congratulations](https://cdn.devdojo.com/images/april2023/gilfoyle.gif)',
                'created_at' => '2023-04-14 20:20:46',
                'deleted_at' => NULL,
                'discussion_id' => 1,
                'id' => 11,
                'updated_at' => '2023-04-14 20:20:46',
                'user_id' => 2,
            ),
            11 => 
            array (
                'content' => 'I Call Dibs!',
                'created_at' => '2023-04-27 23:29:21',
                'deleted_at' => NULL,
                'discussion_id' => 3,
                'id' => 13,
                'updated_at' => '2023-04-27 23:29:21',
                'user_id' => 3,
            ),
        ));
        
        
    }
}