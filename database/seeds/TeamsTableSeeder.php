<?php

use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Team::class, 10)->create()->each(function ($team) {
            $team->players()->saveMany(factory(App\Player::class, 12)->make());
        });
    }
}
