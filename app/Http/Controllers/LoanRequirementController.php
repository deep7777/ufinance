<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use App\Http\Requests;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Session;
use App\Agents;
use App\AgentCustomers;
use App\DepositTypes;
use App\AccountStatus;
use App\Documents;
use App\LoanRequirement;
use App\LoanAccountStatus;
use App\LoanReceived;
use App\LoanStatus;


class LoanRequirementController extends Controller
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
  
  public function selectCustomer(){
    $agent_customers = AgentCustomers::getAgentCustomers();
    $customers_list = AgentCustomers::getAllLoanCustomers();
    $data = [
      'agents_list'=>Agents::getList(),
      'agent_customers'=>  $agent_customers,
      'customers_list'=>$customers_list
    ];
    return view('loan_requirement/select_customer',$data);
  }
  
  public function customerRequirement($customer_id){
    $customer = AgentCustomers::getCustomer($customer_id);
    $data =[
      'agents_list'=>Agents::getList(),  
      'customer'=>$customer,
      'documents'=>  Documents::all(),
      'loan_account_status'=>  LoanAccountStatus::all()  
    ];
    return view('loan_requirement/customer_requirement',$data); 
  }
  
  public function getAgentCustomers($agent_id){
    $customers = AgentCustomers::where("customer_agent_id",$agent_id)->get();
    return view('agent/customers',['customers_list'=>$customers]); 
  }
  
  public function listApproval(){
    $customer = AgentCustomers::getList();//in model
    return view('loan_requirement/list_approval',['customers_list'=>$customer]);
  }
  
  public function editLoanApprovedRequirement(Request $request){
     $id = $request->segment('3');
     $customer = LoanRequirement::getLoanRequirementInfo($id);
     if ($customer) {
       $data = [
          'customer' =>$customer,
          'agents_list'=>Agents::getList(),
          'deposit_types'=>  DepositTypes::all(),
          'account_status'=>AccountStatus::all(),
          'documents'=>  Documents::all(), 
          'loan_received'=>LoanReceived::all(),
          'loan_status'=>LoanStatus::all(),
          'loan_account_status'=>  LoanAccountStatus::all()
       ];
       $loan_amount_to_be_received = $customer->loan_per_day_collection * $customer->loan_tenure;
       $total_interest = $loan_amount_to_be_received - $customer->loan_in_hand_amount;
       $data['loan_amount_to_be_received']=$loan_amount_to_be_received;
       $data['total_interest']=$total_interest;
       $data['show_fields']='1';
       return view('loan_requirement/edit_loan_approved_requirement',compact('loan'),$data);
     }else{
       return view('errors/record_not_found',['msg'=>'Record not Found']);
     }
  }
  public function editLoanRequirement(Request $request){
     $id = $request->segment('3');
     $customer = LoanRequirement::getLoanRequirementInfo($id);
     if ($customer) {
       $data = [
          'customer' =>$customer,
          'agents_list'=>Agents::getList(),
          'deposit_types'=>  DepositTypes::all(),
          'account_status'=>AccountStatus::all(),
          'documents'=>  Documents::all(), 
          'loan_received'=>LoanReceived::all(),
          'loan_status'=>LoanStatus::all(),
          'loan_account_status'=>  LoanAccountStatus::all()
       ];
        $data['loan_amount_to_be_received']='';
        $data['total_interest']='';
        $data['show_fields']='0';
       return view('loan_requirement/edit_requirement',compact('loan'),$data);
     }else{
       return view('errors/record_not_found',['msg'=>'Record not Found']);
     }
  }
  
  public function updateRequirement(Request $request){
    // create the validation rules ------------------------
    $id = $request->id;
    $rules = AgentCustomers::updateRules($id);
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      $id = $request->id;
      return Redirect::to("loan_requirement/editRequirement/$id")
          ->withErrors($validator)->withInput();
    }else{
      $this->updateLoanRecord($request);
    }
    return redirect('loan_requirement/listRequirement');
  }
  
  public function editApproval(Request $request){
     $id = $request->segment('3');
     $customer = AgentCustomers::where('customer_id', $id)->first();
     if ($customer) {
       $data = [
          'customer' =>$customer,
          'agents_list'=>Agents::getList(),
          'deposit_types'=>  DepositTypes::all(),
          'account_status'=>AccountStatus::all()
       ];
       return view('loan_requirement/edit_requirement',compact('loan'),$data);
     }else{
       return view('errors/record_not_found',['msg'=>'Record not Found']);
     }
  }
  
  public function updateApproval(Request $request){
    // create the validation rules ------------------------
    $id = $request->id;
    $rules = AgentCustomers::updateRules($id);
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      $id = $request->id;
      return Redirect::to("loan_requirement/editApproval/$id")
          ->withErrors($validator)->withInput();
    }else{
      $this->updateLoanRecord($request);
    }
    return redirect('loan_requirement/listApproval');
  }
  
  public function createCustomerRequirement(Request $request,  LoanRequirement $loan_requirement){
    $rules = LoanRequirement::createRules();
    $validator = Validator::make(Input::all(), $rules);
    $customer_id = $request->customer_id;
    if ($validator->fails()) {
      return Redirect::to('loan_requirement/customerRequirement/'.$customer_id)
          ->withErrors($validator)->withInput();
    }else{
     $this->saveLoan($request, $loan_requirement); 
    }
 
    return redirect('loan_requirement/selectCustomer');
  }
  

  
  public function saveLoan($request,$loan_requirement){
        
    $loan_requirement->agent_id = $request->agent_id;
    $loan_requirement->customer_account_no = $request->customer_account_no;
    $loan_requirement->customer_id = $request->customer_id;
    $loan_requirement->loan_requirement_amount = $request->loan_requirement_amount;
    $loan_requirement->loan_file_login_date = $this->dateFormat($request->loan_file_login_date);
    $loan_requirement->loan_document_list = json_encode($request->loan_document_list);
    if($request->loan_approved_amount!=''){
      $loan_requirement->loan_approved_amount = $request->loan_approved_amount;
    }
    if($request->loan_approved_date!=''){
      $loan_requirement->loan_approved_date = $this->dateFormat($request->loan_approved_date);
    }
    if($request->loan_in_hand_amount!=''){
      $loan_requirement->loan_in_hand_amount = $request->loan_in_hand_amount;
    }
    if($request->loan_per_day_collection!=''){
      $loan_requirement->loan_per_day_collection = $request->loan_per_day_collection;
    }
    if($request->loan_tenure!=''){
      $loan_requirement->loan_tenure = $request->loan_tenure;
    }
    if($request->loan_account_status_id!=''){
      $loan_requirement->loan_account_status_id = $request->loan_account_status_id;
    }
    $loan_requirement->loan_comment = $request->loan_comment;
    $loan_requirement->save();
  }
  public function updateCustomerRequirement(Request $request){
    $this->updateLoan($request);
    if(isset($request->loan_approved)){
      return Redirect::to("/loan_requirement/customerLoanApproved");
    }else{
      return Redirect::to("/loan_requirement/selectCustomer");
    }
  }
  
  public function updateLoan($request){
    $id = $request->id;
    $loan_requirement = new \stdClass();
    $loan_requirement->agent_id = $request->agent_id;
    $loan_requirement->customer_account_no =  $request->customer_account_no;
    $loan_requirement->customer_id = $request->customer_id;
    $loan_requirement->loan_requirement_amount = $request->loan_requirement_amount;
    $loan_requirement->loan_file_login_date = $this->dateFormat($request->loan_file_login_date);
    if($request->loan_status_id!='3'){
      $loan_requirement->loan_received_date = $this->dateFormat($request->loan_received_date);
      $loan_requirement->loan_closing_date = $this->dateFormat($request->loan_closing_date);
      $loan_requirement->loan_tenure = $request->loan_tenure;
    }
    $loan_requirement->loan_document_list = json_encode($request->loan_document_list);
    $loan_requirement->loan_status_id = $request->loan_status_id;
    if($request->loan_approved_amount!=''){
      $loan_requirement->loan_approved_amount = $request->loan_approved_amount;
    }
    if($request->loan_approved_date!=''){
      $loan_requirement->loan_approved_date = $this->dateFormat($request->loan_approved_date);
    }
    
    if($request->loan_received_date!=''){
      $loan_requirement->loan_received_date = $this->dateFormat($request->loan_received_date);
    }

    if($request->loan_in_hand_amount!=''){
      $loan_requirement->loan_in_hand_amount = $request->loan_in_hand_amount;
    }
    
    if($request->loan_per_day_collection!=''){
      $loan_requirement->loan_per_day_collection = $request->loan_per_day_collection;
    }
    
    if($request->loan_account_status_id!=''){
      $loan_requirement->loan_account_status_id = $request->loan_account_status_id;
    }
    
    if($request->loan_status_id!=''){
      $loan_requirement->loan_status_id = $request->loan_status_id;
      if($request->loan_status_id==2){
        $this->updateLoanTaken($request->customer_account_no);
      }
    }
    
    if($request->loan_received_id!=''){
      $loan_requirement->loan_received_id = $request->loan_received_id;
    }
    if($request->loan_comment!=''){
      $loan_requirement->loan_comment = $request->loan_comment;
    }else{
      $loan_requirement->loan_comment = "";
    }
    
    $update_loan_requirement = (array) $loan_requirement;
    LoanRequirement::where('loan_requirement_id',$id)->update($update_loan_requirement);
  }

  public function updateLoanTaken($customer_account_no){
    $loan_taken = new \stdClass();
    $loan_taken->customer_loan_taken = 0;
    $agent_customer = (array) $loan_taken;
    AgentCustomers::where('customer_account_no',$customer_account_no)->update($agent_customer);
  }
  
  public function dateFormat($date){    
    if($date!=''){
      list($day,$month,$year) = explode("/",$date);
      $date = $year."-".$month."-".$day;
    }
    return $date;
  }
  
  public function dmy($date){
    if($date!='' && $date!=NULL){
      $date = date('d/m/Y', strtotime($date));
    }
    return $date;
  }

  public function getClosingDate(Request $request){
    $received_date = $this->dateFormat($request->loan_received_date);
    $period = $request->loan_tenure;
    $closing_date = '';
    if($received_date!='' && $period!=''){
      $closing_date_str = LoanRequirement::getClosingDate($received_date, $period);
      $closing_date = $this->dmy($closing_date_str);
    }
    echo $closing_date;
    exit;
  }
  
  public function customerLoanApproved(){
    $customers_list = AgentCustomers::getAllApprovedLoanCustomers();
    $data = [
      'customers_list'=>$customers_list
    ];
    return view('loan_requirement/customer_loan_approved',$data);
  }
}
