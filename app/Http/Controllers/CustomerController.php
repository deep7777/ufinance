<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Agents;
use App\AgentCustomers;
use App\DepositTypes;
use App\AccountStatus;
use Illuminate\Session;

class CustomerController extends Controller
{
  public function __construct(){
    //$this->middleware('userAuth');    
  }
  
  public function getData(){
    $data = [
      'agents_list'=>Agents::getList(),
      'deposit_types'=>  DepositTypes::all(),
      'account_status'=> AccountStatus::all()
    ];
    return $data;
  }
  public function listCustomer(){
    $customer = AgentCustomers::getList();
    return view('customer/list_customer',['customers_list'=>$customer]);
  }
  
  public function addCustomer(){
    
    $data = [
      'agents_list'=>Agents::getList(),
      'deposit_types'=>DepositTypes::all(),
      'account_status'=>AccountStatus::all(),
      'customer_account_no'=>AgentCustomers::getAccountNo(),
      'customer_id'=>AgentCustomers::getCustomerId(),
      'customer_reg_no'=>AgentCustomers::getRegisterationNo()
    ];
    return view('customer/add_customer',$data);
  }
  
  public function editCustomer(Request $request){
     $id = $request->segment('3');
     $customer = AgentCustomers::where('customer_id', $id)->first();
     if ($customer) {
       $customer_account_no = $customer->customer_account_no;
       $total_deposit = AgentCustomers::getTotalDeposit($customer_account_no);
       $data = [
          'customer' =>$customer,
          'agents_list'=>Agents::getList(),
          'deposit_types'=>  DepositTypes::all(),
          'account_status'=>AccountStatus::all(),
          'total_deposit'=>$total_deposit
       ];
       return view('customer/edit_customer',compact('customer'),$data);
     }else{
       return view('errors/record_not_found',['msg'=>'Record not Found']);
     }
  }
  
  public function updateCustomer(Request $request){
    // create the validation rules ------------------------
    $id = $request->id;
    $rules = AgentCustomers::updateRules($id);
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      $id = $request->id;
      return Redirect::to("customer/editCustomer/$id")
          ->withErrors($validator)->withInput();
    }else{
      $this->updateCustomerRecord($request);
    }
    return redirect('customer/listCustomer');
  }
  
  public function createCustomer(Request $request,  AgentCustomers $customer){
    $rules = AgentCustomers::createRules();
    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      return Redirect::to('customer/addCustomer')
          ->withErrors($validator)->withInput();
    }else{
      $this->saveCustomer($request, $customer);
      return back()->with('success','Customer Account Created.');
    }
    return redirect('customer/listCustomer');
  }
  
  public function updateCustomerRecord($request){
    $id = $request->id;
    $customer = new \stdClass();
    $customer->customer_agent_id = $request->customer_agent_id;
    $customer->account_type_id = $request->account_type_id;
    $customer->customer_account_no = $request->customer_account_no;
    $customer->customer_first_name = ucwords($request->customer_first_name);
    $customer->customer_middle_name = ucwords($request->customer_middle_name);
    $customer->customer_last_name = ucwords($request->customer_last_name);
    $customer->customer_gender = $request->customer_gender;
    $customer->customer_contact_no = $request->customer_contact_no;
    $customer->customer_account_opening_date = $this->dateFormat($request->customer_account_opening_date);
    $customer->customer_daily_deposit = $request->customer_daily_deposit;
    $customer->customer_address = $request->customer_address;
    $customer->customer_area = $request->customer_area;
    $customer->customer_account_status_id = $request->customer_account_status_id;
    if($request->customer_account_status_id == 3){
      $customer->customer_account_reopening_date =$this->dateFormat($request->customer_account_reopening_date);
    }else{
      $customer->customer_account_reopening_date = Null;
    }
    $customer->customer_loan_taken = (isset($request->customer_loan_taken)=="true")?"1":"0";
    $customer->customer_total_deposit_amount = (isset($request->customer_total_deposit_amount)==true)?$request->customer_total_deposit_amount:"0";
    if($request->account_type_id=="3"||$request->account_type_id==4){
      $customer->customer_reg_no = $request->customer_reg_no;
      $customer->customer_amount = $request->customer_amount;
      $customer->customer_account_maturity_date = $this->dateFormat($request->customer_account_maturity_date);
      $customer->customer_interest_rate = $request->customer_interest_rate;
      $customer->customer_tenure = $request->customer_tenure;
      $customer->customer_maturity_value = $request->customer_maturity_value;
    }else{
      $customer->customer_reg_no = Null;
      $customer->customer_amount = Null;
      $customer->customer_account_maturity_date = Null;
      $customer->customer_interest_rate = Null;
      $customer->customer_tenure = Null;
      $customer->customer_maturity_value = Null;
    }
    $update_customer = (array)$customer;
    AgentCustomers::where('customer_id',$id)->update($update_customer);
  }
  
  public function saveCustomer($request,$customer){
    $customer->customer_agent_id = $request->customer_agent_id;
    $customer->account_type_id = $request->account_type_id;
    $customer->customer_account_no = $request->customer_account_no;
    $customer->customer_first_name = ucwords($request->customer_first_name);
    $customer->customer_middle_name = ucwords($request->customer_middle_name);
    $customer->customer_last_name = ucwords($request->customer_last_name);
    $customer->customer_gender = $request->customer_gender;
    $customer->customer_contact_no = $request->customer_contact_no;
    $customer->customer_account_opening_date = $this->dateFormat($request->customer_account_opening_date);
    $customer->customer_daily_deposit = $request->customer_daily_deposit;
    $customer->customer_address = $request->customer_address;
    $customer->customer_area = $request->customer_area;
    $customer->customer_account_status_id = $request->customer_account_status_id;
    if($request->customer_account_status_id == 3){
      $customer->customer_account_reopening_date = $this->dateFormat($request->customer_account_reopening_date);
    }
    $customer->customer_loan_taken = (isset($request->customer_loan_taken)=="true")?"1":"0";
    $customer->customer_total_deposit_amount = (isset($request->customer_total_deposit_amount)==true)?$request->customer_total_deposit_amount:"0";
    if($request->account_type_id=="3"||$request->account_type_id==4){
      $customer->customer_reg_no = $request->customer_reg_no;
      $customer->customer_amount = $request->customer_amount;
      $customer->customer_account_maturity_date = $this->dateFormat($request->customer_account_maturity_date);
      $customer->customer_interest_rate = $request->customer_interest_rate;
      $customer->customer_tenure = $request->customer_tenure;
      $customer->customer_maturity_value = $request->customer_maturity_value;
    }
    $customer->save();
  }
  
  public function deleteCustomer(Request $request){
    $id = $request->id;
    $customer = AgentCustomers::where('id', $id)->first();
    if ($customer) {
      AgentCustomers::destroy($id);
      return "success";
    }else{
      return "record not found";
    }
  }
  
  public function dateFormat($date){    
    if($date!=''){
      list($day,$month,$year) = explode("/",$date);
      $date = $year."-".$month."-".$day;
    }
    return $date;
  }
}
