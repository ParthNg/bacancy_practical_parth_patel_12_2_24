<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;

class SettingController extends Controller
{   
    public function __construct()
    {
      $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $page_title = trans('setting.settings');
        $settings = Setting::pluck('value','name')->all();
        return view('admin.setting.index',compact(['settings','page_title']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {   
        $settings = $request->all();
        $vreq = [];
        foreach ($settings as $sk => $sv) {
            if($sk == 'app_name'){
                $validation = 'required|max:99';
            }
            else if($sk == 'google_map_api_key'){
                $validation = 'required|max:50';
            }else{
                $validation = 'required';
            }
            $vreq[$sk] = $validation;
        }
        $request->validate($vreq);

        foreach ($settings as $key => $value) {
        Setting::where('name', $key)->update(['value'=> $value]);
        }   

        return redirect()->route('setting.index')->with('success','Settings updated successfully');
    }
   
}
