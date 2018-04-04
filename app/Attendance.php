<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances';

    public $timestamps = false;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
      'employee_id',
      'attend_date',
    ];

    /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
    protected $hidden = [];

    public function generate_total_time()
    {
        $labor_time = $this->get_between_min($this->arrival_time, $this->departure_time);

        $break1_time = $this->get_between_min($this->break1_start, $this->break1_end);

        $break2_time = $this->get_between_min($this->break2_start, $this->break2_end);

        $smoking_time = 0;

        if ($this->smoking != null || $this->smoking != "") {
            $smokings = unserialize($this->smoking);
            foreach ($smokings as $smoking) {
                $smoking_time += $this->get_between_min($smoking['start_time'], $smoking['end_time']);
            }
        }

        $real_working_minutes = $labor_time - $break1_time - $break2_time - $smoking_time;

        return $real_working_minutes;
    }

    public function calculate_time_minute($time)
    {
        $result_time_array = explode(':', $time);
        $result_time_hour = $result_time_array[0];
        $result_time_min = $result_time_array[1];
        $total_result_min = $result_time_hour*60 + $result_time_min;

        return $total_result_min;
    }

    public function get_between_min($time1, $time2)
    {
        $cal_min = $this->calculate_time_minute($time1) - $this->calculate_time_minute($time2);
        return abs($cal_min);
    }
}
