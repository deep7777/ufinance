<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Staff;
use App\Admin;
use App\Agents;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Session;

class LoginController extends Controller
{
    
    public function validateStaff(Request $request){
      $status = array('status'=>'success');
      $password = md5($request->password);
      $staff = Staff::where('username',$request->username)
              ->where('password',$password)
              ->where('status_id','1')
              ->first();
      
      if(!$staff){
        $status = array('status'=>'failure');
      }else{
        session(['staff' => $staff]);
        session(['template' => "staff"]);
      }
      return response()->json($status);
    }
    
    public function validateAdmin(Request $request){
      $status = array('status'=>'success');
      $password = md5($request->password);
      $admin = Admin::where('username',$request->username)
              ->where('password',$password)
              ->where('status_id','1')
              ->first();
      if(!$admin){
        $status = array('status'=>'failure');
      }else{
        session(['admin' => $admin]);
        session(['template' => "admin"]);
      }
      return response()->json($status);
    }
    
    public function validateLogin(Request $request){
      
      $staff = $this->staffExists($request);
      $admin = '';
      $agent = '';
      if(!$staff){
        $admin = $this->adminExists($request);
        if(!$admin){
          $agent= $this->agentExists($request);
        }
      }
      
      if($staff){
        session(['staff' => $staff]);
        session(['template' => "staff"]);
        return Redirect::to("/staff");
      }elseif($admin){
        session(['admin' => $admin]);
        session(['template' => "admin"]);
        return Redirect::to("/admin");
      }elseif($agent){
        session(['agent' => $agent]);
        session(['agent_id' => $agent->agent_id]);
        session(['template' => "agent"]);
        return Redirect::to("/agent/dashboard");
      }else{
        $request->session()->flash('message', 'Invalid user');
        return Redirect::to('/');
      }
      
    }
    
    public function staffExists($request){
      $password = md5($request->password);
      $staff = Staff::where('username',$request->username)
              ->where('password',$password)
              ->where('status_id','1')
              ->first();
      return $staff;
    }
    
    public function adminExists($request){
      $password = md5($request->password);
      $admin = Admin::where('username',$request->username)
              ->where('password',$password)
              ->where('status_id','1')
              ->first();
      return $admin;
    }
    
    public function agentExists($request){
      $password = md5($request->password);
      $agent = Agents::where('username',$request->username)
              ->where('password',$password)
              ->where('agent_account_active','1')
              ->first();
      return $agent;
    }
}