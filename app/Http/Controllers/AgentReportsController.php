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
class AgentReportsController extends Controller
{
  public function __construct(Request $request){
    $this->middleware('agentAuth');
  }
  
  public function listAgentDailyCollectionReport(Request $request){
    $agent = $request->session()->get('agent');
    $agent_id = $agent->agent_id;
    $date = date('Y-m-d');
    
    $agent_customer_report = Agents::getAllCustomerReports($agent_id,$date);
    $data = [
        'customer_reports'=>$agent_customer_report['customer_reports'],
        'total_saving_amount'=>$agent_customer_report['total_saving_amount'],
        'total_loan_amount'=>$agent_customer_report['total_loan_amount']
    ];
    return view('agent/reports/list_agent_customer_reports',$data);
  }
  
  public function getAgentDailyCollectionReport(Request $request){
    $agent = $request->session()->get('agent');
    $agent_id = $agent->agent_id;
    $date = $this->dateFormat($request->collection_date);
    $agent_customer_report = Agents::getAllCustomerReports($agent_id,$date);
    $data = [
        'customer_reports'=>$agent_customer_report['customer_reports'],
        'total_saving_amount'=>$agent_customer_report['total_saving_amount'],
        'total_loan_amount'=>$agent_customer_report['total_loan_amount']
    ];
    echo view('agent/reports/agent_customer_daily_report',$data);
    exit;
  }
  
  public function getCustomerReport(){
    $agent = Agents::orderBy('agent_joining_date','DESC')->get();
    return view('agent/reports/customer_report',['agents_list'=>$agent]);
  }
}
