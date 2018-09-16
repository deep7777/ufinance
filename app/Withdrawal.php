<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Withdrawal extends Model
{
  protected $guarded = [];
  protected $table = 'withdrawal';
  public $timestamps = false;
  
  public static function checkIfRecordExist($customer_account_no,$agent_id,$date){
    $query = "select count(*)as count from withdrawal where customer_account_no='{$customer_account_no}' and agent_id='{$agent_id}' and withdrawal_date='{$date}'";
    $last_date_obj = DB::select($query);
    return $last_date_obj[0]->count;
  }
  
  public static function getCustomerTotalDeposit($customer_account_no){
    $query = "Select sum(daily_collection_amount)as total_deposit_amount from saving where customer_account_no='{$customer_account_no}'";
    $query_obj = DB::select($query);
    return $query_obj[0]->total_deposit_amount;
  }
  
  public static function getWithdrawalId($customer_account_no,$agent_id,$collection_date){
    $query = "Select withdrawal_id from withdrawal where customer_account_no='{$customer_account_no}' and agent_id='{$agent_id}' and withdrawal_date='{$collection_date}' order by withdrawal_date desc";
    $query_obj = DB::select($query);
    return $query_obj[0]->withdrawal_id;
  }
  
  public static function getCustomerWithdrawalHistory($customer_account_no,$agent_id){
    $query = "Select * from withdrawal where customer_account_no='{$customer_account_no}' and agent_id='{$agent_id}' order by withdrawal_date desc";
    $query_obj = DB::select($query);
    return $query_obj;
  }
  
  
  public static function insertRecord($data){
    DB::table('withdrawal')->insert($data);
  }
}
