<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Rocky Foroutan';
        $user->email = 'rocky@lenderhomepage.com';
        $user->password = bcrypt('secret');
        $user->save();


        factory(App\User::class, 5)->create();

    }
}
