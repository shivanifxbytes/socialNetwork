<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Friendship;
use Session;
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
        $data['user_profile_image'] = $this->dashboardObj->viewUserProfile($user_id);
        return view('user.welcome', $data);
    }

    /**
    * @DateOfCreation         10 September 2018
    * @ShortDescription       Insert user profile picture.
    * @return                 Redirect Response
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
            $users = $this->dashboardObj->viewUserProfile($user_id);
            if (count($users)>0) {
                $this->dashboardObj->updateUserProfilePicture($user_id, $fileName);
                return redirect('welcome')->with(['success'=>'friend request successfully sent']);
            } 
            else {
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
        $data['users_profile_data'] = Friendship::selectAsArray('user_profiles', ['user_id','profile_picture']);
        $data['friendship_records'] = Friendship::selectAsArray('friendship', ['sender_id','recipient_id','status'], ['sender_id'=>$id]);
        return view('user.viewAllFriendlist', $data);
    }

    /**
    * @DateOfCreation         11 September 2018
    * @ShortDescription       Inserting a new Friend request.
                              Friend request sent by sender to recipient.
    * @return                 Redirect Response
    */
    public function addFriend($recipient)
    {
       /* $senderId = Auth::user()->id;
        $recipient = $recipient;

        $insert= Friendship::insert('friendship', ['sender_id'=>$senderId,'recipient_id'=>$recipient]);
        return redirect('friendlist')->with(['success'=>'friend request successfully sent','code'=>'1','id'=>$recipient]);

*/
         $sender_id = Auth::user()->id;
        $recipient_id = $recipient;
        $friendship_records = Friendship::select('friendship', ['sender_id','recipient_id','status'], ['sender_id'=>$sender_id,'recipient_id'=>$recipient_id]);
        if (count($friendship_records) == 0) {
            Friendship::insert('friendship', ['sender_id'=>$sender_id,'recipient_id'=>$recipient_id]);
            return redirect('findFriend')->with(['success'=>'friend request successfully sent']);
        } else {
            foreach ($friendship_records as $key) {
                # code...
                $status = $key->status;
            }
            if ($status != 0) {
                $update = Friendship::update('friendship', ['status'=>0], ['sender_id'=>$sender_id,'recipient_id'=>$recipient_id]);
                return redirect('findFriend')->with(['success'=>'friend request successfully sent','code'=>'1','id'=>$recipient_id]);
            }
        }
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
    * @return                Redirect Response
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

     /**
     * @DateOfCreation         11 September 2018
     * @ShortDescription       Destroy the session and Make the Auth Logout
     * @return                 Response
     */
    public function getLogout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }
}
