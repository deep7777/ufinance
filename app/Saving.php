<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Saving extends Model
{
  protected $guarded = [];
  protected $table = 'saving';
  public $timestamps = false;
  
  public static function getLastDay($date = ''){
    if($date == ""){
      $date = date('Y-m-d');
    }
    $query = "Select LAST_DAY('$date') as last_day";
    $last_date_obj = DB::select($query);
    $last_date = (array) $last_date_obj;
    $last_day_date = $last_date[0]->last_day;
    return $last_day_date;  
  }
  
  public static function getCustomerSavingList(){
    $savings = Saving::orderBy('collection_date','DESC')
                ->orderBy('daily_collection_amount','DESC')
                ->get();
    return $savings;
  }
  
  public static function getDMYFormat($date){
    $date_str = explode("/",$date);
    $date = $date_str[1]."-".$date_str[0]."-01";
    return $date;
  }
  
  public static function getYMFormat($date){
    $date_str = explode("/",$date);
    $date = $date_str[1]."-".$date_str[0];
    return $date;
  }
  
  public static function getLastDayNumber($date){
    $date_str = explode("-",$date);
    $last_day_no = $date_str[2];
    return $last_day_no;
  }
  
  public static function getLastDayOfMonth($date=''){
    $last_date_of_month = self::getLastDay($date);
    $last_day_number = self::getLastDayNumber($last_date_of_month);
    return $last_day_number;
  }
  
  public static function saveCollectionAmount($agent_id,$customer_account_no,$data){
    foreach($data as $key =>$saving){
      
    }
  }
  
  public static function checkIfSavingRecordExist($customer_account_no,$agent_id,$collection_date){
    $query = "select count(*)as count from saving where customer_account_no='{$customer_account_no}' and agent_id='{$agent_id}' and collection_date='{$collection_date}'";
    $last_date_obj = DB::select($query);
    return $last_date_obj[0]->count;
  }
  
  public static function getSavingId($customer_account_no,$agent_id,$collection_date){
    $query = "Select saving_id from saving where customer_account_no='{$customer_account_no}' and agent_id='{$agent_id}' and collection_date='{$collection_date}'";
    $query_obj = DB::select($query);
    return $query_obj[0]->saving_id;
  }
  
  public static function getMonthlyCollection($date,$customer_account_no){
    $query = "Select daily_collection_amount,collection_date,DATE_FORMAT(collection_date, '%d') AS day_no from saving where collection_date like '%{$date}%' and customer_account_no='{$customer_account_no}' order by collection_date asc";

    $query_obj = DB::select($query);
    $data = array();
    foreach($query_obj as $query_obj){
      $data[$query_obj->day_no] = $query_obj->daily_collection_amount;
    }
    return $data;
  }

  public static function getCustomerTotalDeposit($customer_account_no){
    $query = "Select sum(daily_collection_amount)as total_deposit_amount from saving where customer_account_no='{$customer_account_no}'";
    $query_obj = DB::select($query);
    return $query_obj[0]->total_deposit_amount;
  }
  
  public static function insertRecord($data){
    DB::table('saving')->insert($data);
  }
  
  
}
