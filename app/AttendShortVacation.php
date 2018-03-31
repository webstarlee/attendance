<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendShortVacation extends Model
{
    protected $table = 'attend_short_vacations';

    public $timestamps = false;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
      'attend_id',
      'vacation_date',
      'start_time',
      'end_time',
    ];

    /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
    protected $hidden = [];
}
