<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendPresent extends Model
{
    protected $table = 'attend_presents';

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
      'arrival_time',
      'departure_time',
    ];

    /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
    protected $hidden = [];
}
