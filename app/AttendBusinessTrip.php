<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendBusinessTrip extends Model
{
    protected $table = 'attend_business_trips';

    public $timestamps = false;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
      'attend_id',
      'start_date',
      'end_date',
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
