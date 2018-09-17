<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Config;
use App\Mail\VerifyMail;
use App\VerifyUser;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
    * @DateOfCreation         14 September 2018
    * @ShortDescription       view user registration from
    * @return                 View
    */
    public function register()
    {
        return view('user.register');
    }

    /**
    * @DateOfCreation         14 September 2018
    * @ShortDescription       Register user from user side and send verification link
    * @return                 View
    */
    public function userRegister(Request $request)
    {
        $rules = array(
                    'user_first_name' => 'required|max:50',
                    'user_last_name'  => 'required|max:50',
                    'user_email'      => 'required|string|email|max:255|unique:users',
                    'password'        => 'required|string|min:6|confirmed'
                );
        // set validator
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        } else {
            if (empty($id)) {
                $insertData = array(
                                    'user_first_name' => $request->input('user_first_name'),
                                    'user_last_name'  => $request->input('user_last_name'),
                                    'user_email'      => $request->input('user_email'),
                                    'password'        => bcrypt($request->input("password")),
                                    'user_role_id'    => Config::get('constants.USER_ROLE')
                                );
                $user = User::create($insertData);
                $verifyUser = VerifyUser::create([
                                    'user_id' => $user->id,
                                    'token'   => str_random(40)
                                ]);
                Mail::to($user->user_email)->send(new VerifyMail($user));
                // return $user;
                if($response = $this->registered($request,$user))
           {
            return $response;
           }
            }
        }
    }

    /**
       * @DateOfCreation         17 September 2018
       * @ShortDescription       Verify user method accepts a token from the url. 
       *                         It confirms that the user exists and is not verified yet 
       *                         And then goes ahead and changes the verification status in the database.
       * @return                 View
       */
    public function verifyUser($token)
    {
        $verifyUser = VerifyUser::where('token', $token)->first();
        if (isset($verifyUser)) {
            $user = $verifyUser->user;
            if (!$user->verified) {
                $verifyUser->user->verified = 1;
                $verifyUser->user->save();
                $status = "Your e-mail is verified. You can now login.";
            } else {
                $status = "Your e-mail is already verified. You can now login.";
            }
        } else {
            return redirect('/')->with('warning', "Sorry your email cannot be identified.");
        }
        return redirect('/')->with('status', $status);
    }

    /**
    * @DateOfCreation         17 September 2018
    * @ShortDescription       Registered method is executed just after the user is registered into the application.
    * @return                 View
    */
    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();
        return redirect('/register')->with('status', 'We sent you an activation code. Check your email and click on the link to verify.');
    }
}
