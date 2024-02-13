<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Helpers\CommonHelper;

class HomeController extends Controller

{   use CommonHelper;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application home.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function web_index(){
        $title = "Home";
        echo $title;die;
    }


}
