<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Config;

class Friendship extends Model
{
    use Notifiable;
       
    /**
     *@ShortDescription Table for the users.
     *
     * @var String
     */
    protected $table = 'friendship';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'sender_id','recipient_id','status', 'updated_at','created_at',
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
     * @DateOfCreation       11 Sep 2018
     * @DateOfDeprecated
     * @ShortDescription     This function insert the specified data into table
     * @LongDescription
     * @param  string $table_name
     * @param  array  $insert_array
     * @return void
     */
    public static function insert($table_name = '', $insert_array = [])
    {
        return DB::table($table_name)->insertGetId($insert_array);
    }

    /**
    * @DateOfCreation         11 Sep 2018
    * @ShortDescription       Get the entire pending user request for the user from other users.
                              Let’s assume user with id 1is logged in.
    * @return                 View
    */
    public function friendRequest($id)
    {
        return  DB::table('friendship')
                ->join('users', 'friendship.sender_id', '=', 'users.id')
                ->select(array('users.id','friendship.recipient_id','users.user_first_name','users.user_last_name'))
                ->where('status', '=', Config::get('constants.PENDING'))
                ->where('recipient_id', '=', $id)
                ->get();
    }

    /**
    * @DateOfCreation         11 Sep 2018
    * @ShortDescription       Updating the status of the friend request.
                              Accepting friend request sent to recipient by sender.
    * @return                 View
    */
    public function acceptPendingFriendships($recipient_id, $sender_id)
    {
        return DB::table('friendship')
        ->where('sender_id', '=', $sender_id)
        ->where('recipient_id', '=', $recipient_id)
        ->update(['status' => Config::get('constants.ACCEPTED')]);
    }

    /**
    * @DateOfCreation        11 Sep 2018
    * @ShortDescription      Updating the status of the friend request.
                             Denied friend request sent to recipient by sender.
    * @return                View
    */
    public function deletePendingFriendships($recipient_id, $sender_id)
    {
        return DB::table('friendship')
        ->where('sender_id', '=', $sender_id)
        ->where('recipient_id', '=', $recipient_id)
        ->update(['status' => Config::get('constants.DENIED')]);
    }


    /**
    * @DateOfCreation         12 Sep 2018
    * @ShortDescription       Get the entire pending user request for the user from other users.
                              Let’s assume user with id 1is logged in.
    * @return                 View
    */
    public function findFriendlist($id)
    {
        return  DB::table('friendship')
                ->join('users', 'friendship.sender_id', '=', 'users.id')
                ->select(array('users.id','friendship.recipient_id','users.user_first_name','users.user_last_name'))
                ->where('status', '=', Config::get('constants.ACCEPTED'))
                ->where('recipient_id', '=', $id)
                ->get();
    }

     /**
    * @DateOfCreation        12 Sep 2018
    * @ShortDescription      Updating the image of the user profile.
    * @return                View
    */
   /* public function deletePendingFriendships($recipient_id, $sender_id)
    {
        return DB::table('friendship')
        ->where('sender_id', '=', $sender_id)
        ->where('recipient_id', '=', $recipient_id)
        ->update(['status' => Config::get('constants.DENIED')]);
    }*/


}
