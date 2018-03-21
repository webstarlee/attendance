<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractType extends Model
{
  protected $table = 'contract_types';

  public $timestamps = false;

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'title',
    'description',
  ];

  /**
  * The attributes excluded from the model's JSON form.
  *
  * @var array
  */
  protected $hidden = [];
}
