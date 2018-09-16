<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agents;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Session;

class ProfileController extends Controller
{
  public function __construct(){
    $this->middleware('agentAuth');
  }
  
  public function getAgentProfile(Request $request){
    $agent = $request->session()->get('agent');
    return view('agent/profile',['agent'=>$agent]);
  }
  
  public function updateAgent(Request $request){
    $id = $request->id;
    $agent = Agents::where('agent_id', $id)->first();
    if($agent){
      $rules = Agents::updateRules($id);
      $validator = Validator::make(Input::all(), $rules);
      if ($validator->fails()) {
        return Redirect::to("agent/profile")
            ->withErrors($validator)->withInput();
      }else{
        $update_profile = array(
          'agent_first_name' => $request->agent_first_name,
          'agent_last_name' => $request->agent_last_name,
          'agent_primary_contact' => $request->agent_primary_contact,
          'agent_secondary_contact' => $request->agent_secondary_contact,
          'password' => md5($request->password)
        );
        Agents::where("agent_id",$id)->update($update_profile);
        return  Redirect::to("/logout");
      }
    }else{
      return Redirect::to("/agent/dashboard");
    }  
  }
}
