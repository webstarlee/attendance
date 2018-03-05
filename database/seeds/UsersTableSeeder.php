<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::table('users')->delete();

        $users = [
            [
                'name' => 'Top',
                'email' => 'admin@mail.com',
                'password' => bcrypt('secret'),
                'remember_token' => str_random(10),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
        Model::reguard();
    }
}
