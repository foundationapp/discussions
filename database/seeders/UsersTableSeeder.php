<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'created_at' => '2023-04-14 19:20:25',
                'email' => 'richard@piedpiper.com',
                'email_verified_at' => NULL,
                'id' => 1,
                'name' => 'Richard Hendricks',
                'password' => '$2y$10$mBbvcrBoMT.BFB.lJMkpGecz4LxJ.H0JNdOCLmkKz/caLbbz4M8Aa',
                'remember_token' => 'g1xvuHyp0dbJW1ZdNvzjA4Fasi1s890rT2vT7ZGq1VkbqamwWHlxIG4exhz0',
                'updated_at' => '2023-04-27 16:47:55',
            ),
            1 => 
            array (
                'created_at' => '2023-04-14 19:27:51',
                'email' => 'gilfoyle@piedpiper.com',
                'email_verified_at' => NULL,
                'id' => 2,
                'name' => 'Bertram Gilfoyle',
                'password' => '$2y$10$CqQ5W1zJpc3GxpPkkxQV1.0m798oYC9dFnqli3O1v/Pkgf9fxWdVe',
                'remember_token' => 'UeJIQ5FOFzMQY7qfgC6iQpARu07qUbBZDelPBXSeErV1iuQf4fZ3RIsdfCIe',
                'updated_at' => '2023-04-27 16:47:55',
            ),
            2 => 
            array (
                'created_at' => '2023-04-27 16:53:54',
                'email' => 'erlich@piedpiper.com',
                'email_verified_at' => NULL,
                'id' => 3,
                'name' => 'Erlich Bachman',
                'password' => '$2y$10$is9YGYvNLktfAfohZBWo4.kT04wIPDtNK0vF4ysJ/rJMuiKIfiftK',
                'remember_token' => 'RsOPGiJjRZpuGCo1KDfjy5yOsCgCjxbW9ZMfrqAST8cKy5l4NU3Yaa2kBAcl',
                'updated_at' => '2023-04-27 16:53:54',
            ),
        ));
        
        
    }
}