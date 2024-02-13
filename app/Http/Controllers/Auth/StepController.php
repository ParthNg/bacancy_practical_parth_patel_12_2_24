<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use App\Models\VendorType;
use App\Models\VendorProfile;
use App\Models\Category;
use App\Models\Country;
use App\Models\ProfileSpeciality;
use App\Models\ProfileImage;
use App\Models\VendorWorkingHour;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;
use Spatie\Permission\Models\Role;
use Auth;
use Illuminate\Validation\Rule;
use App\Models\Helpers\CommonHelper;

class StepController extends Controller
{
    use CommonHelper;
        public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */   
   public function step2()
    {
        $tags_categories = Category::where(['status' => 'active' , 'added_by' => 'admin'])->get();
        $country = Country::where('country_code','+966')->first();
        $profile = Profile::where('user_id',auth()->user()->id)->first();
        return view('auth.register2',compact('tags_categories','country','profile'));
    }

    public function store_step2(Request $request)
    {   
        $store_contact = $this->ArToEn($request->store_contact);
        $request->merge([
            'store_contact' => $store_contact,
        ]);
        // echo '<pre>'; print_r($request->all()); die;
        $profile = Profile::where('user_id',Auth()->user()->id)->first();
        $validator= $request->validate([
              'store_name:ar'        => 'required|string|min:3|max:100',
              'store_name:en'        => 'required|string|min:3|max:100',
              'store_email'          => 'required|email|max:255|unique:profiles,store_email',
              'store_address:ar'     => 'required|string|min:3|max:1000',
              'store_address:en'     => 'required|string|min:3|max:1000',
              'store_contact'        => 'required|numeric|digits:9|unique:profiles,store_contact',
              'lattitude'            => 'required',
              'longitude'            => 'required',
              'instagram_id'         => 'nullable|string|max:99',
              // 'instagram_id'         =>  ['nullable' ,'max:99', "regex:/^(?:(?:http|https):\/\/)?(?:www.)?(?:instagram.com|instagr.am)\/([A-Za-z0-9-_]+)/im"],
              'tags'           => 'required',
              'store_banner_image' => 'required|image|mimes:png,jpg,jpeg,svg|max:10000',
              'store_logo_image'   => 'required|image|mimes:png,jpg,jpeg,svg|max:10000',
        ]);
         DB::beginTransaction();
        $data = $request->all();
        // print_r($data);die;
        $data['user_type']  = 'vendor';
        $data['user_id']  = auth()->user()->id;
        // $data['store_id']  = 'vendor';
        //create store banner image
        if($request->store_banner_image){
            if($data['store_banner_image']) {
                $path = $this->saveMedia($request->store_banner_image,'store_banner_image');
                $data['store_banner_image'] = $path; 

            }
        }

        //create store logo image
        if($request->store_logo_image){
            if($data['store_logo_image']) {
                $path = $this->saveMedia($request->store_logo_image,'store_logo_image');
                $data['store_logo_image'] = $path; 
            }
        }  
        
        if($request->tags){
            $tag = substr($request->tags, 0, -1);
            $tags = explode(',',$tag);

          //speciality Deleted
          ProfileSpeciality::where('profile_id',$profile->id)->delete();
          $specializations   =  $tags;
          foreach ($specializations as $tag) {
            $specializations = ProfileSpeciality::create([
              'profile_id' =>   $profile->id,  
              'category_id' =>  $tag,
            ]);
          }
        }
        if($profile->update($data)) {
            DB::commit();
            return redirect()->route('register_step3')->with('success',trans('auth.step_2_success'));
        } else {
            return redirect()->route('register_step2')->with('error',trans('auth.error'));
        }
    }

    public function step3()
    {
        $page_title  =  '';
        $profile = Profile::where('user_id',Auth::user()->id)->first();
        $working_hours = VendorWorkingHour::where('vendor_id',Auth::user()->id)->get();
        
        $registration_certificate = ProfileImage::where('profile_id',$profile->id)->where('image_type','registration_certificate')->get();
        $company_certificate = ProfileImage::where('profile_id',$profile->id)->where('image_type','company_certificate')->get();

        $citizen_certificate = ProfileImage::where('profile_id',$profile->id)->where('image_type','citizen_certificate')->get();
        $id_certificate = ProfileImage::where('profile_id',$profile->id)->where('image_type','id_certificate')->get();
        return view('auth.register3',compact('page_title','profile','working_hours','registration_certificate','company_certificate','citizen_certificate','id_certificate'));
    }

    public function store_step3(Request $request)
    {
      $certificate  =  $request->all();
      $user_id = Auth::user()->id;
      $profile = Profile::where('user_id',$user_id)->first();
    // Validation
      if(count($profile->working_hour) == 0){
        return redirect()->back()->with(['error' => trans('auth.please_add_atleast_one_working_day')])->withInput();
      }
    if(auth()->user()->user_type == 'vendor'){    
        $this->validate($request,[
          'about_us:ar' => 'required|string|min:2|max:5000',
          'about_us:en' => 'required|string|min:2|max:5000',
        ]);

        $reg_certificate = ProfileImage::where('profile_id',$profile->id)->where('image_type','registration_certificate')->count();
        $com_certificate = ProfileImage::where('profile_id',$profile->id)->where('image_type','company_certificate')->count();
        if($reg_certificate < 1 || $com_certificate < 1 ){
            return redirect()->back()->with(['error' => trans('auth.please_update_all_certificates')])->withInput();
        }
    }

    if(auth()->user()->user_type == 'individual'){
        $this->validate($request,[
          'about_us:ar' => 'required|string|min:2|max:5000',
          'about_us:en' => 'required|string|min:2|max:5000',
        ]);
    }   
    $certificate['store_description:en']  = $certificate['about_us:en'];
    $certificate['store_description:ar']  = $certificate['about_us:ar'];

      if(!empty($profile)){
        if($profile->update($certificate)){
              // DB::commit();
              return redirect()->route('home')->with('success', trans('auth.register_successfully'));
        } else {
              // DB::rollback();
              return redirect()->route('register_step3')->with('error', trans('auth.error'));
        }
      }

    }

    public function working_hours(Request $request) {

        $page_title = trans('common.working_hours');
        $profile  = Profile::where('user_id', Auth::user()->id)->first();
        
        // echo '<pre>'; print_r($request->all()); die;
        DB::beginTransaction();
        VendorWorkingHour::where('vendor_id',Auth::user()->id)->delete();
        $working_days = $request->working_day;
        foreach ($working_days as $wdk=>$wdv) {
            $warray = [
                'vendor_id' => Auth::user()->id,
                'profile_id' => $profile->id,
                'user_type' => Auth::user()->user_type,
                'working_day' => ucfirst($wdv),
                'start_time'  => date('H:i', strtotime($request->start_time[$wdk])),
                'end_time'  => date('H:i', strtotime($request->end_time[$wdk])),
                'status'  => $request->wh_status[$wdk],
            ]; 

            if($request->wh_status[$wdk] == 1 && strtotime($request->start_time[$wdk]) >= strtotime($request->end_time[$wdk])) {
                DB::rollback();
                return response()->json(['error' => trans('working_hours.time_not_correct'),'type'=>'error']);
            }elseif( $request->wh_status['0'] == '0' && $request->wh_status['1'] == '0' && $request->wh_status['2'] == '0' && $request->wh_status['3'] == '0' && $request->wh_status['4'] == '0' && $request->wh_status['5'] == '0' && $request->wh_status['6'] == '0' ) {
                DB::rollback();
                    return response()->json(['error' => trans('working_hours.choose_atleast_one'),'type'=>'error']);
            }

            VendorWorkingHour::create($warray);    
        }
        DB::commit();
        return response()->json(['message' => trans('working_hours.updated'),'type'=>'success']);
    }

    public function store_certificate(Request $request)
    {
      $certificate  = $request->all();
      $user_id = Auth::user()->id;
      $profile = Profile::where('user_id',$user_id)->first();
      // Validation
      if($request->certificates == 'registration_certificate'){
        $image_type = 'registration_certificate';
        $certificate_images = $request->file();
      }
      // COMPANY CERTIFICATE
      if($request->certificates == 'company_certificate'){
        $image_type = 'company_certificate';
        $certificate_images = $request->file();
      }
      // CITIZEN CERTIFICATE
      if($request->certificates =='citizen_certificate'){
        $image_type = 'citizen_certificate';
        $certificate_images = $request->file();
      }
      // ID CERTIFICATE
      if($request->certificates == 'id_certificate'){
        $image_type = 'id_certificate';
        $certificate_images = $request->file();
      }
      // DB::beginTransaction();
      //Save Certificate Images       
      if(!empty($certificate_images)){
        $image  =  $certificate_images;
        foreach ($image as $certificate) { 
          $path = $this->saveMedia($certificate,'certificate');
          $certificate  = ProfileImage::create([
            'profile_id' => $profile->id, 
            'image_type' => $image_type, 
            'image' => $path
          ]);
        }        
        if($certificate){
              DB::commit();
              return redirect()->back()->with('success', trans('certificates.added'));
        } else {
              DB::rollback();
              return redirect()-back()->with('error', trans('certificates.error'));
        }
      }
    }

}