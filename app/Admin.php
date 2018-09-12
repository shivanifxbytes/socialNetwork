<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Admin extends Model
{
    use Notifiable;
    
    /**
     *@ShortDescription Table for the users.
     *
     * @var String
     */
    protected $table = 'users';
   // protected $table = 'user_maintenance';
    /**
     *@ShortDescription  The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_first_name','user_last_name','user_role_id','user_status','user_email', 'password','user_created_at',
    ];
    /**
     *@ShortDescription The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_password','remember_token',
    ];
    
  
    /**
     *@ShortDescription Override the primary key in the table.
     *
     * @var string
     */
 //   protected $primaryKey = 'user_id';
}
