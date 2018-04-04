<?php

namespace App;

use DateTime;
use App\Setting;
use App\Attendance;
use App\ContractType;
use App\EmployeeVacation;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'name_title',
        'client_id',
        'avatar',
        'birth',
        'email',
        'password',
        'nation',
        'state',
        'department',
        'emergency_contact',
        'social_number',
        'contract_type',
        'personal_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function encode_date_format($date)
    {
        $selectedDate = DateTime::createFromFormat('Y-m-d', $date);
        $finalDate = $selectedDate->format('m/d/Y');
        return $finalDate;
    }

    public function getContractEndtime()
    {
        $employee_contract_type = ContractType::find($this->contract_type);
        $total_work_time = $employee_contract_type->working_time;

        $timestamp = strtotime('08:00:00') + $total_work_time*60;

        $time = date('H:i:s', $timestamp);
        return date( "g:i A", strtotime($time));
    }

    public function checkVacation()
    {
        // $employee_contract_type = ContractType::find($this->contract_type);
        // $isVacation = $employee_contract_type->isvacation;
        // if ($isVacation == 0) {
        //     return 0;
        // }
        // if ($this->join_date == null || $this->join_date == "") {
        //     return 0;
        // }
        // $joinDate=date_create($this->join_date);
        // $todayDate = date('Y-m-d');
        // $today = date_create($todayDate);
        // $total_dates = date_diff($joinDate, $today);
        // if ($total_dates->days < 60) {
        //     return 0;
        // }
        //
        // $setting = Setting::first();
        // $total_vacation_week = $setting->vacation_week;
        // $total_vacation_date = $total_vacation_week*7;
        // $working_minutes_per_day = $employee_contract_type->working_time;
        // $total_vacation_minutes = $total_vacation_date*$working_minutes_per_day;
        //
        // $attendance_vacations = Attendance::where('employee_id', $this->id)->whereIn('attend_type', array(3,4))->get();
        //
        // $spent_vacation_minutes
        //
        // return $total_vacation_minutes;
    }
}
