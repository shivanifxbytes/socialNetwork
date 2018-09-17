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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_first_name','user_last_name','user_role_id','verified','user_email', 'password','user_created_at',
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
    *@return [object]         [StdClass result object]
    */
    public function queryData($id)
    {
        return User::where('user_role_id', '!=', Config::get('constants.ADMIN_ROLE'))->where('id', '!=', $id)->get();
    }


    /**
     * @DateOfCreation         12 September 2018
     * @ShortDescription
     *@return [object]         [StdClass result object]
     */
    public function viewUserProfile($user_id)
    {
        return DB::table('user_profiles')->select('profile_picture', 'user_id')->where('user_id', $user_id)->get();
    }

    /**
     * @DateOfCreation         12 September 2018
     * @ShortDescription
     *@return [object]         [StdClass result object]
     */
    public function updateUserProfilePicture($user_id, $fileName)
    {
        return DB::table('user_profiles')
                ->where('user_id', '=', $user_id)
                ->update(['profile_picture' => $fileName]);
    }

    /**
    * @DateOfCreation         17 September 2018
    * @ShortDescription
    *@return [object]         [StdClass result object]
    */
    public function getStatus($user_id)
    {
        return DB::table('users')->select('user_status', 'user_id')->where('user_id', $user_id)->get();
    }
   
    /**
    * @DateOfCreation         17 September 2018
    * @ShortDescription
    *@return [object]         [StdClass result object]
    */
    public function verifyUser()
    {
        return $this->hasOne('App\VerifyUser');
    }
}
