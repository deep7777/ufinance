<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Session;
use App\AgentCustomers;
class SavingDefaulterController extends Controller
{
  public function __construct(){
    //$this->middleware('userAuth');    
  }
  
  public function getDailyDepositDefaulters(Request $request){
    $customer_reports = AgentCustomers::getDailyDepositDefaulters();
    return view('reports/daily_deposit_defaulters',['customer_reports'=>$customer_reports]);
  }
}
