<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Session;
use App\AgentCustomers;
use App\Agents;
use App\AccountStatus;
use App\LoanStatus;
use App\DepositTypes;

class ReportsController extends Controller
{
  public function __construct(){
    //$this->middleware('userAuth');    
  }
  
  public function listAgentCustomerDailyCollection(){
    $data = [
        'agents_list'=>Agents::getList(),
        'total_saving_amount'=>'',
        'total_loan_amount'=>''
    ];
    return view('reports/list_agent_customer_reports',$data);
  }
  
  public function getAgentCustomersDailyCollection(Request $request){
    $agent_id = $request->agent_id;
    $date = $this->dateFormat($request->collection_date);
    $agent_report = Agents::getAgentCustomerDailyCollectionReport($agent_id,$date);
    $customer_reports = $agent_report['customer_reports'];
    $data = [
        'customer_reports'=>$customer_reports,
        'total_saving_amount'=>$agent_report['total_saving_amount'],
        'total_loan_amount'=>$agent_report['total_loan_amount']
    ];
    return view('reports/agent_customer_daily_report',$data);
  }
  
  public function listAgentMonthlyCollectionData(Request $request){
    $date = date('Y-m');
    $agents = Agents::getAgentMonthlyCollectionData($date);
    $total_saving = Agents::getMonthlyTotalSavingCollectionAmount($date);
    $total_loan = Agents::getMonthlyTotalLoanCollectionAmount($date);
    $total = $total_saving + $total_loan;
    $data = [
      'agents'=>$agents,
      'total_saving'=>$total_saving,
      'total_loan'=>$total_loan,
      'total' =>$total 
    ];
    return view('reports/list_agent_monthly_collection_data',$data);
  }

  public function getAgentMonthlyCollectionData(Request $request){
    $date_array = explode("/",$request->month_year);
    $date = $date_array["1"]."-".$date_array[0];
    $agents = Agents::getAgentMonthlyCollectionData($date);
    $total_saving = Agents::getMonthlyTotalSavingCollectionAmount($date);
    $total_loan = Agents::getMonthlyTotalLoanCollectionAmount($date);
    $total = $total_saving + $total_loan;
    $data = [
      'agents'=>$agents,
      'total_saving'=>$total_saving,
      'total_loan'=>$total_loan,
      'total' =>$total 
    ];
    return view('reports/agent_monthly_collection_data',$data);
    exit;
  }
  
  public function listAgentMonthlyDailyCollection(Request $request){
    $agents_list = Agents::all();
    $data = [
      "agents_list"=>$agents_list,
      "total_saving_deposit"=>"",
      "total_loan_deposit"=>""
    ];
    return view("reports/list_agent_monthly_daily_collection",$data);
    
  }
  public function getAgentMonthlyDailyCollection(Request $request){
      $agent_id = $request->agent_id;
      $date_array = explode("/",$request->month_year);
      $date = $date_array["1"]."-".$date_array[0]."-01";
      $agents = Agents::getAgentMonthlyCollectionData($date);
      $last_day = Agents::getLastDayOfAnyMonth($date);
      $collection = array();
      $total_saving_deposit = 0;
      $total_loan_deposit = 0;
      
      for($i=1;$i<=$last_day;$i++){
        $date = $date_array["1"]."-".$date_array[0]."-".$i;
        $collection[$i]['date'] = $date;
        $collection[$i]['saving_amount'] = Agents::getDailyAgentSavingAmount($date, $agent_id);
        $collection[$i]['loan_amount'] =  Agents::getDailyAgentLoanAmount($date, $agent_id);
        $collection[$i]['total_amount'] = $collection[$i]['saving_amount']+$collection[$i]['loan_amount'];
        $total_saving_deposit+= $collection[$i]['saving_amount'];
        $total_loan_deposit+=$collection[$i]['loan_amount'];
      }
      $data = [
        "agents_list"=>$collection,
        "total_saving_deposit"=>$total_saving_deposit,
        "total_loan_deposit"=>$total_loan_deposit
      ];
      echo view('reports/agent_monthly_daily_collection',$data);
      exit;
  }
  
  public function getAccountStatus(){
    $account_status = array('1'=>'Active','2'=>'Inactive','3'=>'Reopen','4'=>'Active and Reopen');
    return $account_status;
  }
  public function listCustomerSummary(Request $request){
    $agents_list = Agents::all();
    $account_status = $this->getAccountStatus();
    $account_type = DepositTypes::all();
    $customers_list = AgentCustomers::all();
    $customers_name_list = AgentCustomers::orderBy('customer_first_name','asc')->get();
    $data = [
      'agents_list'=>$agents_list,
      'account_type'=>$account_type,
      'account_status'=>$account_status,
      'customers_list'=>$customers_list,
      'customers_name_list'=>$customers_name_list  
    ];
    return view("reports/list_customer_summary",$data);
  }
  
  public function getCustomerSummary(Request $request){
    $customer = AgentCustomers::getCustomerAccountReport($request);
    
    $data = [
      'customer' => $customer,
      'account_type_id'=>$request->account_type_id  
    ];
    
    echo view('reports/list_customer_summary_data',$data);
    exit;
  }
  
  public function listCustomerTransaction(){
    $data = [];
    return view("reports/list_customer_transaction",$data);
  }
  
  public function getCustomerTransaction(Request $request){
    $transactions = array();
    $customer_account_no = $request->customer_account_no;
    $from_date = $this->dateFormat($request->from_date);
    $to_date = $this->dateFormat($request->to_date);
    $transactions = AgentCustomers::getCustomerTransactions($customer_account_no,$from_date,$to_date);
    $customer_name = '';
    if($customer_account_no!=''){
      $customer_info = AgentCustomers::getCustomerAccountInfo($customer_account_no);
      if($customer_info){
        $customer_name = $customer_info->customer_first_name." ".$customer_info->customer_last_name;
      }
    }
    $data = [
      'customer_account_no'=>$customer_account_no,  
      'customer_name'=>$customer_name,  
      'transactions' => $transactions
    ];
    return view('reports/list_customer_transaction_data',$data);
    exit;
  }
  
  public function listLoanSummary(){
    $agents_list = Agents::all();
    $account_status = LoanStatus::all();
    $data = [
      'agents_list'=>$agents_list,
      'account_status'=>$account_status
    ];
    return view("reports/list_loan",$data);
  }
  
  public function getAgentCustomers($agent_id){
    $customers = AgentCustomers::getLoanCustomers($agent_id);
    return view('reports/agent_customers_dropdown',['customers_list'=>$customers]); 
  }
  
  public function getCustomerLoanSummary(Request $request){
    $account_status = $request->account_status_id;
    $agent_id = $request->agent_id;
    $loan = AgentCustomers::getCustomerLoanReport($agent_id,$request->customer_account_no,$account_status);
    $data = [
      'loan' => $loan
    ];
    
    echo view('reports/list_loan_data',$data);
    exit;
  }
  
  public function listBalanceSheet(){
    $data = [];
    return view("reports/list_balance_sheet",$data);
  }
  
  public function getBalanceSheet(Request $request){
    $from_date = $this->dateFormat($request->from_date);
    $to_date = $this->dateFormat($request->to_date);
    $balance_report = AgentCustomers::balanceReport($from_date,$to_date);
    $data = [
      'balance_report' => $balance_report
    ];
    echo view('reports/list_balance_sheet_data',$data);
    exit;
  }
}
