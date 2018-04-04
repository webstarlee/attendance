<?php

use App\ContractType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class ContractTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Model::unguard();
      DB::table('contract_types')->delete();

      $types = [
        ['title' => 'Half-time', 'isvacation' => '1', 'working_time' => '30', 'description' => ''],
        ['title' => 'Flexible working hours', 'isvacation' => '1', 'working_time' => '30', 'description' => 'The company determines that employees should be in the workplace every day from 10am to 3pm. Where and how they work the rest is on them.'],
        ['title' => 'Shared workspace ', 'isvacation' => '1', 'working_time' => '30', 'description' => 'The company is looking for a receptionist. We hire two half-time employees who alternate on the spot after two days of work.'],
        ['title' => 'Work from home', 'isvacation' => '1', 'working_time' => '30', 'description' => 'homeoffice'],
        ['title' => 'Working Hours Account', 'isvacation' => '1', 'working_time' => '30', 'description' => 'The employee does not work classically from Monday to Friday. His usual working days are from Monday to Sunday, with his uninterrupted weekly rest (weekend) falling on other days than Saturdays and Sundays.'],
        ['title' => 'Compressed working week', 'isvacation' => '1', 'working_time' => '30', 'description' => 'By agreement, the five-day working week can be "compressed" within 4 days. Employees work from Monday to Thursday for 10 hours and leave on Friday.'],
      ];

      foreach ($types as $type) {
          ContractType::create($type);
      }
      Model::reguard();
    }
}
