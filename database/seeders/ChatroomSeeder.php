<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chatroom;

class ChatroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $chatroom = Chatroom::create([
            'name' => 'testChat'
        ]);
    }
}
