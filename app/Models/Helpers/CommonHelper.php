<?php

namespace App\Models\Helpers;

use Illuminate\Support\Facades\Storage;
use DB;
use Redirect;
use App\Models\User;
use App\Models\Setting;
use App\Models\Product;
use App\Models\ProductVariant;

use Edujugon\PushNotification\PushNotification;
use App\Mail\OtpEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\SmsVerification;
use App\Models\EmailVerification;
use App\Models\Notifications;
use App\Models\PriceConfiguration;
use App\Models\ProductSize;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Carbon\Carbon;
use App\Notifications\SendVerificationEmail;
// use Notification;
use DateTime;
use DateInterval;
use Auth, App;

trait CommonHelper
{
  

  //For Customer Web
  public static function substrwords($text, $maxchar, $end='...') {
    if (strlen($text) > $maxchar || $text == '') {   
      $output = substr($text, 0, $maxchar);
      // return $output;
      $output .= $end;
    } else {
      $output = $text;
    }
    return $output;
  }


}
