<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use App\Models\SmsVerification;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        // die;
        return view('welcome');
    }    
    public function showOtp($number){
        $data = SmsVerification::where('mobile_number',$number)->where('status','pending')->first();
        echo 'OTP is :'.$data->code;
    }
}