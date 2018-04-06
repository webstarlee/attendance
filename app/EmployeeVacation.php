<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeVacation extends Model
{
    protected $table = 'employee_vacations';

    public $timestamps = false;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
      'employee_id',
      'vac_year',
      'vac_total_min',
      'vac_extra_min',
      'vac_spend_min',
    ];

    /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
    protected $hidden = [];
}
