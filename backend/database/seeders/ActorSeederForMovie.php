<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ActorSeederForMovie extends Seeder
{



    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $limit = 10;

        for ($i = 0; $i < $limit; $i++) {
            DB::table('users')->insert([
                'full_name' => $faker->name,
                'phone' => '0' . mt_rand(1000000000, 9999999999),
                'email' => $faker->email,
                'username' => $faker->userName,
                'password' => bcrypt(123123),
            ]);
        }


    }
}
