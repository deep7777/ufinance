<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Loan;
use App\Agents;
use App\AgentCustomers;
use Illuminate\Session;

class LoanController extends Controller
{
  public function __construct(){
    //$this->middleware('userAuth');    
  }
  
  public function getAgentCustomers($agent_id){
    $customers = AgentCustomers::getLoanCustomers($agent_id);
    return view('loan/customers',['customers_list'=>$customers]); 
  }
  
  public function getMonthlyCustomerData(Request $request,$customer_id){
    $customer = AgentCustomers::getMonthlyCustomerData($customer_id);
    $customer_account_no = $customer->customer_account_no;
    $date = Loan::getDMYFormat($request->month_year);
    $year_month = Loan::getYMFormat($request->month_year);

    $last_day = Loan::getLastDayOfMonth($date);
    $total_deposit_amount = Loan::getCustomerTotalDeposit($customer_account_no);
    $get_monthly_collection = Loan::getMonthlyCollection($year_month,$customer_account_no);
    $columns = array('1'=>"Sun",'2'=>"Mon",'3'=>"Tue",'4'=>"Wed",'5'=>"Thu",'6'=>"Fri",'7'=>"Sat");
    $data = [
              'customer'=>$customer,
              'customer_account_no'=>$customer_account_no,
              'last_day'=>$last_day,
              'date'=>$date,
              'selected_month_year'=>$year_month,
              'total_deposit_amount'=>$total_deposit_amount,
              'get_monthly_collection'=>$get_monthly_collection,
              "columns"=>($columns),
              "j"=>"0"
            ];
    echo view('loan/monthly_customer_data',$data); 
    exit;
  }
  
  public function addCustomerLoan(Request $request, Loan $loan){
    $last_day_of_month = $request->last_day;
    $selected_month_year = $request->selected_month_year;
    $customer_id = $request->customer_id;
    $agent_id = $request->agent_id;
    $customer_account_no = $request->customer_account_no;
    $collection_data = array();
    for($i=1;$i<=$last_day_of_month;$i++){
      $str = "txt_collection_amount_".$i;
      if($request[$str]!=''){
        if($i<10){
          $i = sprintf("%02d", $i);
        }
        $date = $selected_month_year."-".$i;
        $date = $selected_month_year."-".$i;
        array_push($collection_data, array('collection_date'=>$date,"daily_collection_amount"=>$request[$str]));
      }
    }
    if(count($collection_data) > 0){
      foreach($collection_data as $key=>$data){
        $loan_record = Loan::checkIfLoanRecordExist($customer_account_no,$agent_id,$data['collection_date']);
        if($loan_record>0){
          $id = Loan::getLoanId($customer_account_no,$agent_id,$data['collection_date']);
          $update_loan = new \stdClass();
          $update_loan->customer_account_no = $customer_account_no;
          $update_loan->agent_id = $agent_id;
          $update_loan->daily_collection_amount = $data['daily_collection_amount'];
          $update_loan->collection_date = $data['collection_date'];
          $update_loan_data = (array)$update_loan;
          Loan::where('loan_id',$id)->update($update_loan_data);
        }else{
          $loan = new \stdClass();
          $loan->customer_account_no = $customer_account_no;
          $loan->agent_id = $agent_id;
          $loan->daily_collection_amount = $data['daily_collection_amount'];
          $loan->collection_date = $data['collection_date'];
          $insert_loan = (array)$loan;
          Loan::insertRecord($insert_loan);
        }
      }
    }
    $data = [
        'success'=>"Customer Account $customer_account_no collection saved.",
        'loan_customer_account_no'=>$customer_account_no
    ];
    return back()->with($data);
  }
  
  public function listLoan(Request $request){
    $loan = Loan::getCustomerLoanList();
    $agent_customers = AgentCustomers::getAgentLoanCustomers();
    $customer_account_no = 'UF-';
    if($request->session()->get('loan_customer_account_no')!=''){
      $customer_account_no = $request->session()->get('loan_customer_account_no');
    }
    
    $data = [
      'agents_list'=>Agents::getList(),
      'agent_customers'=>  $agent_customers,
      'customer_account_no'=>$customer_account_no
    ];
    return view('loan/list_loan',$data);
  }
  
  public function addLoan(){
    $data = [
        'agents_list'=>Agents::getList()
    ];
    return view('loan/add_loan',$data);
  }
  
  public function getCustomerAccountInfo(Request $request){
    $customer_account_no = $request->customer_account_no;
    $customer_info = AgentCustomers::getCustomerAccountLoanDetails($customer_account_no);
    if($customer_info)  {
      $customer_info['status'] = "success";
      $customer_info['total_deposit'] = AgentCustomers::getTotalLoan($customer_account_no);
      $customer_info['agent_name'] = $customer_info->agent_first_name." ".$customer_info->agent_last_name;
    }else{
      $customer_info['status'] = "failure";
    }
    echo json_encode($customer_info);
    exit;
  }
  
  public function getCustomerLoanInfoFromStaff(Request $request){
    $customer_account_no = $request->customer_account_no;
    $customer_info = AgentCustomers::getCustomerAccountLoanDetails($customer_account_no);
    $prev_date = AgentCustomers::getPreviousDate();
    $date = date("Y-m-d");
    $prev_date_amount = AgentCustomers::getDailyLoanCollectedAmount($customer_account_no,$prev_date);
    $current_date_amount = AgentCustomers::getDailyLoanCollectedAmount($customer_account_no,$date);
    if($customer_info)  {
      $customer_info['status'] = "success";
      $customer_info['total_deposit'] = AgentCustomers::getTotalLoan($customer_account_no);
      $customer_info['agent_name'] = $customer_info->agent_first_name." ".$customer_info->agent_last_name;
      $customer_info['previous_date_amount'] = $prev_date_amount;
      $customer_info['current_date_amount'] = $current_date_amount;
    }else{
      $customer_info['status'] = "failure";
    }
    echo json_encode($customer_info);
    exit;
  }
  
  public function listLoanCustomer(){
    $loan = Loan::getCustomerLoanList();
    $agent_customers = AgentCustomers::getAgentLoanCustomers();
    $prev_date = AgentCustomers::getPreviousDate();
    $current_date = date("d/m/Y");
    $data = [
      'agents_list'=>Agents::getList(),
      'agent_customers'=>  $agent_customers,
      'previous_date' => $prev_date,
      'current_date' =>$current_date
    ];
    return view('loan/list_loan_customer',$data);
  }
  
  public function addLoanFromStaff(){
     $data = [
        'agents_list'=>Agents::getList()
    ];
    return view('loan/add_loan_from_staff',$data);
  }
  
  public function dateFormat($date){    
    if($date!=''){
      list($day,$month,$year) = explode("/",$date);
      $date = $year."-".$month."-".$day;
    }
    return $date;
  }
  
  public function addCustomerLoanFromStaff(Request $request, Loan $loan){
    $agent_id = $request->agent_id;
    $customer_account_no = $request->customer_account_no;
    $collection_data = array();
    if($request->previous_date_amount!=''){
      $date = $this->dateFormat($request->previous_date);
      array_push($collection_data, array('collection_date'=>$date,"daily_collection_amount"=>$request->previous_date_amount));
    }
    if($request->current_date_amount!=''){
      $date = $this->dateFormat($request->current_date);
      array_push($collection_data, array('collection_date'=>$date,"daily_collection_amount"=>$request->current_date_amount));
    }
    if(count($collection_data) > 0){
      foreach($collection_data as $key=>$data){
        $loan_record = Loan::checkIfLoanRecordExist($customer_account_no,$agent_id,$data['collection_date']);
        if($loan_record>0){
          $id = Loan::getLoanId($customer_account_no,$agent_id,$data['collection_date']);
          $update_loan = new \stdClass();
          $update_loan->customer_account_no = $customer_account_no;
          $update_loan->agent_id = $agent_id;
          $update_loan->daily_collection_amount = $data['daily_collection_amount'];
          $update_loan->collection_date = $data['collection_date'];
          $update_loan_data = (array)$update_loan;
          Loan::where('loan_id',$id)->update($update_loan_data);
        }else{
          $loan = new \stdClass();
          $loan->customer_account_no = $customer_account_no;
          $loan->agent_id = $agent_id;
          $loan->daily_collection_amount = $data['daily_collection_amount'];
          $loan->collection_date = $data['collection_date'];
          $insert_loan = (array)$loan;
          Loan::insertRecord($insert_loan);
        }
      }
    }
    return back()->with('success',"Customer Account $customer_account_no collection saved.");
  }
}
