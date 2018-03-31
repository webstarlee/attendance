<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendDoctor extends Model
{
    protected $table = 'attend_doctors';

    public $timestamps = false;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
      'attend_id',
      'doctor_date',
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