<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Agents;
use App\Saving;
use App\Loan;
use App\AgentCustomers;
use Illuminate\Session;


class CustomerAccountController extends Controller
{
  public function __construct(){
    $this->middleware('agentAuth');    
  }
  
  
  public function dashboard(Request $request){
    if ($request->session()->has('agent')) {
      $agent = $request->session()->get('agent');
      $agent_id = $agent->agent_id;
      $last_day = Agents::getCurrentMonthLastDay();
      $collection = array();
      $total_saving_deposit = Agents::getSavingTotalMonthDeposit($agent_id);
      $total_loan_deposit = Agents::getLoanTotalMonthDeposit($agent_id);
      for($i=1;$i<=$last_day;$i++){
        $date = date('Y-m')."-".$i;
        $collection[$i]['date'] = $date;
        $collection[$i]['saving_amount'] = Agents::getDailyAgentSavingAmount($date, $agent_id);
        $collection[$i]['loan_amount'] =  Agents::getDailyAgentLoanAmount($date, $agent_id);
        $collection[$i]['total_amount'] = $collection[$i]['saving_amount']+$collection[$i]['loan_amount'];
      }
      $data = [
        "agents_list"=>$collection,
        "total_saving_deposit"=>$total_saving_deposit,
        "total_loan_deposit"=>$total_loan_deposit
      ];
      return view('agent/customer/dashboard',$data);
    }else{
      return Redirect::to("/");
    }
  }
  
  public function agentCustomers(Request $request){
    if ($request->session()->has('agent')) {
      $agent = $request->session()->get('agent');
      $agent_id = $agent->agent_id;
      $agent_customers = AgentCustomers::listAgentCustomers($agent_id);
      $data = [
        'agent'=>$agent,  
        'agent_customers' =>$agent_customers
      ];
      return view('agent/customer/list_agent_customers',$data);
    }else{
      return Redirect::to("/");
    }
  }
  public function listDailyEntry(Request $request){
    if ($request->session()->has('agent')) {
      $agent = $request->session()->get('agent');
      $agent_id = $agent->agent_id;
      $agent_customers = AgentCustomers::listAgentCustomers($agent_id);
      $data = [
        'agent'=>$agent,  
        'agent_customers' =>$agent_customers
      ];
      return view('agent/customer/list_daily_entry',$data);
    }else{
      return Redirect::to("/");
    }
  }
  
  public function getAccounts(Request $request){
    $customer_account_no = $request->customer_account_no;
    $agent_id = $request->agent_id;
    $agent_customer = AgentCustomers::getCustomerAccountDetails($customer_account_no,$agent_id);
    $result = array("status"=>"failure");
    if($agent_customer){
      $result['status'] = "success";
      $result['is_loan_taken'] = $agent_customer->customer_loan_taken;
      $result['customer_name'] = $agent_customer->customer_first_name." ".$agent_customer->customer_last_name;
      $result['total_saving_deposit'] = AgentCustomers::getTotalDeposit($customer_account_no);
      $result['total_loan_deposit'] = AgentCustomers::getTotalLoan($customer_account_no);
    }
    echo json_encode($result);
    exit;
  }
  
  public function addDailyCollection(Request $request){
    $customer_account_no = $request->customer_account_no;
    $agent_id = $request->agent_id;
    $agent_customer = AgentCustomers::getCustomerAccountDetails($customer_account_no,$agent_id);
    if($agent_customer){
      if($request->daily_saving_collection_amount!=''){
        $daily_colection_amount = $request->daily_saving_collection_amount;
        $this->addDailySavingAmount($customer_account_no,$agent_id,$daily_colection_amount);
      }
      if($request->daily_loan_collection_amount!=''){
        $daily_colection_amount = $request->daily_loan_collection_amount;
        $this->addDailyLoanAmount($customer_account_no,$agent_id,$daily_colection_amount);
      }
      return back()->with('success',"Customer Account $customer_account_no collection saved.");
    }else{
      return back()->with('success',"Customer Account $customer_account_no not found.");
    }
  }
  
  public function addDailySavingAmount($customer_account_no,$agent_id,$daily_collection_amount){
    $current_date = date("Y-m-d");
    $saving_record = Saving::checkIfSavingRecordExist($customer_account_no,$agent_id,$current_date);
    if($saving_record>0){
      $id = Saving::getSavingId($customer_account_no,$agent_id,$current_date);
      $update_saving = new \stdClass();
      $update_saving->customer_account_no = $customer_account_no;
      $update_saving->agent_id = $agent_id;
      $update_saving->daily_collection_amount = $daily_collection_amount;
      $update_saving->collection_date = $current_date;
      $update_saving_data = (array)$update_saving;
      Saving::where('saving_id',$id)->update($update_saving_data);
    }else{
      $saving = new \stdClass();
      $saving->customer_account_no = $customer_account_no;
      $saving->agent_id = $agent_id;
      $saving->daily_collection_amount = $daily_collection_amount;
      $saving->collection_date = $current_date;
      $insert_saving = (array)$saving;
      Saving::insertRecord($insert_saving);
    }
  }
  
  public function addDailyLoanAmount($customer_account_no,$agent_id,$daily_collection_amount){
    $current_date = date("Y-m-d");
    $record = Loan::checkIfLoanRecordExist($customer_account_no,$agent_id,$current_date);
    if($record>0){
      $id = Loan::getLoanId($customer_account_no,$agent_id,$current_date);
      $update_loan = new \stdClass();
      $update_loan->customer_account_no = $customer_account_no;
      $update_loan->agent_id = $agent_id;
      $update_loan->daily_collection_amount = $daily_collection_amount;
      $update_loan->collection_date = $current_date;
      $update_loan_data = (array)$update_loan;
      Loan::where('loan_id',$id)->update($update_loan_data);
    }else{
      $loan = new \stdClass();
      $loan->customer_account_no = $customer_account_no;
      $loan->agent_id = $agent_id;
      $loan->daily_collection_amount = $daily_collection_amount;
      $loan->collection_date = $current_date;
      $insert_loan = (array)$loan;
      Loan::insertRecord($insert_loan);
    }
  }
  public function listSaving(Request $request){
    if ($request->session()->has('agent')) {
      $agent = $request->session()->get('agent');
      $agent_id = $agent->agent_id;
      $agent_customers = AgentCustomers::listAgentSavingCustomers($agent_id);
      $data = [
        'agent'=>$request->session()->get('agent'),  
        'agent_customers' =>$agent_customers
      ];
      return view('agent/customer/list_saving',$data);
    }
  }
  
  public function listLoan(Request $request){
    if ($request->session()->has('agent')) {
      $agent = $request->session()->get('agent');
      $agent_id = $agent->agent_id;
      $agent_customers = AgentCustomers::listAgentLoanCustomers($agent_id);
      $data = [
          'agent'=>$request->session()->get('agent'),
          'agent_customers' =>$agent_customers
      ];
      return view('agent/customer/list_loan',$data);
    }else{
      return Redirect::to("/");
    }
  }
  
  public function addSavingDailyCollection(Request $request){
    $current_date = date("Y-m-d");
    $agent_id = $request->agent_id;
    $customer_account_no = $request->customer_account_no;
    $saving_record = Saving::checkIfSavingRecordExist($customer_account_no,$agent_id,$current_date);
    if($saving_record>0){
      $id = Saving::getSavingId($customer_account_no,$agent_id,$current_date);
      $update_saving = new \stdClass();
      $update_saving->customer_account_no = $customer_account_no;
      $update_saving->agent_id = $agent_id;
      $update_saving->daily_collection_amount = $request->daily_collection_amount;
      $update_saving->collection_date = $current_date;
      $update_saving_data = (array)$update_saving;
      Saving::where('saving_id',$id)->update($update_saving_data);
    }else{
      $saving = new \stdClass();
      $saving->customer_account_no = $customer_account_no;
      $saving->agent_id = $agent_id;
      $saving->daily_collection_amount = $request->daily_collection_amount;
      $saving->collection_date = $current_date;
      $insert_saving = (array)$saving;
      Saving::insertRecord($insert_saving);
    }
    
    return back()->with('success',"Customer Account $customer_account_no collection saved.");

  }
  
  public function getSavingInfo(Request $request){
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
  
  public function getLoanInfo(Request $request){
    $agent_id = $request->agent_id;
    $customer_account_no = $request->customer_account_no;
    $total_deposit = AgentCustomers::getCustomerLoanInfo($customer_account_no,$agent_id);
    if($total_deposit)  {
      $customer_info = array("status"=>"success",'total_deposit'=>$total_deposit);
    }else{
      $customer_info = array("status"=>"failure",'total_deposit'=>'');
    }
    echo json_encode($customer_info);
    exit;
  }
  
  public function addLoanDailyCollection(Request $request){
    $current_date = date("Y-m-d");
    $agent_id = $request->agent_id;
    $customer_account_no = $request->customer_account_no;
    $saving_record = Loan::checkIfLoanRecordExist($customer_account_no,$agent_id,$current_date);
    if($saving_record>0){
      $id = Loan::getLoanId($customer_account_no,$agent_id,$current_date);
      $update_loan = new \stdClass();
      $update_loan->customer_account_no = $customer_account_no;
      $update_loan->agent_id = $agent_id;
      $update_loan->daily_collection_amount = $request->daily_collection_amount;
      $update_loan->collection_date = $current_date;
      $update_loan_data = (array)$update_loan;
      Loan::where('loan_id',$id)->update($update_loan_data);
    }else{
      $loan = new \stdClass();
      $loan->customer_account_no = $customer_account_no;
      $loan->agent_id = $agent_id;
      $loan->daily_collection_amount = $request->daily_collection_amount;
      $loan->collection_date = $current_date;
      $insert_loan = (array)$loan;
      Loan::insertRecord($insert_loan);
    }
    
    return back()->with('success',"Customer Account $customer_account_no collection saved.");

  }
  
  public function dateFormat($date){    
    if($date!=''){
      list($day,$month,$year) = explode("/",$date);
      $date = $year."-".$month."-".$day;
    }
    return $date;
  }
}
