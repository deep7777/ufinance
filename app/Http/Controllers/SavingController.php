<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Session;

use App\Saving;
use App\Agents;
use App\AgentCustomers;
class SavingController extends Controller
{
  public function __construct(){
    //$this->middleware('userAuth');    
  }
  
  public function getAgentCustomers($agent_id){
    $customers = AgentCustomers::where("customer_agent_id",$agent_id)->get();
    return view('saving/customers',['customers_list'=>$customers]); 
  }
  
  public function getMonthlyCustomerData(Request $request,$customer_id){
    $customer = AgentCustomers::getMonthlyCustomerData($customer_id);
    $customer_account_no = $customer->customer_account_no;
    $date = Saving::getDMYFormat($request->month_year);
    $year_month = Saving::getYMFormat($request->month_year);
    $last_day = Saving::getLastDayOfMonth($date);
    $total_deposit_amount = Saving::getCustomerTotalDeposit($customer_account_no);
    $get_monthly_collection = Saving::getMonthlyCollection($year_month,$customer_account_no);
    $columns = array('1'=>"Sun",'2'=>"Mon",'3'=>"Tue",'4'=>"Wed",'5'=>"Thu",'6'=>"Fri",'7'=>"Sat");
    $data = [
              'customer'=>$customer,
              'customer_account_no'=>$customer_account_no,
              'last_day'=>$last_day,
              'date'=>$date,
              'selected_month_year'=>$year_month,
              'total_deposit_amount'=>$total_deposit_amount,
              'get_monthly_collection'=>$get_monthly_collection,
              "columns"=>($columns),
              "j"=>"0"
            ];
    echo view('saving/monthly_customer_data',$data); 
    exit;
  }
  
  public function addCustomerSaving(Request $request, Saving $saving){
    $last_day_of_month = $request->last_day;
    $selected_month_year = $request->selected_month_year;
    $customer_id = $request->customer_id;
    $agent_id = $request->agent_id;
    $customer_account_no = $request->customer_account_no;
    $collection_data = array();
    for($i=1;$i<=$last_day_of_month;$i++){
      $str = "txt_collection_amount_".$i;
      if($request[$str]!=''){
        if($i<10){
          $i = sprintf("%02d", $i);
        }
        $date = $selected_month_year."-".$i;
        $date = $selected_month_year."-".$i;
        array_push($collection_data, array('collection_date'=>$date,"daily_collection_amount"=>$request[$str]));
      }
    }
    if(count($collection_data) > 0){
      foreach($collection_data as $key=>$data){
        $saving_record = Saving::checkIfSavingRecordExist($customer_account_no,$agent_id,$data['collection_date']);
        if($saving_record>0){
          $id = Saving::getSavingId($customer_account_no,$agent_id,$data['collection_date']);
          $update_saving = new \stdClass();
          $update_saving->customer_account_no = $customer_account_no;
          $update_saving->agent_id = $agent_id;
          $update_saving->daily_collection_amount = $data['daily_collection_amount'];
          $update_saving->collection_date = $data['collection_date'];
          $update_saving_data = (array)$update_saving;
          Saving::where('saving_id',$id)->update($update_saving_data);
        }else{
          $saving = new \stdClass();
          $saving->customer_account_no = $customer_account_no;
          $saving->agent_id = $agent_id;
          $saving->daily_collection_amount = $data['daily_collection_amount'];
          $saving->collection_date = $data['collection_date'];
          $insert_saving = (array)$saving;
          Saving::insertRecord($insert_saving);
        }
      }
    }
    
    $data = [
        'success'=>"Customer Account $customer_account_no collection saved.",
        'customer_account_no'=>$customer_account_no
    ];
    return back()->with($data);
  }
  
  public function listSaving(Request $request){
    $saving = Saving::getCustomerSavingList();
    $agent_customers = AgentCustomers::getAgentCustomers();
    $customer_account_no = 'UF-';
    if($request->session()->get('customer_account_no')!=''){
      $customer_account_no = $request->session()->get('customer_account_no');
    }
    
    $data = [
      'agents_list'=>Agents::getList(),
      'agent_customers'=>  $agent_customers,
      'customer_account_no'=>$customer_account_no
    ];
    return view('saving/list_saving',$data);
  }
  
  public function addSaving(){
    $data = [
        'agents_list'=>Agents::getList()
    ];
    return view('saving/add_saving',$data);
  }
  
  public function getCustomerAccountInfo(Request $request){
    $customer_account_no = $request->customer_account_no;
    $customer_info = AgentCustomers::getCustomerAccountInfo($customer_account_no);
    if($customer_info)  {
      $customer_info['status'] = "success";
      $customer_info['total_deposit'] = AgentCustomers::getTotalDeposit($customer_account_no);
      $customer_info['agent_name'] = $customer_info->agent_first_name." ".$customer_info->agent_last_name;
    }else{
      $customer_info['status'] = "failure";
    }
    echo json_encode($customer_info);
    exit;
  }
  
  public function getCustomerSavingInfoFromStaff(Request $request){
    $customer_account_no = $request->customer_account_no;
    $customer_info = AgentCustomers::getCustomerAccountInfo($customer_account_no);
    $prev_date = AgentCustomers::getPreviousDate();
    $date = date("Y-m-d");
    $prev_date_amount = AgentCustomers::getDailySavingCollectedAmount($customer_account_no,$prev_date);
    $current_date_amount = AgentCustomers::getDailySavingCollectedAmount($customer_account_no,$date);
    if($customer_info)  {
      $customer_info['status'] = "success";
      $customer_info['total_deposit'] = AgentCustomers::getTotalSaving($customer_account_no);
      $customer_info['agent_name'] = $customer_info->agent_first_name." ".$customer_info->agent_last_name;
      $customer_info['previous_date_amount'] = $prev_date_amount;
      $customer_info['current_date_amount'] = $current_date_amount;
    }else{
      $customer_info['status'] = "failure";
    }
    echo json_encode($customer_info);
    exit;
  }
  
  
  public function listSavingCustomer(){
    $saving = Saving::getCustomerSavingList();
    $agent_customers = AgentCustomers::getAgentCustomers();
    $prev_date = AgentCustomers::getPreviousDate();
    $current_date = date("d/m/Y");
    $date = date("Y-m-d");
    $data = [
      'agents_list'=>Agents::getList(),
      'agent_customers'=>  $agent_customers,
      'previous_date' => $prev_date,
      'current_date' =>$current_date
    ];
    return view('saving/list_saving_customer',$data);
  }
  
  public function addSavingFromStaff(){
    $data = [
        'agents_list'=>Agents::getList()
    ];
    return view('saving/add_saving_from_staff',$data);
  }
  
  public function dateFormat($date){    
    if($date!=''){
      list($day,$month,$year) = explode("/",$date);
      $date = $year."-".$month."-".$day;
    }
    return $date;
  }
  
  public function addCustomerSavingFromStaff(Request $request, Saving $saving){
    
    $agent_id = $request->agent_id;
    $customer_account_no = $request->customer_account_no;
    $collection_data = array();
    if($request->previous_date_amount!=''){
      $date = $this->dateFormat($request->previous_date);
      array_push($collection_data, array('collection_date'=>$date,"daily_collection_amount"=>$request->previous_date_amount));
    }
    if($request->current_date_amount!=''){
      $date = $this->dateFormat($request->current_date);
      array_push($collection_data, array('collection_date'=>$date,"daily_collection_amount"=>$request->current_date_amount));
    }
    if(count($collection_data) > 0){
      foreach($collection_data as $key=>$data){
        $saving_record = Saving::checkIfSavingRecordExist($customer_account_no,$agent_id,$data['collection_date']);
        if($saving_record>0){
          $id = Saving::getSavingId($customer_account_no,$agent_id,$data['collection_date']);
          $update_saving = new \stdClass();
          $update_saving->customer_account_no = $customer_account_no;
          $update_saving->agent_id = $agent_id;
          $update_saving->daily_collection_amount = $data['daily_collection_amount'];
          $update_saving->collection_date = $data['collection_date'];
          $update_saving_data = (array)$update_saving;
          Saving::where('saving_id',$id)->update($update_saving_data);
        }else{
          $saving = new \stdClass();
          $saving->customer_account_no = $customer_account_no;
          $saving->agent_id = $agent_id;
          $saving->daily_collection_amount = $data['daily_collection_amount'];
          $saving->collection_date = $data['collection_date'];
          $insert_saving = (array)$saving;
          Saving::insertRecord($insert_saving);
        }
      }
    }
    return back()->with('success',"Customer Account $customer_account_no collection saved.");
  }
}
