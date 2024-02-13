<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
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
