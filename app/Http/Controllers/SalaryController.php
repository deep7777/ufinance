<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Session;
use App\Salary;
use App\Agents;

class SalaryController extends Controller
{
  public function __construct(Request $request){
    //$this->middleware('adminAuth');    
  }
  
  public function listSalary(){
    $salary = Salary::getAgentSalaries();
    return view('salary/list_salary',['salary_list'=>$salary]);
  }
  
  public function addSalary(){
    $data = [
        'agents_list'=>Agents::getList()
    ];
    return view('salary/add_salary',$data);
  }
  
  public function editSalary(Request $request){
     $id = $request->segment('3');
     $salary = Salary::getAgentSalary($id);
     $agent_id = $salary->agent_id;
     $total_month_deposit = Agents::getTotalMonthDeposit($agent_id);
     $data = [
        'salary'=>$salary,
        'agents_list'=>Agents::getList(),
        'total_month_deposit'=>$total_month_deposit
     ];
     if ($salary) {
       return view('salary/edit_salary',compact('salary'),$data);
     }else{
       return view('errors/record_not_found',['msg'=>'Record not Found']);
     }
  }
  
  public function updateSalary(Request $request){
    // create the validation rules ------------------------
    $id = $request->id;
    
    $this->updateSalaryRecord($request);
    
    return redirect('salary/listSalary');
  }
  
  public function createSalary(Request $request,  Salary $salary){
    $this->saveSalary($request, $salary);
    return back()->with('success','Agent Salary Created.');
  }
  
  public function updateSalaryRecord($request){
    $id = $request->id;
    $salary = new \stdClass();
    $salary_data = $this->getSalaryFields($request,$salary);
    $update_salary = (array) $salary_data;
    Salary::where('salary_id',$id)->update($update_salary);
  }
  
  public function getSalaryFields($request,$salary){
    $salary->agent_id = $request->agent_id;
    $salary->agent_fixed_salary = $request->agent_fixed_salary;
    $salary->agent_comission = $request->agent_comission;
    $salary->agent_comission_per = $request->agent_comission_per;
    $salary->agent_total_salary = $request->agent_total_salary;
    $salary->agent_salary_paid_date = $this->dateFormat($request->agent_salary_paid_date);
    return $salary;
  }
  
  public function saveSalary($request,$salary){
    $salary_data = $this->getSalaryFields($request,$salary);
    $salary_data->save();
  }
  
  public function getAgentSalary(Request $request){
    $agent_id = $request->agent_id;
    $date = date("Y-m-d");
    if($request->agent_salary_paid_date!=""){
      $date = $this->dateFormat($request->agent_salary_paid_date);
    }
    $agent_info = Agents::getCommissionOfAgent($agent_id,$date);
    $agent_fixed_salary = Agents::getAgentFixedSalary($agent_id);
    $agent_info->agent_fixed_salary = $agent_fixed_salary;
    echo json_encode($agent_info);
    exit;
  }
  
  public function deleteSalary(Request $request){
    $id = $request->id;
    $salary = Salary::getSalaryRecord($id);
    if ($salary) {
      Salary::where('salary_id', $id)->delete();
      return "success";
    }else{
      return "record not found";
    }
  }
  
  public function calculateSalary(Request $request){
    $per = $request->agent_comission_per/100;
    $comission_val = $request->agent_month_saving_deposit * $per;
    $comission = round($comission_val, 2);
		echo $comission;
    exit;
  }
  
  public function totalSalary(Request $request){
    $salary = $request->agent_fixed_salary+$request->agent_comission;
		echo $salary;
    exit;
  }
  
  public function dateFormat($date){    
    if($date!=''){
      list($day,$month,$year) = explode("/",$date);
      $date = $year."-".$month."-".$day;
    }
    return $date;
  }
}
