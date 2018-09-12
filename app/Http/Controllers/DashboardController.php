<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    /**
    * @DateOfCreation         06 Sep 2018
    * @ShortDescription       Load the dashboard view
    * @return                 View
    */
    public function index()
    {
        return view('admin.dashboard', compact('count'));
    }

}
