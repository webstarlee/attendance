<?php

namespace App;

use DateTime;
use \App\Country;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = "admin";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
         'first_name',
         'last_name',
         'username',
         'unique_id',
         'name_title',
         'avatar',
         'birth',
         'email',
         'password',
         'role',
         'nation',
         'state',
         'department',
         'emergency_contact',
         'social_number',
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

     // public function sendPasswordResetNotification($token)
     // {
     //     // Your your own implementation.
     //     $this->notify(new ResetPasswordNotification($token));
     // }

     public function getCountry() {
         $country = Country::find($this->nation);
         return $country;
     }

     public function getRole() {
         $user_role = "HR/Accountant";
         if ($this->role == 3) {
             $user_role = "Super Admin";
         } elseif ($this->role == 2) {
             $user_role = "CEO";
         } elseif ($this->role == 1) {
             $user_role = "superior";
         }
         return $user_role;
     }

     public function checkEditable($admin) {
         $result = false;
         if ($this->role == 3) {
             $result = true;
         }

         if ($this->id == $admin->id) {
             $result = true;
         }

         if ($this->role > $admin->role) {
             $result = true;
         }
         return $result;
     }

     public function getRolearray() {
         $final_role = array();
         if ($this->role == 3) {
             $final_role = array(
                 array("id" => 3, "name" => "Super Admin"),
                 array("id" => 2, "name" => "CEO"),
                 array("id" => 1, "name" => "Superior"),
                 array("id" => 0, "name" => "HR/Acountant"),
             );
         } elseif ($this->role == 2) {
             $final_role = array(
                 array("id" => 2, "name" => "CEO"),
                 array("id" => 1, "name" => "Superior"),
                 array("id" => 0, "name" => "HR/Acountant"),
             );
         } elseif ($this->role == 1) {
             $final_role = array(
                 array("id" => 1, "name" => "Superior"),
                 array("id" => 0, "name" => "HR/Acountant"),
             );
         } else {
             $final_role = array(
                 array("id" => 0, "name" => "HR/Acountant"),
             );
         }

         return $final_role;
     }
}
