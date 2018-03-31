<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendParentalLeave extends Model
{
    protected $table = 'attend_parental_leaves';

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
    ];

    /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
    protected $hidden = [];
}
