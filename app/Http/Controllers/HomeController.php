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
        return view('user.welcome');
    }
    
    /**
    * @DateOfCreation         10 Sep 2018
    * @ShortDescription       Insert user profile pic.
    * @return                 View
    */
    public function image(Request $request)
    {
        $user_id =  Auth::user()->id;
        request()->validate([ 'file' => 'required']);
        $fileName = request()->file('file')->getClientOriginalName();
        $fileMove= request()->file('file')->move(public_path('files'), $fileName);
        $insert_array = [ 'profile_picture'=>$fileName, 'user_id' => $user_id ];
         if (empty($user_id))
         {
            DB::table('user_profiles')->insert($insert_array);
         }
         else
         {
            /*echo "update";
            die();*/
         DB::table('user_profiles')
        ->where('user_id', '=', $user_id)
        ->update(['profile_picture' => $insert_array]);
         }
        
        $imagePath = public_path('/')."files/".$fileName;die;
        return view('user.welcome',['image' => $imagePath]);
       // return redirect()->back()->withInput()->with('success', 'image upload successfully.');
        //return view('user.welcome', $data);
    }
    public function viewImage()
    {
        echo "hello";
        die();
    }

    /**
    * @DateOfCreation         11 Sep 2018
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
    * @DateOfCreation         11 Sep 2018
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
    * @DateOfCreation         11 Sep 2018
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
    * @DateOfCreation         11 Sep 2018
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
    * @DateOfCreation         11 Sep 2018
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
    * @DateOfCreation        11 Sep 2018
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
