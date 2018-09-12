<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\User;
use Config;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
    * @DateOfCreation         06 sep 2018
    * @ShortDescription       Load the login view for admin
    * @return                 View
    */
    public function getLogin()
    {
        return view('user.login');
    } 
    
    /**
    * @DateOfCreation         06 sep 2018
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
}
