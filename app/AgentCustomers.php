<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AgentCustomers extends Model
{

  protected $guarded = [];
  protected $table = 'agent_customers';
  public $timestamps = false;
  
  public static function createRules(){
    return array(
      'customer_account_no' => 'unique:agent_customers',
      'customer_reg_no'=>'unique:agent_customers' 
    );
  }
  
  public static function updateRules($id){
    return array(
      'customer_account_no' => "required|unique:agent_customers,customer_account_no,$id,customer_id",  
      'customer_reg_no' => "unique:agent_customers,customer_reg_no,$id,customer_id",
    );
  }
  
  public static function getAccountNo(){
    $agent_customers = AgentCustomers::orderBy('customer_id','DESC')->first();
    $account_no = '';
    if(count($agent_customers) > 0){
      $row_id = $agent_customers->customer_id+1;
      $account_no = sprintf('%03d',$row_id);
    }else{
      $account_no = sprintf('%03d',1);
    }
    $account_no = "UF-".$account_no;
    return $account_no;
  }
  
  public static function getCustomerId(){
    $customer_id = '1';
    $agent_customers = AgentCustomers::orderBy('customer_id','DESC')->first();
    if(count($agent_customers) > 0){
      $customer_id = $agent_customers->customer_id+1;
    }
    return $customer_id;
  }
  
  public static function getRegisterationNo(){
    $agent_customers = AgentCustomers::orderBy('customer_id','DESC')->first();
    $registration_no = '1001';
    if(count($agent_customers) > 0){
      $customer_id = $agent_customers->customer_id+1;
      $registration_no = $customer_id+1000;
    }
    $registration_no = "UF-".$registration_no;
    return $registration_no;
  }
  
  public static function getList(){
    $agent_customers = AgentCustomers::leftJoin('deposit_types','deposit_types.deposit_type_id','=','agent_customers.account_type_id')
            ->orderBy('customer_account_opening_date','DESC')->get();
    return $agent_customers;
  }
  public static function getAllLoanCustomers(){
    $loan_customers =  LoanRequirement::leftJoin('agent_customers','loan_requirement.customer_account_no','=',"agent_customers.customer_account_no")
                      ->leftJoin("agents","agents.agent_id",'=',"loan_requirement.agent_id")
                      ->leftJoin("loan_account_status","loan_requirement.loan_account_status_id",'=',"loan_account_status.loan_account_status_id")
                      ->where("loan_requirement.loan_account_status_id",'<>','2')
                      ->get();
    return $loan_customers;
  }
  public static function getAllApprovedLoanCustomers(){
    $loan_customers =  LoanRequirement::leftJoin('agent_customers','loan_requirement.customer_account_no','=',"agent_customers.customer_account_no")
                      ->leftJoin("agents","agents.agent_id",'=',"loan_requirement.agent_id")
                      ->where("loan_requirement.loan_account_status_id",'=','2')
                      ->get();
    return $loan_customers;
  }
  
  public static function getAgentCustomers(){
    $agent_customers = AgentCustomers::leftJoin('agents','agents.agent_id','=',"agent_customers.customer_agent_id")->get();
    return $agent_customers;
  }
  
  public static function getAgentSavingCustomers(){
    $agent_saving_customers = AgentCustomers::leftJoin('agents','agents.agent_id','=',"agent_customers.customer_agent_id")->get();
    return $agent_saving_customers;
  }
  
  public static function getAgentLoanCustomers(){
    $agent_customers = LoanRequirement::leftJoin('agent_customers','loan_requirement.customer_account_no','=',"agent_customers.customer_account_no")
                      ->leftJoin("agents","agents.agent_id",'=',"loan_requirement.agent_id")
                      ->get();
    return $agent_customers;
  }
  
  public static function getCustomer($customer_id){
    $customer = AgentCustomers::leftJoin('agents','agents.agent_id','=',"agent_customers.customer_agent_id")
                ->where("agent_customers.customer_id",$customer_id)           
                ->first();
    return $customer;
  }
  
  public static function getMonthlyCustomerData($customer_id){
    $customer = AgentCustomers::leftJoin('agents','agents.agent_id','=',"agent_customers.customer_agent_id")
                ->where("agent_customers.customer_id",$customer_id)           
                ->first();
    return $customer;
  }
  
  public static function getSavingCustomers($agent_id){
    $saving_customers = AgentCustomers::where("customer_agent_id",$agent_id)
                 ->where("customer_loan_taken","0")
                ->get();
    return $saving_customers;
  }

  public static function getLoanCustomers($agent_id){
    $loan_customers =  LoanRequirement::leftJoin('agent_customers','loan_requirement.customer_account_no','=',"agent_customers.customer_account_no")
                      ->leftJoin("agents","agents.agent_id",'=',"loan_requirement.agent_id")
                      ->where('loan_requirement.agent_id',$agent_id)
                      ->where('agent_customers.customer_loan_taken',1)
                      ->get();
    return $loan_customers;
  }
  
  public static function listAgentCustomers($agent_id){
    $qry = "select
      (select sum(daily_collection_amount) from saving where saving.customer_account_no=agent_customers.customer_account_no) as saving_amount,
      (select sum(daily_collection_amount) from loan where loan.customer_account_no=agent_customers.customer_account_no) as loan_amount,
      (select sum(withdrawal_amount)   from withdrawal where withdrawal.customer_account_no=agent_customers.customer_account_no) as withdrawal_amount,
      (select IFNULL(saving_amount,0)-IFNULL(withdrawal_amount,0)) as balance_amount,
      agent_customers.*
      from `agents`
      join agent_customers on agent_customers.customer_agent_id = agents.agent_id
      where agent_id = '{$agent_id}' order by agent_customers.customer_account_no";
    $agent_customers = DB::select($qry);
    return $agent_customers;
  }
  
  public static function listAgentSavingCustomers($agent_id){
    $agent_customers = AgentCustomers::leftJoin('agents','agents.agent_id','=',"agent_customers.customer_agent_id")
                       ->where('agents.agent_id',$agent_id)->get();
    return $agent_customers;
  }
  
  public static function listAgentLoanCustomers($agent_id){
    $agent_customers = AgentCustomers::where('customer_loan_taken',1)
                       ->where('customer_agent_id',$agent_id)->get();
    return $agent_customers;
  }
  
  public static function getCustomerSavingInfo($customer_account_no,$agent_id){
    $query = "Select sum(daily_collection_amount) as saving_amount from saving where customer_account_no='{$customer_account_no}' and agent_id='{$agent_id}'";
    $query_obj = DB::select($query);
    return $query_obj[0]->saving_amount;
  }
  
  public static function getCustomerLoanInfo($customer_account_no,$agent_id){
    $query = "Select sum(daily_collection_amount) as loan_amount from loan where customer_account_no='{$customer_account_no}' and agent_id='{$agent_id}'";
    $query_obj = DB::select($query);
    return $query_obj[0]->loan_amount;
  }
  
  public static function getTotalSaving($customer_account_no){
    $query = "Select sum(daily_collection_amount) as saving_amount from saving where customer_account_no='{$customer_account_no}'";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->saving_amount;
    }else{
      return "0";
    }
  }
  
  public static function getTotalWithdrawal($customer_account_no){
    $query = "Select sum(withdrawal_amount) as withdrawal_amount from withdrawal where customer_account_no='{$customer_account_no}'";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->withdrawal_amount;
    }else{
      return "0";
    }
  }
  
  public static function getTotalDeposit($customer_account_no){
    $total_saving = self::getTotalSaving($customer_account_no);
    $total_withdrawal = self::getTotalWithdrawal($customer_account_no);
    $total_deposit = $total_saving - $total_withdrawal;
    return $total_deposit;
  }
  
  public static function getTotalLoan($customer_account_no){
    $query = "Select sum(daily_collection_amount) as loan_amount from loan where customer_account_no='{$customer_account_no}'";
    $query_obj = DB::select($query);
    return $query_obj[0]->loan_amount;
  } 
  
  
  public static function getCustomerAccountInfo($customer_account_no){
    $query_obj = AgentCustomers::leftJoin('agents','agents.agent_id','=',"agent_customers.customer_agent_id")
             ->where('agent_customers.customer_account_no',$customer_account_no)->first();
    return $query_obj;
  }
  
  public static function getCustomerAccountLoanDetails($customer_account_no){
    $query_obj = AgentCustomers::leftJoin('agents','agents.agent_id','=',"agent_customers.customer_agent_id")
            ->where('agent_customers.customer_loan_taken',1)
            ->where('agent_customers.customer_account_no',$customer_account_no)->first();
    
    return $query_obj;
  }
  
  public static function getLoanCustomerAccountInfo($customer_account_no){
    $query_obj = Loan::leftJoin('agent_customers','loan.agent_id','=',"agent_customers.customer_agent_id")
            ->leftJoin('agents','agents.agent_id','=',"agent_customers.customer_agent_id")
             ->where('loan.customer_account_no',$customer_account_no)->first();
    return $query_obj;
  }
  
  public static function getPreviousDate(){
    $query = "SELECT SUBDATE(CURDATE(),1) as previous_date";
    $query_obj = DB::select($query);
    return $query_obj[0]->previous_date;
  }
  
  public static function getDailySavingCollectedAmount($customer_account_no,$date){
    $query_obj = Saving::where('customer_account_no',$customer_account_no)
             ->where('collection_date',$date)->first();
    if($query_obj){
     return $query_obj->daily_collection_amount;
    }else{
      return "";
    }
  }
  
  public static function getDailyLoanCollectedAmount($customer_account_no,$date){
    $query_obj = Loan::where('customer_account_no',$customer_account_no)
             ->where('collection_date',$date)->first();
    if($query_obj){
     return $query_obj->daily_collection_amount;
    }else{
      return "";
    }
  }
  
  public static function getCustomerAccountDetails($account_no,$agent_id){
    $agent_customer = AgentCustomers::where('customer_account_no',$account_no)
                       ->where('customer_agent_id',$agent_id)->first();
    return $agent_customer;
  }
  
  public static function getSavingInfo($account_no,$agent_id){
    $agent_customer = Saving::where('customer_account_no',$account_no)
                       ->where('agent_id',$agent_id)->first();
    return $agent_customer;
  }
  
  public static function isCustomerTakenLoan($account_no,$agent_id){
    $agent_customers = AgentCustomers::where('customer_loan_taken',1)
                        ->where('customer_account_no',$account_no)
                       ->where('customer_agent_id',$agent_id)->first();
    return $agent_customers;
  }
  
  
  public static function getSubDateInterval($interval){
    $query = "SELECT DATE_SUB(CURRENT_DATE(), INTERVAL $interval DAY) as ds";
    $query_obj = DB::select($query);
    return $query_obj[0]->ds;
  }
  
  public static function getLoanDefaulters(){
    $loan_collection_date_gt = self::getSubDateInterval(3);
    $loan_collection_date_lt = date("Y-m-d");
    $query = "select 
              agents.agent_first_name,
              agents.agent_last_name,
              agent_customers.customer_account_no,
              agent_customers.customer_first_name,
              agent_customers.customer_last_name,
              agent_customers.customer_contact_no,
              loan_requirement.loan_approved_amount,
              loan_requirement.loan_received_date,
              loan_requirement.loan_in_hand_amount
              from agent_customers left join agents on agents.agent_id=agent_customers.customer_agent_id
              left join loan_requirement on loan_requirement.customer_account_no=agent_customers.customer_account_no
              where agent_customers.customer_account_no NOT IN(select agent_customers.customer_account_no from agent_customers 
              left join loan on loan.customer_account_no = agent_customers.customer_account_no
              where agent_customers.customer_loan_taken='1' and loan.collection_date >='{$loan_collection_date_gt}'
              and loan.collection_date <='{$loan_collection_date_lt}'
              group by agent_customers.customer_account_no
              )and agent_customers.customer_loan_taken=1";
    $defaulters = DB::select($query); 
    $customers = array();
    foreach($defaulters as $defaulter){
      $record = array(
          'agent_first_name'=>$defaulter->agent_first_name,
          'agent_last_name'=>$defaulter->agent_last_name,
          'customer_account_no'=>$defaulter->customer_account_no,
          'customer_first_name'=>$defaulter->customer_first_name,
          'customer_last_name'=>$defaulter->customer_last_name,
          'customer_contact_no'=>$defaulter->customer_contact_no,
          'loan_approved_amount'=>$defaulter->loan_approved_amount,
          'loan_received_date'=>$defaulter->loan_received_date,
          'loan_in_hand_amount'=>$defaulter->loan_in_hand_amount
          );
      
      $record['days']="";
      if($defaulter->loan_received_date!=Null){
        $last_paid_date = self::getLastPaidLoanAmountDate($defaulter->customer_account_no);
        $days = '';
        if($last_paid_date!=Null){
          $record['days'] = self::getNumberOfDaysNotPaid($last_paid_date);
        }
        $due_amount = self::getCustomerLoanDueAmount($defaulter->customer_account_no);
        $record['loan_due_amount'] = $defaulter->loan_approved_amount - $due_amount;
        array_push($customers,$record);
      }
    }
    return $customers;
  }
  
  public static function getCustomerLoanDueAmount($customer_account_no){
    $query = "select sum(daily_collection_amount)  as due_amount
              from loan
              where loan.customer_account_no='{$customer_account_no}'";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->due_amount;
    }else{
      return "0";
    }
  }
  
  public static function getDailyDepositDefaulters(){
    $saving_collection_date_gt = self::getSubDateInterval(10);
    $saving_collection_date_lt = date("Y-m-d");
    $query = "select 
              agents.agent_first_name,
              agents.agent_last_name,
              agent_customers.customer_account_no,
              agent_customers.customer_first_name,
              agent_customers.customer_last_name,
              agent_customers.customer_contact_no
              from agent_customers 
              left join agents on agents.agent_id = agent_customers.customer_agent_id
              where agent_customers.customer_account_status_id not in ('2') and customer_account_no NOT IN(select agent_customers.customer_account_no from agent_customers 
              left join saving on saving.customer_account_no = agent_customers.customer_account_no
              where saving.collection_date >='{$saving_collection_date_gt}'
              and saving.collection_date <='{$saving_collection_date_lt}' 
              group by agent_customers.customer_account_no
              )";
    $defaulters = DB::select($query);  
    $customers = array();
    foreach($defaulters as $defaulter){
      $record = array(
            'agent_first_name'=>$defaulter->agent_first_name,
            'agent_last_name'=>$defaulter->agent_last_name,
            'customer_account_no'=>$defaulter->customer_account_no,
            'customer_first_name'=>$defaulter->customer_first_name,
            'customer_last_name'=>$defaulter->customer_last_name,
            'customer_contact_no'=>$defaulter->customer_contact_no
          );
      $record['days']="";
      $last_paid_date = self::getLastPaidSavingAmountDate($defaulter->customer_account_no);
      if($last_paid_date!=Null){
        $record['days'] = self::getNumberOfDaysNotPaid($last_paid_date);
      }
      if($record['days']>"0"){
        array_push($customers,$record);
      }
    }
    return $customers;
  }
  
   public static function getLastPaidSavingAmountDate($customer_account_no){
    $query = "SELECT collection_date from saving where customer_account_no='{$customer_account_no}' and daily_collection_amount!=0  order by collection_date desc limit 1";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->collection_date;
    }else{
      return "";
    }
  }
  
  public static function getLastPaidLoanAmountDate($customer_account_no){
    $query = "SELECT collection_date from loan where customer_account_no='{$customer_account_no}' and daily_collection_amount!=0  order by collection_date desc limit 1";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->collection_date;
    }else{
      return "";
    }
  }
  
  public static function getNumberOfDaysNotPaid($last_date){
    $current_date = date("Y-m-d");
    $query = "SELECT DATEDIFF('{$current_date}','{$last_date}') AS days";
    $query_obj = DB::select($query);
    return $query_obj[0]->days;
  }
  
  public static function getSavingTransactions($customer_account_no,$from_date,$to_date){
    $query = "SELECT daily_collection_amount as amount,collection_date as cdate from saving where customer_account_no = '{$customer_account_no}' ";
    if($from_date!=''){
      $query.="and collection_date >='{$from_date}'";
    }
    if($to_date!=''){
      $query.="and collection_date <='{$to_date}'";
    }
    $query.="order by collection_date desc";
    $query_obj = DB::select($query);
    $transactions = [];
    foreach($query_obj as $customer){
      $withdrawal = self::getWidthdrawalAmount($customer_account_no,$customer->cdate);
      $saving =  self::getSavingAmount($customer_account_no,$customer->cdate);
      $balance = $saving - $withdrawal;
      $record = array(
                'amount'=>$customer->amount,
                'type'=>'saving',
                'cdate'=>$customer->cdate,
                'balance'=>$balance
                );
      array_push($transactions,$record);
    }
    return $transactions;
  }

  public static function getCustomerTransactions($customer_account_no,$from_date,$to_date){
    if($customer_account_no!=''){
      $saving_transactions = self::getSavingTransactions($customer_account_no,$from_date,$to_date);
      $withdrawal_transactions = self::getWithDrawalTransactions($customer_account_no,$from_date,$to_date);
      $transactions = array_merge($saving_transactions,$withdrawal_transactions);
      return $transactions;
    }else{
      return array();
    }
  }
  
  public static function getWithDrawalTransactions($customer_account_no,$from_date,$to_date){
    $query = "SELECT withdrawal_amount as amount,withdrawal_date as cdate from withdrawal where customer_account_no = '{$customer_account_no}' ";
    if($from_date!=''){
      $query.="and withdrawal_date >='{$from_date}'";
    }
    if($to_date!=''){
      $query.="and withdrawal_date <='{$to_date}'";
    }
    $query.="order by withdrawal_date desc";
    $query_obj = DB::select($query);
    $transactions = [];
    foreach($query_obj as $customer){
      $withdrawal = self::getWidthdrawalAmount($customer_account_no,$customer->cdate);
      $saving =  self::getSavingAmount($customer_account_no,$customer->cdate);
      $balance = $saving - $withdrawal;
      $record = array(
                'amount'=>$customer->amount,
                'type'=>'withdrawal',
                'cdate'=>$customer->cdate,
                'balance'=>$balance
                );
      array_push($transactions,$record);
    }
    return $transactions;
  }
  
  public static function getWidthdrawalAmount($customer_account_no,$date){
    $where = "where customer_account_no='{$customer_account_no}'";
    $subquery = $where." and withdrawal_date <='{$date}'";
    $condition_query = $subquery;
     $query = "Select sum(withdrawal_amount) as withdrawal_amount from withdrawal $condition_query";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->withdrawal_amount;
    }else{
      return "0";
    }
  }
  
  public static function getSavingAmount($customer_account_no,$date){
    $where = "where customer_account_no='{$customer_account_no}'";
    $subquery = $where." and collection_date <='{$date}'";
    $condition_query = $subquery;
     $query = "Select sum(daily_collection_amount) as saving_amount from saving $condition_query";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->saving_amount;
    }else{
      return "0";
    }
  }
  
  public static function getCustomerLoanReport($agent_id,$account_no,$account_status){
    $query = "select agents.*,agent_customers.*,
            (select case customer_account_status_id
            when '1' then customer_account_opening_date
            when '3' then customer_account_reopening_date
            end as account_opening_date from agent_customers where agent_customers.customer_account_no = loan.customer_account_no ) as account_opening_date,
            loan_approved_amount,
            loan_received_date,
            loan_closing_date,
            loan_per_day_collection,
            (select sum(daily_collection_amount) from saving where saving.customer_account_no=agent_customers.customer_account_no) as saving_amount,
            (select sum(daily_collection_amount) from loan where loan.customer_account_no = agent_customers.customer_account_no) as collected_amount,
            (select sum(withdrawal_amount) from withdrawal where withdrawal.customer_account_no = agent_customers.customer_account_no) as withdrawal_amount,            
            (select saving_amount - IFNULL(withdrawal_amount, 0)) as saving,            
            (select datediff(current_date(),loan_received_date) * loan_per_day_collection) as loan_collection_should_be,
            (select loan_approved_amount - sum(daily_collection_amount))loan_amount_due,
            (select loan_collection_should_be-sum(daily_collection_amount)) as loan_shortage
            from agent_customers
            join loan on loan.customer_account_no = agent_customers.customer_account_no
            join agents on agent_customers.customer_agent_id = agents.agent_id
            join loan_requirement on loan_requirement.customer_account_no = agent_customers.customer_account_no
            ";
    $condition = '';
    if($account_no!='' && $account_status!=''){
      $condition = "where agent_customers.customer_account_no = '{$account_no}' and loan_requirement.loan_status_id = '{$account_status}'";
    }else if($account_no!=''){
      $condition = "where agent_customers.customer_account_no = '{$account_no}'";
    }else if($account_status!=''){
      $condition = "where loan_requirement.loan_status_id = '{$account_status}'";
    }
    if($condition!='' && $agent_id!=''){
      $condition.= "and agents.agent_id = '{$agent_id}'";
    }else if($condition=='' && $agent_id!=''){
      $condition.= "where agents.agent_id = '{$agent_id}'";
    }
    $condition.=' group by agent_customers.`customer_account_no` order by agent_customers.customer_account_no desc';
    $query = $query."".$condition;
    $query_obj = DB::select($query);
    return $query_obj;
  }
  
  public static function getCustomerAccountReport($request){
    $agent_id = $request->agent_id;
    $account_status = $request->account_status_id;
    $account_type_id = $request->account_type_id;
    $account_no = $request->customer_account_no;
    
    $query = "select agents.*,agent_customers.*,
              (select case customer_account_status_id
              when '1' then customer_account_opening_date
              when '3' then customer_account_reopening_date
              end as account_opening_date from agent_customers where agent_customers.customer_account_no = loan.customer_account_no ) as account_opening_date,
              loan_approved_amount,
              loan_received_date,
              loan_closing_date,
              loan_per_day_collection,
              (select account from loan_status where loan_status_id = loan_requirement.loan_status_id) as loan_status,
              (select (sum(daily_collection_amount))as xc  from saving where saving.customer_account_no = agent_customers.customer_account_no) as saving_amount,
              (select (sum(withdrawal_amount))as xc  from withdrawal where withdrawal.customer_account_no = agent_customers.customer_account_no) as withdrawal_amount,
              (select saving_amount-IFNULL(withdrawal_amount, 0)) as deposit_amount,
              (select sum(daily_collection_amount) from loan where loan.customer_account_no = agent_customers.customer_account_no) as collected_amount
              from agent_customers
              left join loan on loan.customer_account_no = agent_customers.customer_account_no
              left join agents on agent_customers.customer_agent_id = agents.agent_id
              left join loan_requirement on loan_requirement.customer_account_no = agent_customers.customer_account_no
            ";
    $condition = '';
    if($account_no!='' || $account_status!='' || $account_type_id!=""){
      $condition.="where ";
    }
    $cquery = [];
    if($account_no!=""){
      $cquery[]= " agent_customers.customer_account_no = '$account_no' ";
      
    } 
    if($account_type_id!=''){
      $cquery[]= " agent_customers.account_type_id = '{$account_type_id}' ";
    }
    if($account_status!=''){
      if($account_status=="4"){
        $cquery[]= " agent_customers.customer_account_status_id in ('1','3')";
      }else{
        $cquery[]= " agent_customers.customer_account_status_id = '{$account_status}'";
      }
    }
    if(count($cquery)>0){
      $condition.= implode("and",$cquery);
    }
    
    if($condition!='' && $agent_id!=''){
      $condition.= " and agents.agent_id = '{$agent_id}'";
    }else if($condition=='' && $agent_id!=''){
      $condition.= " where agents.agent_id = '{$agent_id}'";
    }
    $condition.=' group by agent_customers.`customer_account_no` order by agent_customers.customer_account_no desc';
    $query = $query."".$condition;
    $query_obj = DB::select($query);
    return $query_obj;
  }
  
  public static function balanceReport($from_date,$to_date){
    
    $saving_qry = "select sum(daily_collection_amount) as daily_collection_amount from saving";
    $loan_amount_qry = "select sum(daily_collection_amount) as loan_daily_collection_amount from loan";
    $loan_collection_qry = "select sum(daily_collection_amount) as loan_daily_collection_amount from loan";            
    $withdrawal_amount_qry = "select sum(withdrawal_amount) as withdrawal_amount from withdrawal";
    $balance_amount_qry = "select (saving_amount - withdrawal_amount )";
    $expense_amount_qry = "select sum(expense_amount) from expenses";
    $agent_salary_qry = "select sum(agent_total_salary) from salary";
    $loan_amount_distributed_qry = "select sum(loan_in_hand_amount) from loan_requirement";

    if($from_date =="" && $to_date == ""){
      $query = "select ($saving_qry) as saving_amount,
            ($loan_amount_qry) as loan_amount,
            ($loan_collection_qry) as loan_collection,            
            ($withdrawal_amount_qry) as withdrawal_amount,
            ($balance_amount_qry ) as balance_amount,
            ($expense_amount_qry) as expense_amount,
            ($agent_salary_qry) as agent_salary,
            ($loan_amount_distributed_qry) as loan_amount_distributed
            ";
    }else if($from_date!=""){
      if($to_date!=""){
        $query = "select ($saving_qry where collection_date >='{$from_date}' and collection_date <='{$to_date}') as saving_amount,
            ($loan_amount_qry where collection_date >='{$from_date}' and collection_date <='{$to_date}') as loan_amount,            
            ($loan_collection_qry where collection_date >='{$from_date}' and collection_date <='{$to_date}') as loan_collection, 
            ($withdrawal_amount_qry where withdrawal_date >='{$from_date}' and withdrawal_date <='{$to_date}'  ) as withdrawal_amount,
            ($balance_amount_qry ) as balance_amount,
            ($expense_amount_qry where expense_date >='{$from_date}' and expense_date <='{$to_date}') as expense_amount,
            ($agent_salary_qry where agent_salary_paid_date >='{$from_date}' and agent_salary_paid_date <='{$to_date}') as agent_salary,
            ($loan_amount_distributed_qry where loan_received_date >='{$from_date}' and loan_received_date <='{$to_date}') as loan_amount_distributed
            ";
      }else{
        $query = "select ($saving_qry where collection_date >='{$from_date}') as saving_amount,
            ($loan_amount_qry where collection_date >='{$from_date}') as loan_amount,
            ($loan_collection_qry where collection_date >='{$from_date}') as loan_collection,            
            ($withdrawal_amount_qry where withdrawal_date >='{$from_date}') as withdrawal_amount,
            ($balance_amount_qry) as balance_amount,
            ($expense_amount_qry where expense_date >='{$from_date}') as expense_amount,
            ($agent_salary_qry where agent_salary_paid_date >='{$from_date}') as agent_salary,
            ($loan_amount_distributed_qry where loan_received_date >='{$from_date}') as loan_amount_distributed
            ";
      }
    }else if($to_date!=""){
      $query = "select ($saving_qry where collection_date <='{$to_date}') as saving_amount,
            ($loan_amount_qry where collection_date <='{$to_date}') as loan_amount,
            ($loan_collection_qry where collection_date <='{$to_date}') as loan_collection,           
            ($withdrawal_amount_qry where withdrawal_date <='{$to_date}') as withdrawal_amount,
            ($balance_amount_qry) as balance_amount,
            ($expense_amount_qry where expense_date <='{$to_date}') as expense_amount,
            ($agent_salary_qry where agent_salary_paid_date <='{$to_date}') as agent_salary,
            ($loan_amount_distributed_qry where loan_received_date <='{$to_date}') as loan_amount_distributed
            ";
    }
    $balance_query = ",
            (select saving_amount+loan_amount) as sum_amount,
            (select  IFNULL(withdrawal_amount, 0)+IFNULL(expense_amount,0)+IFNULL(agent_salary,0)+IFNULL(loan_amount_distributed,0)) as deduct_amount,
            (select IFNULL(sum_amount, 0)-IFNULL(deduct_amount, 0) ) as balance_amount";
    
    $query.=$balance_query;
    $query_obj = DB::select($query);
    return $query_obj;
    
  }
  
}
