<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Config;
use Hootlex\Friendships\Traits\Friendable;
class User extends Authenticatable
{
    use Notifiable;
        use Friendable;
    /**
     *@ShortDescription Table for the users.
     *
     * @var String
     */
    protected $table = 'users';
    //protected $table = 'user_profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_first_name','user_last_name','user_role_id','user_status','user_email', 'password','user_created_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_password','remember_token',
    ];

     /**
    * @DateOfCreation         07 Sep 2018
    * @ShortDescription       Load the dashboard view 
    * @return                 View
    */
    public function queryData($id){

    return User::where('user_role_id', '!=' , Config::get('constants.ADMIN_ROLE'))->where('id', '!=' , $id)->get();
   }
}
