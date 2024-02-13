<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable ,HasRoles;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'first_name',
      'last_name',
      'email',
      'age',
      'dob',
      'password',
      'user_type',
      'mobile_number',
      'vendor_type_id',
      'registered_on',
      'status',
      'profile_image',
      'lattitude',
      'longitude',
      'preferred_language',
      'city_id',
      'state_id',
      'country_id',
      'social_id',
      'social_type',
      'verified',
      'email_verified_at',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
      'password',
      'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];



  // associated city
  public function city(){
    return $this->belongsTo(City::class,'city_id');
  }

  // associated city
  public function country(){
    return $this->belongsTo(Country::class, 'country_id');
  }

  public function orders()
  {
      return $this->hasMany('App\Models\Order','user_id','id' );
  }



  public function device_detail(){
    return $this->hasOne('App\Models\DeviceDetail','user_id');
  }

  public function addNew($input){
    $check = static::where('social_id',$input['social_id'])->first();

    if(is_null($check)){
      $update = static::where('email',$input['email'])->first();
      if($update){
        $update->update($input);
        return $update;
      } else {
        return static::create($input);
      }
    }
    return $check;
  }


  /**
   * Send the password reset notification.
   *
   * @param  string  $token
   * @return void
   */
  public function sendPasswordResetNotification($token)
  {
      // Customize the reset URL based on the user type
      if ($this->isType('admin') || $this->isType('sub_admin')) {
          $resetUrl = url('/admin/password/reset', $token);
      } else {
          $resetUrl = url('/password/reset', $token); // Default URL for other types of users
      }

      $this->notify(new ResetPasswordNotification($resetUrl));
  }

  /**
   * Check if the user belongs to a specific type.
   *
   * @param  string  $type
   * @return bool
   */
  public function isType($type)
  {
      // Implement your own logic to determine the user type
      // For example, you can check a specific column or attribute in the user table
      return $this->user_type === $type;
  }
}
