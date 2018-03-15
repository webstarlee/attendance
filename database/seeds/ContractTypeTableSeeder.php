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
        ['title' => 'Half-time', 'description' => '', 'color' => 'rgb(255, 0, 0)'],
        ['title' => 'Flexible working hours', 'description' => 'The company determines that employees should be in the workplace every day from 10am to 3pm. Where and how they work the rest is on them.', 'color' => 'rgb(197, 0, 255)'],
        ['title' => 'Shared workspace ', 'description' => 'The company is looking for a receptionist. We hire two half-time employees who alternate on the spot after two days of work.', 'color' => 'rgb(13, 0, 246)'],
        ['title' => 'Work from home', 'description' => 'homeoffice', 'color' => 'rgb(0, 230, 254)'],
        ['title' => 'Working Hours Account', 'description' => 'The employee does not work classically from Monday to Friday. His usual working days are from Monday to Sunday, with his uninterrupted weekly rest (weekend) falling on other days than Saturdays and Sundays.', 'color' => 'rgb(1, 254, 65)'],
        ['title' => 'Compressed working week', 'description' => 'By agreement, the five-day working week can be "compressed" within 4 days. Employees work from Monday to Thursday for 10 hours and leave on Friday.', 'color' => 'rgb(255, 181, 14)'],
      ];

      foreach ($types as $type) {
          ContractType::create($type);
      }
      Model::reguard();
    }
}
