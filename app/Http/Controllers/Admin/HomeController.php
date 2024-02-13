<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use App\Models\Product;
use App\Models\Order;
use App\Models\Enquiry;
use Auth;
use App;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DB;
use App\Models\Helpers\CommonHelper;

class HomeController extends Controller
{
    use CommonHelper;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request){
      $user = auth()->user();
      $total_products  = Product::where(['status'=>'active'])->count();
      $products = Product::where('status','active')->get();
      return view('admin.dashboard.admin',compact('total_products', 'products'));
    }
}
