<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use App\Http\Requests;
use App\Staff;
use App\Admin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Session;
class StaffController extends Controller
{
  
  public function __construct(){
    //$this->middleware('staffAuth');
  }
  
  public function index(Request $request){
    $staff = $request->session()->get('staff');
    return view('staff/dashboard',['staff'=>$staff]);
  }
  
  public function profile(Request $request){
    $id = $request->id;
    $update_profile = array(
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'email' =>$request->email,
      'username' => $request->username,
      'password' => md5($request->password),
      'mobile_no' => $mobile_no,
      'status_id' => $status_id,
      'added_on' => Carbon::now()->format('Y-m-d H:i:s')
    );
    Staff::find($id)->update($update_profile);
  }
  
  public function getStaffProfile(Request $request){
    $staff = $request->session()->get('staff');
    $id = $staff->id;
    $staff = Staff::where('id', $id)->first();
    return view('staff/profile',['staff'=>$staff]);
  }
  
  public function updateProfile(Request $request){
    $id = $request->id;
    $staff = Staff::where('id', $id)->first();
    if($staff){
      $rules = Staff::updateRules($id);
      $validator = Validator::make(Input::all(), $rules);
      if ($validator->fails()) {
        return Redirect::to("staff/profile")
            ->withErrors($validator)->withInput();
      }else{
        $update_profile = array(
          'first_name' => $request->first_name,
          'last_name' => $request->last_name,
          'email' => $request->email,
          'mobile_no' => $request->mobile_no,
          'username' => $request->username,
          'password' => md5($request->password),
          'added_on' => Carbon::now()->format('Y-m-d H:i:s')
        );
        Staff::find($id)->update($update_profile);
        return  Redirect::to("/logout");
      }
    }else{
      return Redirect::to("/staff");
    }  
  }
}
