<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Session;

use App\Withdrawal;
use App\Saving;
use App\Agents;
use App\AgentCustomers;

class WithdrawalController extends Controller
{
  public function __construct(){
    //$this->middleware('userAuth');    
  }
  
  public function getAgentCustomers($agent_id){
    $customers = AgentCustomers::where("customer_agent_id",$agent_id)->get();
    return view('withdrawal/customers',['customers_list'=>$customers]); 
  }
  
  public function getCustomerInfo(Request $request){
    $agent_id = $request->agent_id;
    $customer_account_no = $request->customer_account_no;
    $total_deposit = AgentCustomers::getCustomerSavingInfo($customer_account_no,$agent_id);
    if($total_deposit)  {
      $customer_info = array("status"=>"success",'total_deposit'=>$total_deposit);
    }else{
      $customer_info = array("status"=>"failure",'total_deposit'=>'');
    }
    echo json_encode($customer_info);
    exit;
  }
  
  public function getCustomerAccountInfo(Request $request){
    $customer_account_no = $request->customer_account_no;
    $customer_info = AgentCustomers::getCustomerAccountInfo($customer_account_no);
    if($customer_info)  {
      $customer_info['status'] = "success";
      $customer_info['total_deposit'] = AgentCustomers::getTotalDeposit($customer_account_no);
      $customer_info['agent_name'] = $customer_info->agent_first_name." ".$customer_info->agent_last_name;
    }else{
      $customer_info['status'] = "failure";
    }
    echo json_encode($customer_info);
    exit;
  }
  
  public function getCustomerWithdrawalHistory(Request $request){
    $agent_id = $request->agent_id;
    $customer_account_no = $request->customer_account_no;
    $customer_withdrawal_list = Withdrawal::getCustomerWithdrawalHistory($customer_account_no,$agent_id);
    $view =view('withdrawal/customer_withdrawal_history',['customer_withdrawal_list'=>$customer_withdrawal_list]); 
    echo $view;
    exit;
  }
  
  
  public function listWithdrawal(){
    $data = [
      'agents_list'=>Agents::getList()
    ];
    return view('withdrawal/list_withdrawal',$data);
  }
  
  public function addCustomerWithdrawal(Request $request, Saving $saving){
    $agent_id = $request->agent_id;
    $customer_account_no = $request->customer_account_no;
    $withdrawal_date = $this->dateFormat($request->withdrawal_date);
    $withdrawal_record = Withdrawal::checkIfRecordExist($customer_account_no,$agent_id,$withdrawal_date);
    if($withdrawal_record>0){
      $id = Withdrawal::getWithdrawalId($customer_account_no,$agent_id,$withdrawal_date);
      $update_withdrawal = new \stdClass();
      $update_withdrawal->agent_id = $agent_id;
      $update_withdrawal->customer_account_no  = $customer_account_no;
      $update_withdrawal->withdrawal_amount = $request->withdrawal_amount;
      $update_withdrawal->withdrawal_percentage = $request->withdrawal_percentage;
      $update_withdrawal->withdrawal_date = $withdrawal_date;
      $update_withdrawal->amount_in_hand =  $this->getAmountInHandVal($request->withdrawal_percentage,$request->withdrawal_amount);
      $update_withdrawal->total_deposit = $request->total_deposit;
      $update_withdrawal->total_balance = $request->total_balance;
      $update_withdrawal_data = (array)$update_withdrawal;
      Withdrawal::where('withdrawal_id',$id)->update($update_withdrawal_data);
    }else{
      $withdrawal = new \stdClass();
      $withdrawal->agent_id = $agent_id;
      $withdrawal->customer_account_no  = $customer_account_no;
      $withdrawal->withdrawal_amount = $request->withdrawal_amount;
      $withdrawal->withdrawal_percentage = $request->withdrawal_percentage;
      $withdrawal->withdrawal_date = $withdrawal_date;
      $withdrawal->amount_in_hand =  $this->getAmountInHandVal($request->withdrawal_percentage,$request->withdrawal_amount);
      $withdrawal->total_deposit = $request->total_deposit;
      $withdrawal->total_balance = $request->total_balance;
      $insert_withdrawal = (array)$withdrawal;
      Withdrawal::insertRecord($insert_withdrawal);
    }
    
    return back()->with('success',"Customer Account $customer_account_no withdrawal saved.");
  }
  
  public function getAmountInHand(Request $request){
    $amount = array();
    $total_balance = '';
    $total_deposit =  $request->total_deposit;
    $withdrawal_percentage = $request->withdrawal_percentage;
    $withdrawal_amount = $request->withdrawal_amount;
    $amount['amount_in_hand'] = $this->getAmountInHandVal($withdrawal_percentage,$withdrawal_amount);
    if($total_deposit!='' && $withdrawal_amount!=''){
      $total_balance = $total_deposit - $withdrawal_amount;
    }
    $amount['total_balance'] = $total_balance;
    echo json_encode($amount);
    exit;
  }
  
  public function getAmountInHandVal($withdrawal_percentage,$withdrawal_amount){
    $amount_in_hand = '';
    if($withdrawal_percentage!='' && $withdrawal_amount!='' ){
      if(strpos($withdrawal_percentage,"-")) {
        $percentage_arr = explode("-",$withdrawal_percentage);
        $per = $percentage_arr[1];
        $per_amount = ($withdrawal_amount * ($per/100));
        $amount_in_hand = $withdrawal_amount - $per_amount;
      }else{
        $per = $withdrawal_percentage;
        $per_amount = ($withdrawal_amount * ($per/100));
        $amount_in_hand = $withdrawal_amount + $per_amount;
      }
      
    }
    return $amount_in_hand;
  }
  
  public function dateFormat($date){    
    if($date!=''){
      list($day,$month,$year) = explode("/",$date);
      $date = $year."-".$month."-".$day;
    }
    return $date;
  }
}
