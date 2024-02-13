<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Profile;
use App\Models\VendorWorkingHour;
use App\Models\BankDetail;
use App\Models\Category;
use Carbon\Carbon;
use Auth;
class ProfileUpdated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user()){
            $user_id = $request->user()->id;
            if($request->user()->id != 2) {
              if($request->user()->status != 'active') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->with('error', 'You are inactive, please contact Administrator');
              }
            }
        }
        return $next($request);
    }
}