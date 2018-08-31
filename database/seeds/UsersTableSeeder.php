<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Ivanov Ivan Ivanovich',
                'photo' => '3.jpg',
                'sociability' => rand(0,10),
                'engineering_skill' => rand(0,10),
                'time_management' => rand(0,10),
                'knowledge_of_languages' => rand(0,10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Petrov Petro Petrovich',
                'photo' => '1.jpg',
                'sociability' => rand(0,10),
                'engineering_skill' => rand(0,10),
                'time_management' => rand(0,10),
                'knowledge_of_languages' => rand(0,10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Sidorov Sidor Sidorovich',
                'photo' => '2.jpg',
                'sociability' => rand(0,10),
                'engineering_skill' => rand(0,10),
                'time_management' => rand(0,10),
                'knowledge_of_languages' => rand(0,10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
