<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Agents extends Model
{
  protected $fillable = [
      'agent_first_name',
      'agent_last_name',
      'agent_joining_date',
      'agent_fixed_salary',
      'agent_address',
      'agent_primary_contact',
      'agent_secondary_contact',
      'username',
      'password',
      'agent_account_active'
      ];
  protected $table = 'agents';
  public $timestamps = false;
  
  public static function createRules(){
    return array(
      'username' => 'unique:agents'
    );
  }
  
  public static function updateRules($id){
    return array(
      'username' => "required|unique:agents,username,$id,agent_id",
    );
  }
  
  public static function getList(){
    $agent = Agents::orderBy('agent_joining_date','DESC')->get();
    return $agent;
  }
  
  public static function getAgentRecord($agent_id){
    $agent_details = Agents::where('agent_id',$agent_id)->first();
    return $agent_details;
  }
  
  public static function getAgentFixedSalary($id){
    $agent_salary = Agents::where('agent_id', $id)->first();
    return $agent_salary->agent_fixed_salary;
  }
  
  public static function getCommissionOfAllAgents(){
    $per = 0.03;
    $query = "select agents.agent_fixed_salary,saving.agent_id,sum(saving.daily_collection_amount) as total_month_deposit,
    (sum(saving.daily_collection_amount) * $per) as comission  from saving 
    left join agents on saving.agent_id = agents.agent_id 
    where saving.collection_date >= LAST_DAY(NOW() - INTERVAL 1 MONTH)  + INTERVAL 1 DAY 
    and saving.daily_collection_amount <= LAST_DAY(NOW()) 
    group by saving.agent_id,agents.agent_fixed_salary";
    $query_obj = DB::select($query);
    return $query_obj;
  }
  
  public static function getCommissionOfAgent($agent_id,$date){
    $per = 0.03;
    $first_day = self::getFirstDayOfAnyMonth($date);
    $last_day = self::getLastDateOfAnyMonth($date);
    $query = "select sum(saving.daily_collection_amount) as total_month_deposit,
    (sum(saving.daily_collection_amount) * $per) as comission  from agents 
    left join saving on saving.agent_id = agents.agent_id 
    where saving.collection_date >= '{$first_day}'
    and saving.collection_date <= '{$last_day}'
    and saving.agent_id = '{$agent_id}'   
    ";
    $query_obj = DB::select($query);
    if(isset($query_obj[0])){
      return $query_obj[0];
    }else{
      return "";
    }
  }
  
  public static function getTotalMonthDeposit($agent_id){
    $query = "select sum(saving.daily_collection_amount) as total_month_deposit from saving 
    left join agents on saving.agent_id = agents.agent_id 
    where saving.collection_date >= LAST_DAY(NOW() - INTERVAL 1 MONTH)  + INTERVAL 1 DAY 
    and saving.daily_collection_amount <= LAST_DAY(NOW()) and saving.agent_id='{$agent_id}' 
    ";
    $query_obj = DB::select($query);
    $total_month_deposit = '0';
    if($query_obj){
      if($query_obj[0]->total_month_deposit > 0){
        $total_month_deposit = $query_obj[0]->total_month_deposit;
      }
    }
    return $total_month_deposit;
  }
  
  public static function getPrevDailyAgentSavingAmount($agent_id){
    $query = "select sum(daily_collection_amount) as saving_amount from saving 
      where collection_date = DATE_ADD(CURRENT_DATE(), INTERVAL -1 DAY) and agent_id='{$agent_id}'
      group by agent_id";
    $query_obj = DB::select($query);
    if($query_obj){
    return $query_obj[0]->saving_amount;
    }else{
      return "0";
    }
  }
  
  public static function getDailyAgentSavingAmount($date,$agent_id){
    $query = "select sum(daily_collection_amount) as saving_amount from saving 
      where collection_date = '{$date}' and agent_id='{$agent_id}'
      group by agent_id";
    $query_obj = DB::select($query);
    if($query_obj){
    return $query_obj[0]->saving_amount;
    }else{
      return "0";
    }
  }
  
  public static function getDailyAgentLoanAmount($date,$agent_id){
    $query = "select sum(daily_collection_amount) as loan_amount from loan 
      where collection_date = '{$date}' and agent_id='{$agent_id}'
      group by agent_id";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->loan_amount;
    }else{
      return "0";
    }
  }
  
  public static function getPrevDailyAgentLoanAmount($agent_id){
    $query = "select sum(daily_collection_amount) as loan_amount from loan 
      where collection_date = DATE_ADD(CURRENT_DATE(), INTERVAL -1 DAY) and agent_id='{$agent_id}'
      group by agent_id";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->loan_amount;
    }else{
      return "0";
    }
  }
  
  public static function getFirstDayOfMonth(){
    $query = "select LAST_DAY(NOW() - INTERVAL 1 MONTH)  + INTERVAL 1 DAY as first_day ";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->first_day;
    }
  }
  
  public static function getLastDayOfMonth(){
    $query = "select LAST_DAY(now()) as last_day ";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->last_day;
    }
  }
  
  public static function getCurrentMonthLastDay(){
    $query = "select DATE_FORMAT(LAST_DAY(now()),'%d') as last_day";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->last_day;
    }
  }
  
  public static function getFirstDayOfAnyMonth($date){
    $query = "select LAST_DAY('{$date}' - INTERVAL 1 MONTH)  + INTERVAL 1 DAY as first_day ";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->first_day;
    }
  }
  
  public static function getLastDateOfAnyMonth($month){
    $query = "select DATE_FORMAT(LAST_DAY('{$month}'),'%Y-%m-%d') as last_day";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->last_day;
    }
  }
  
  public static function getLastDayOfAnyMonth($month){
    $query = "select DATE_FORMAT(LAST_DAY('{$month}'),'%d') as last_day";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->last_day;
    }
  }
  
  public static function getPrevDay(){
    $query = "select DATE_ADD(CURRENT_DATE(), INTERVAL -1 DAY) as prev_day";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->prev_day;
    }
  }
  
  public static function getSavingTotalMonthDeposit($agent_id){
    $query = "select sum(saving.daily_collection_amount) as total_month_deposit from saving
    where saving.collection_date >= LAST_DAY(NOW() - INTERVAL 1 MONTH)  + INTERVAL 1 DAY 
    and saving.daily_collection_amount <= LAST_DAY(NOW()) and saving.agent_id='{$agent_id}' 
    ";
    $query_obj = DB::select($query);
    $total_month_deposit = '0';
    if($query_obj){
      if($query_obj[0]->total_month_deposit > 0){
        $total_month_deposit = $query_obj[0]->total_month_deposit;
      }
    }
    return $total_month_deposit;
  }
  
  public static function getLoanTotalMonthDeposit($agent_id){
    $query = "select sum(loan.daily_collection_amount) as total_month_deposit from loan
    where loan.collection_date >= LAST_DAY(NOW() - INTERVAL 1 MONTH)  + INTERVAL 1 DAY 
    and loan.daily_collection_amount <= LAST_DAY(NOW()) and loan.agent_id='{$agent_id}' 
    ";
    $query_obj = DB::select($query);
    $total_month_deposit = '0';
    if($query_obj){
      if($query_obj[0]->total_month_deposit > 0){
        $total_month_deposit = $query_obj[0]->total_month_deposit;
      }
    }
    return $total_month_deposit;
  }
  
  public static function customerDailySavingAmount($customer_account_no,$agent_id,$date){
    $customer_daily_saving = Saving::where('customer_account_no',$customer_account_no)
            ->where('agent_id',$agent_id)
            ->where('collection_date',$date)
            ->first();
    if($customer_daily_saving){
      return $customer_daily_saving->daily_collection_amount;
    }else{
      return '0';
    }
  }
  
  
  
  public static function customerDailyLoanAmount($customer_account_no,$agent_id,$date){
    $customer_daily_loan = Loan::where('customer_account_no',$customer_account_no)
            ->where('agent_id',$agent_id)
            ->where('collection_date',$date)
            ->first();
    if($customer_daily_loan){
      return $customer_daily_loan->daily_collection_amount;
    }else{
      return '0';
    }
  }
  
  public static function totalAmountDescSort($item1,$item2)
  {
      if ($item1['total_amount'] == $item2['total_amount']) return 0;
      return ($item1['total_amount'] < $item2['total_amount']) ? 1 : -1;
  }

  public static function getAllCustomerReports($agent_id,$date){
    $agent_customers = AgentCustomers::where('customer_agent_id',$agent_id)->get();
    $customers = array();
    $agent_total_saving_amount_collected = 0;
    $agent_total_loan_amount_collected = 0;
    foreach($agent_customers as $customer){
      $customer_account_no = $customer->customer_account_no;
      $customer->saving_amount = self::customerDailySavingAmount($customer_account_no,$agent_id,$date);
      $customer->loan_amount = self::customerDailyLoanAmount($customer_account_no,$agent_id,$date);
      $customer->total_amount = $customer->saving_amount +$customer->loan_amount;
      $customer_name = $customer->customer_first_name." ".$customer->customer_last_name;
      $record = array(
        "customer_name"=>$customer_name,
        "customer_account_no"=>$customer_account_no,  
        "saving_amount"=>$customer->saving_amount,
        "loan_amount"=>$customer->loan_amount,
        "total_amount"=>$customer->total_amount  
      );
      $agent_total_saving_amount_collected += $customer->saving_amount;
      $agent_total_loan_amount_collected += $customer->loan_amount;
      if($customer->total_amount!=0){
        array_push($customers,$record);
      }
    }
    usort($customers,'self::totalAmountDescSort');
    $result = array(
                'customer_reports'=>$customers,
                "total_saving_amount"=>$agent_total_saving_amount_collected,
                "total_loan_amount"=>$agent_total_loan_amount_collected
              );
    return $result;
  }
  
  public static function getAgentCustomerDailyCollectionReport($agent_id,$date){
    $agent_customers = AgentCustomers::where('customer_agent_id',$agent_id)->get();
    $qry = "select saving.*,CONCAT(agent_customers.customer_first_name, ' ',agent_customers.customer_last_name) as customer_name,('saving') as type from saving
            join agent_customers on `agent_customers`.`customer_account_no` = saving.customer_account_no
            where saving.collection_date = '{$date}' and agent_id = '{$agent_id}'
            union
            select loan.*,CONCAT(agent_customers.customer_first_name, ' ',agent_customers.customer_last_name) as customer_name,('loan') as type  from loan
            join agent_customers on `agent_customers`.`customer_account_no` = loan.customer_account_no
            where loan.collection_date = '{$date}' and agent_id = '{$agent_id}' order by type desc,daily_collection_amount desc
            ";
    $customers = DB::select($qry);
    $sqry = "select sum(saving.daily_collection_amount) as saving_collection_amount from saving where saving.agent_id='{$agent_id}' and saving.collection_date = '{$date}'";
    $saving_amount_collected = DB::select($sqry);
    foreach($saving_amount_collected as $saving_amount_collected){
      $agent_total_saving_amount_collected = $saving_amount_collected->saving_collection_amount;
    }
    
    $lqry = "select sum(loan.daily_collection_amount) as loan_collection_amount from loan where loan.agent_id='{$agent_id}' and loan.collection_date = '{$date}'";
    $loan_amount_collected = DB::select($lqry);
    foreach($loan_amount_collected as $loan_amount_collected){
      $agent_total_loan_amount_collected = $loan_amount_collected->loan_collection_amount;
    }
    
    $result = array(
                'customer_reports'=>$customers,
                "total_saving_amount"=>$agent_total_saving_amount_collected,
                "total_loan_amount"=>$agent_total_loan_amount_collected
              );
    
    return $result;
  }
  
  public static function getAgentSavingMonthlyDataCollection($month,$agent_id){
    $query = "select sum(saving.daily_collection_amount) as sdc
              from agents left join saving on saving.agent_id  = agents.agent_id
              where saving.collection_date like '{$month}%' 
              and agents.agent_id = '{$agent_id}' group by agents.agent_id";
    $query_obj = DB::select($query);
    $total_saving_collection = '0';
    if($query_obj){
      if($query_obj[0]->sdc > 0){
        $total_saving_collection = $query_obj[0]->sdc;
      }
    }
    return $total_saving_collection;
  }
  
  
  
  public static function getAgentLoanMonthlyDataCollection($month,$agent_id){
    $query = "select agents.agent_id,sum(loan.daily_collection_amount) as ldc
            from agents left join loan on loan.agent_id  = agents.agent_id
            where loan.collection_date like '{$month}%' 
            and agents.agent_id = '{$agent_id}' group by agents.agent_id";
            
    $query_obj = DB::select($query);
    $total_loan_collection = '0';
    if($query_obj){
      if($query_obj[0]->ldc > 0){
        $total_loan_collection = $query_obj[0]->ldc;
      }
    }
    return $total_loan_collection;
  }
  
  public static function getAgentMonthlyCollectionData($date){
    $agent = Agents::all();
    $agents = [];
    foreach($agent as $agent){
      $agent->saving_amount = self::getAgentSavingMonthlyDataCollection($date,$agent->agent_id);
      $agent->loan_amount = self::getAgentLoanMonthlyDataCollection($date,$agent->agent_id);
      $agent->total_amount = $agent->saving_amount + $agent->loan_amount;
      $agent_name = $agent->agent_first_name." ".$agent->agent_last_name;
      $record = array(
        "agent_name"=>$agent_name,
        "saving_amount"=>$agent->saving_amount,
        "loan_amount"=>$agent->loan_amount,
        "total_amount"=>$agent->total_amount
      );
      array_push($agents,$record);
    }
    
    usort($agents,'self::totalAmountDescSort');
    return $agents;
  }
  
  public static function getMonthlyTotalSavingCollectionAmount($month){
    $query = "select sum(daily_collection_amount) as total_saving_amount from saving 
      where collection_date like '{$month}%'";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->total_saving_amount;
    }else{
      return 0;
    }
  }
  
  public static function getMonthlyTotalLoanCollectionAmount($month){
    $query = "select sum(daily_collection_amount) as total_loan_amount from loan 
      where collection_date like '{$month}%'";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->total_loan_amount;
    }else{
      return 0;
    }
  }
  
  public static function getDailyTotalSavingCollectionAmount($date){
    $query = "select sum(daily_collection_amount) as total_saving_amount from saving 
      where collection_date like '{$date}%'";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->total_saving_amount;
    }else{
      return 0;
    }
  }
  
  public static function getDailyTotalLoanCollectionAmount($date){
    $query = "select sum(daily_collection_amount) as total_loan_amount from loan 
      where collection_date like '{$date}%'";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->total_loan_amount;
    }else{
      return 0;
    }
  }
  
  public static function getDailyTotalExpenseCollectionAmount($date){
    $query = "select sum(expense_amount) as expense_amount from expenses 
      where collection_date like '{$date}%'";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->expense_amount;
    }else{
      return 0;
    }
  }
  
  public static function getMonthlyTotalExpenseCollectionAmount($month){
    $query = "select sum(expense_amount) as expense_amount from expenses 
      where expense_date like '{$month}%'";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->expense_amount;
    }else{
      return 0;
    }
  }
  
  
}
