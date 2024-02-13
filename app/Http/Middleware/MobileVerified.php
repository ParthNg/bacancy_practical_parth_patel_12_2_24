<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Auth;
class MobileVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $customer = Auth::guard('customer')->user();
        /*if($customer && $customer->verified != '1') {
            return redirect()->route('customer.profile', 'phone_email')->with('error', trans('common.mobile_number_not_updated'));
        }

        if($customer &&  ($customer->status == 'blocked' || $customer->status == 'inactive')) {
            $admin_email = Setting::get('contact_email');
            return redirect()->route('customer.profile')->with('error', trans('auth.account_blocked',['contact' => $admin_email]));
        }*/
        /*$customer_id = $request->user()->id;
        // '<pre>'; echo ($request); die();
            $customer = User::where('id',$customer_id)->where('verified','1')->first();
            if(!$customer){               
                // Redirect to Profile
                return redirect()->route('customer.profile')->with('error', trans('common.mobile_number_not_updated'));
            }*/
        return $next($request);
    }
}
