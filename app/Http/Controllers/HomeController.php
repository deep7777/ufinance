<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Session;

class HomeController extends Controller
{
    
  public function __construct()
  {

  }

  public function index(Request $request)
  {
    if($request->session()->has('admin')) {
      return redirect("/admin");
    }else if($request->session()->has('staff')){
      return redirect("/staff");
    }else if($request->session()->has('agent')){
      return redirect("/agent/dashboard");
    }else{
      return view('home');
    }
  }
  
  public function login(Request $request){
    if($request->session()->has('admin')) {
      return redirect("/admin");
    }else if($request->session()->has('staff')){
      return redirect("/staff");
    }else if($request->session()->has('agent')){
      return redirect("/agent");
    }else{
      return view('login');
    }
  }
}
