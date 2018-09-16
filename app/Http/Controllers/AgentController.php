<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use App\Http\Requests;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Session;
use App\Agents;

class AgentController extends Controller
{
  public function __construct(Request $request){
    //$this->middleware('userAuth');    
  }
  
  public function listAgent(){
    $agent = Agents::orderBy('agent_joining_date','DESC')->get();
    return view('agent/list_agent',['agents_list'=>$agent]);
  }
  
  public function addAgent(){
    return view('agent/add_agent');
  }
  
  public function editAgent(Request $request){
     $id = $request->segment('3');
     $agent = Agents::where('agent_id', $id)->first();
     if ($agent) {
       return view('agent/edit_agent',compact('agent'));
     }else{
       return view('errors/record_not_found',['msg'=>'Record not Found']);
     }
  }
  
  public function updateAgent(Request $request){
    // create the validation rules ------------------------
    $id = $request->id;
    $rules = Agents::updateRules($id);
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      $id = $request->id;
      return Redirect::to("agent/$id/editAgent")
          ->withErrors($validator)->withInput();
    }else{
      $this->updateAgentRecord($request);
    }
    return redirect('agent/listAgent');
  }
  
  public function createAgent(Request $request,  Agents $agent){
    $rules = Agents::createRules();
    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      return Redirect::to('agent/addAgent')
          ->withErrors($validator)->withInput();
    }else{
      $this->saveAgent($request, $agent);
    }
    return redirect('agent/listAgent');
  }
  
  public function updateAgentRecord($request){
    $id = $request->id;
    $update_agent = array(
      'agent_first_name' => ucwords($request->first_name),
      'agent_last_name' => ucwords($request->last_name),
      'agent_joining_date' =>$this->dateFormat($request->agent_joining_date),
      'agent_fixed_salary' => $request->agent_fixed_salary,
      'agent_address' => $request->agent_address,
      'username'=>strtolower($request->username),  
      'password' => md5($request->password),
      'agent_primary_contact' => $request->agent_primary_contact,
      'agent_secondary_contact'=>((isset($request->agent_secondary_contact)==true))?$request->agent_secondary_contact:"",
      'agent_account_active'=>'1' 
    );
    Agents::where('agent_id',$id)->update($update_agent);
  }
  
  public function saveAgent($request,$agent){
    $agent->agent_first_name = ucwords($request->first_name);
    $agent->agent_last_name = ucwords($request->last_name);
    $agent->agent_joining_date = $this->dateFormat($request->agent_joining_date);
    $agent->agent_fixed_salary = $request->agent_fixed_salary;
    $agent->agent_address = $request->agent_address;
    $agent->username = strtolower($request->username);
    $agent->password = md5($request->password);
    $agent->agent_primary_contact = $request->agent_primary_contact;
    $agent->agent_secondary_contact = ((isset($request->agent_secondary_contact)==true))?$request->agent_secondary_contact:"";
    $agent->agent_account_active = 1;
    $agent->save();
  }
  
  public function deleteAgent(Request $request){
    $id = $request->id;
    $agent = Agents::where('id', $id)->first();
    if ($agent) {
      Agents::destroy($id);
      return "success";
    }else{
      return "record not found";
    }
  }
  
  public function dateFormat($date){    
    if($date!=''){
      list($day,$month,$year) = explode("/",$date);
      $date = $year."-".$month."-".$day;
    }
    return $date;
  }
}
