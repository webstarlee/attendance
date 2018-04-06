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

    public function mVacation()
    {
        $current_year = date("Y");
        $mvacation = "";
        $vacation_count = EmployeeVacation::where('vac_year', $current_year)->where('employee_id', $this->unique_id)->count();
        if ($vacation_count > 0) {
            $mvacation = EmployeeVacation::where('vac_year', $current_year)->where('employee_id', $this->unique_id)->first();
        } else {
            $mvacation = new EmployeeVacation;
            $mvacation->employee_id = $this->unique_id;
            $mvacation->vac_year = $current_year;
            $mvacation->vac_total_min = 0;
            $mvacation->vac_extra_min = 0;
            $mvacation->vac_spend_min = 0;
            $mvacation->save();
        }

        $vac_total_min = $this->getTotalMin();

        $mvacation->vac_total_min = $vac_total_min;
        $mvacation->save();

        $last_year = date("Y",strtotime("-1 year"));
        $last_vacation = EmployeeVacation::where('vac_year', $last_year)->where('employee_id', $this->unique_id)->first();

        if ($last_vacation) {
            $left_min = $last_vacation->vac_total_min + $last_vacation->vac_extra_min - $last_vacation->vac_spend_min;
            $mvacation->vac_extra_min = $left_min;
            $mvacation->save();
        }
    }

    public function getTotalMin()
    {
        $employee_contract_type = ContractType::find($this->contract_type);
        $isVacation = $employee_contract_type->isvacation;
        if ($isVacation == 0) {
            return 0;
        }
        if ($this->join_date == null || $this->join_date == "") {
            return 0;
        }
        $joinDate=date_create($this->join_date);
        $todayDate = date('Y-m-d');
        $today = date_create($todayDate);
        $total_dates = date_diff($joinDate, $today);
        if ($total_dates->days < 60) {
            return 0;
        }

        $setting = Setting::first();
        $total_vacation_week = $setting->vacation_week;
        $total_vacation_date = $total_vacation_week*7;
        $working_minutes_per_day = $employee_contract_type->working_time;
        $total_vacation_minutes = $total_vacation_date*$working_minutes_per_day;

        return $total_vacation_minutes;
    }

    public function checkVacation($time1, $time2)
    {
        $cal_min = $this->calculate_time_minute($time1) - $this->calculate_time_minute($time2);
        $selected_min = abs($cal_min);
        $current_year = date("Y");
        $mvacation = EmployeeVacation::where('vac_year', $current_year)->where('employee_id', $this->unique_id)->first();
        $left_vac_min = $mvacation->vac_total_min + $mvacation->vac_extra_min - $mvacation->vac_spend_min;
        if ($selected_min > $left_vac_min) {
            return false;
        }
        return true;
    }

    public function calculate_time_minute($time)
    {
        $result_time_array = explode(':', $time);
        $result_time_hour = $result_time_array[0];
        $result_time_min = $result_time_array[1];
        $total_result_min = $result_time_hour*60 + $result_time_min;

        return $total_result_min;
    }
}
