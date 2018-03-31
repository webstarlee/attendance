<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimingSheet extends Model
{
    protected $table = 'timing_sheets';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
      'pro_id',
      'employee_id',
      'sheet_date',
      'work_time',
    ];

    /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
    protected $hidden = [];
}
