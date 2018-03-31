<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendAbsence extends Model
{
    protected $table = 'attend_absences';

    public $timestamps = false;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
      'attend_id',
      'absence_date',
    ];

    /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
    protected $hidden = [];
}
