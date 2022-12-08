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
            $k = 0;
            for ($i = 20; $i <= 41; $i++){
                DB::table('tbl_role')->insert([
                    'poster_id' => 48,
                    'actor_id' => $i,
                    'role' => $faker->name,
                    'position' => ++$k,
                ]);
            }



    }
}
