<?php

namespace App;

use DateTime;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'name_title',
        'client_id',
        'avatar',
        'birth',
        'email',
        'password',
        'nation',
        'state',
        'department',
        'emergency_contact',
        'social_number',
        'contract_type',
        'personal_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function encode_date_format($date)
    {
        $selectedDate = DateTime::createFromFormat('Y-m-d', $date);
        $finalDate = $selectedDate->format('m/d/Y');
        return $finalDate;
    }
}
