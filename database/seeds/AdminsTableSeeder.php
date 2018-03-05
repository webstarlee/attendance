<?php

use App\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::table('admins')->delete();

        $admins = [
            [
                'first_name' => 'Top',
                'last_name' => 'Admin',
                'username' => 'Super',
                'unique_id' => str_random(10),
                'name_title' => 'TA',
                'email' => 'admin@mail.com',
                'password' => bcrypt('secret'),
                'role' => '3',
                'nation' => '157',
                'remember_token' => str_random(10),
            ],
        ];

        foreach ($admins as $admin) {
            Admin::create($admin);
        }
        Model::reguard();
    }
}
