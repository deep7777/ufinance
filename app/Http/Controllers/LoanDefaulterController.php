<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Session;
use App\AgentCustomers;

class LoanDefaulterController extends Controller
{
  public function __construct(){
    //$this->middleware('userAuth');    
  }
  
  public function getLoanDefaulters(Request $request){
    $customer_reports = AgentCustomers::getLoanDefaulters();
    return view('reports/loan_defaulters',['customer_reports'=>$customer_reports]);
  }
}