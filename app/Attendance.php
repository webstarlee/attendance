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
        if ($this->attend_type == 0) {
            return 0;
        }
        
        $labor_time = $this->get_between_min($this->start_time, $this->end_time);

        $smoke_time = 0;
        $break_time = 0;

        if ($this->breaks != null || $this->breaks != "") {
            $breaks = unserialize($this->breaks);
            foreach ($breaks as $break) {
                $break_time += $this->get_between_min($break['start_time'], $break['end_time']);
            }
        }

        if ($this->smokes != null || $this->smokes != "") {
            $smokings = unserialize($this->smokes);
            foreach ($smokings as $smoking) {
                $smoke_time += $this->get_between_min($smoking['start_time'], $smoking['end_time']);
            }
        }

        $real_working_minutes = $labor_time - $break_time - $smoke_time;

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
