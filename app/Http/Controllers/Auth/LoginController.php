<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\User;
use Config;
use App;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

     /**
    * @DateOfCreation         06 September 2018
    * @ShortDescription       Load the login view for admin
    * @return                 View
    */
    public function getLogin()
    {
        return view('user.login');
    }
    
     /**
    * @DateOfCreation         06 September 2018
    * @ShortDescription       Load the login view for admin
    * @return                 View
    */
    public function postLogin(Request $request)
    {
        $rules = array(
            'email' => 'required',
            'password' => 'required'
        );
        // set validator
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        } else {
            // Get our login input
            $inputData = array(
                'user_email' => $request->input('email'),
                'password' => $request->input('password')
            );
            if (Auth::attempt($inputData)) {                
                    $role_id =  Auth::user()->user_role_id;
                if ($role_id == Config::get('constants.USER_ROLE')) {
                    return redirect("/welcome")->with(array("message"=>__('messages.login_success')));
                } else {
                    return redirect()->back()->withInput()->withErrors(__('messages.account_not_exist'));
                }
                                         
            } else {
                //Check Email exist in the database or not
                if (User::where('user_email', '=', $inputData['user_email'])->first()) {
                    $validator->getMessageBag()->add('password', __('messages.wrong_password'));
                } else {
                    $validator->getMessageBag()->add('email', __('messages.account_not_exist'));
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
    }

    /**
    * @DateOfCreation         17 September 2018
    * @ShortDescription       Authenticated method is executed just after the user is authenticated.
    *                         We will override this and will use this to check if user is activated.
    * @return                 View
    */
 public function authenticated(Request $request, $user)
    {
        if (!$user->verified) {
            auth()->logout();
            return back()->with('warning', 'You need to confirm your account. We have sent you an activation code, please check your email.');
        }
        return redirect()->intended($this->redirectPath());
    }
}
