<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    public $timestamps = false;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
      'company_id',
      'app_name',
      'logo_img',
      'logo_fav',
    ];

    /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
    protected $hidden = [];

    public function time_format($time)
    {
        return date( "g:i A", strtotime($time));
    }
    public function time_format2($time)
    {
        return date( "H:i:s", strtotime($time));
    }
}
