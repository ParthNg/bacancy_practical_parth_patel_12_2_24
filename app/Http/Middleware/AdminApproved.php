<?php

namespace App\Http\Middleware;

use Closure;

class AdminApproved
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
        if($request->user() && $request->user()->profile){
            if ($request->user()->profile->admin_approval == '0') {
                
                if($request->user()->user_type == 'vendor'){
                    return redirect()->route('home')->with('error', trans('common.vendor_not_approved'));
                }
                if($request->user()->user_type == 'individual'){
                    return redirect()->route('home')->with('error', trans('common.vendor_not_approved'));
                }
                return $next($request);
                
            }elseif ($request->user()->profile->admin_approval == '2') {
                return redirect()->route('home')->with('error', trans('common.profile_rejected'));
            }
            return $next($request);   

        }
        return $next($request);
    }
}
