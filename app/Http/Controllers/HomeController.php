<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Friendship;
use Auth;
use App\User;
use DB;

class HomeController extends Controller
{

/**
* Create a new controller instance.
*
* @return void
*/
    public function __construct()
    {
        $this->dashboardObj = new User();
    }
    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $user_id =  Auth::user()->id;
        $data['user_profile_image'] = DB::table('user_profiles')->select('profile_picture', 'user_id')->get(); 
        return view('user.welcome', $data);
    }

    /**
    * @DateOfCreation         10 September 2018
    * @ShortDescription       Insert user profile picture.
    * @return                 View
    */
    public function upload_image(Request $request)
    {
        $user_id =  Auth::user()->id;

        request()->validate([ 'file' => 'required']);
        $fileName = request()->file('file')->getClientOriginalName();

        $fileMove= request()->file('file')->move(public_path('files'), $fileName);
        $insert_array = [
                            'profile_picture' => $fileName,
                            'user_id'         => $user_id
                        ];
        if (!empty($user_id)) {
            $users = DB::table('user_profiles')->select('profile_picture', 'user_id')->get();
            if (count($users)>0) {
                DB::table('user_profiles')
                ->where('user_id', '=', $user_id)
                ->update(['profile_picture' => $fileName]);
                return redirect('welcome')->with(['success'=>'friend request successfully sent']);
            } else {
                DB::table('user_profiles')->insert($insert_array);
                return redirect('welcome')->with(['success'=>'friend request successfully sent']);
            }
        } 

    }

    /**
    * @DateOfCreation         11 September 2018
    * @ShortDescription       Get the entire user request for the user from other users.
                              Let’s assume user with id 1is logged in.
    * @return                 View
    */
    public function viewFriendlist()
    {
        $this->dashboardObj = new Friendship();
        $id =  Auth::user()->id;
        $data['users'] = $this->dashboardObj->findFriendlist($id);
        return view('user.viewFriendlist', $data);
    }

    /**
    * @DateOfCreation         11 September 2018
    * @ShortDescription       Get the entire user request for the user from other users.
                              Let’s assume user with id 1is logged in.
    * @return                 View
    */
    public function viewAllFriendlist()
    {
        $id =  Auth::user()->id;
        $data['users'] = $this->dashboardObj->queryData($id);
        return view('user.viewAllFriendlist', $data);
    }

    /**
    * @DateOfCreation         11 September 2018
    * @ShortDescription       Inserting a new Friend request.
                              Friend request sent by sender to recipient.
    * @return                 View
    */
    public function addFriend($recipient)
    {
        $senderId = Auth::user()->id;
        $recipient = $recipient;
        $insert= Friendship::insert('friendship', ['sender_id'=>$senderId,'recipient_id'=>$recipient]);
        return redirect('friendlist')->with(['success'=>'friend request successfully sent','code'=>'1','id'=>$recipient]);
    }

    /**
    * @DateOfCreation         11 September 2018
    * @ShortDescription       Get the entire pending user request for the user from other users.
                              Let’s assume user with id 1is logged in.
    * @return                 View
    */
    public function viewFriendRequest()
    {
        $this->dashboardObj = new Friendship();
        $id =  Auth::user()->id;
        $data['users'] = $this->dashboardObj->friendRequest($id);
        return view('user.viewFriendRequest', $data);
    }

    /**
    * @DateOfCreation         11 September 2018
    * @ShortDescription       Updating the status of the friend request.
                              Accepting friend request sent to recipient by sender.
    * @return                 View
    */
    public function acceptFriendships($sender_id)
    {
        $sender_id = $sender_id;
        echo $sender_id;
        $this->dashboardObj = new Friendship();
        $receiver_id = Auth::user()->id;
        $pendingid = $this->dashboardObj->acceptPendingFriendships($receiver_id, $sender_id);
        return redirect('friendRequest')->with(['success'=>'friend request Accept successfully sent','code'=>'1','id'=>$sender_id]);
    }

    /**
    * @DateOfCreation        11 September 2018
    * @ShortDescription      Updating the status of the friend request.
                             Denied friend request sent to recipient by sender.
    * @return                View
    */
    public function deniedFriendship($sender_id)
    {
        $sender_id = $sender_id;
        echo $sender_id;
        $this->dashboardObj = new Friendship();
        $receiver_id = Auth::user()->id;
        $pendingid = $this->dashboardObj->deletePendingFriendships($receiver_id, $sender_id);
        return redirect('friendRequest')->with(['success'=>'friend request delete successfully sent','code'=>'1','id'=>$sender_id]);
    }
}
