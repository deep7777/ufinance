<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoanRequirement extends Model
{
  protected $guarded = [];
  protected $table = 'loan_requirement';
  public $timestamps = false;
  
  public static function createRules(){
    return array(
      'customer_account_no' => 'unique:loan_requirement'
    );
  }
  
  public static function getLoanRequirementInfo($id){
    $obj = LoanRequirement::leftJoin("agent_customers","agent_customers.customer_account_no","=","loan_requirement.customer_account_no")
            ->leftJoin("agents",'agents.agent_id','=','loan_requirement.agent_id')
            ->where('loan_requirement_id', $id)->first();
    return $obj;
  }
  
  public static function getClosingDate($received_date,$period){
    if($received_date!='' && $period!=''){
      $query = "select DATE_ADD('{$received_date}',INTERVAL $period DAY) as closing_date ";
      $obj = DB::select($query);
      return  $obj[0]->closing_date;
    }else{
      return '';
    }
  }
}
