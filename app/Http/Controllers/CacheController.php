<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class CacheController extends Controller
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
    public function clear_cache()
    {
      Artisan::call('cache:clear');
      Artisan::call('config:clear');
      Artisan::call('config:cache');
      Artisan::call('route:clear');
      Artisan::call('route:cache');
      Artisan::call('view:clear');
      Artisan::call('view:cache');
      Artisan::call('optimize:clear');
      session()->forget('order_id');
      return "Application Cache is cleared"; 
    }

    public function rnd() {

        // $a = ['furnished', 'semi&nbsp;furnished', 'un furnished'];
        // dd(in_array('semi&nbsp;furnished', $a));
        // $number = 231;
        // $fourDigitNumber = str_pad($number, 5, '0', STR_PAD_LEFT);
        // dd($fourDigitNumber);

        $price = 8000200.00; // Example price in rupees
        $formattedPrice = $this->convertPrice($price);
        echo $formattedPrice;die;
    }

    public function convertPrice($price)
    {
        $formattedPrice = '';
        
        if ($price >= 10000000) {
            $formattedPrice = ($price / 10000000) . ' Cr';
        } elseif ($price >= 100000) {
            $formattedPrice = ($price / 100000) . ' Lakh';
        } elseif ($price >= 1000) {
            $formattedPrice = ($price / 1000) . ' Thousand';
        } else {
            $formattedPrice = $price;
        }
        
        return $formattedPrice;
    }
    
}