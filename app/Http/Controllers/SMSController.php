<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use App\Http\Requests;
use Carbon\Carbon;

class SMSController extends Controller
{
    //
  public function index(){
   
    $username = "mantdemo";
    $password = "1569135231";
    $sender_id = "SMDEMO";
    $rand = rand();
    $msg="Hello Deepak this is your test message ".$rand;
    $url = "http://bulksms.mysmsmantra.com:8080/WebSMS/SMSAPI.jsp?username=$username&password=$password&sendername=$sender_id&mobileno=919767994372&message=$msg";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $curl_scraped_page = curl_exec($ch);
    curl_close($ch);
    echo $curl_scraped_page;
    echo $url;
    exit;
  }
}
