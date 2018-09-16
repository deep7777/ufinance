<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
  protected $guarded = [];
  protected $table = 'salary';
  public $timestamps = false;
  
  public static function getAgentSalary($id){
    $agent_salary = Salary::leftJoin('agents','agents.agent_id','=','salary.agent_id')->where('salary_id', $id)->first();
    return $agent_salary;
  }
  
  public static function getSalaryRecord($id){
    $record = Salary::where('salary_id', $id)->first();
    return $record; 
  }
  
  public static function getAgentSalaries(){
    $agent_salaries = Salary::leftJoin('agents','agents.agent_id','=','salary.agent_id')
            ->orderBy('agent_salary_paid_date','DESC')
            ->get();
    return $agent_salaries;
  }
}
