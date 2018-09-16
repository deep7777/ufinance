<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use App\Http\Requests;
use App\Staff;
use App\Admin;
use App\AgentCustomers;
use App\Agents;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Session;

class AdminController extends Controller
{
    //
  public $admin = array();
  public function __construct(Request $request){
    $this->middleware('adminAuth');    
  }
  

  public function index(Request $request){
    
    $date = date("Y-m-d");
    $data = $this->getData($date);
    return view('admin/dashboard',$data);
  }
  
  public function getData($date){
    $agents_list = Agents::all();
    foreach($agents_list as $agent){
      $agent->saving_amount = Agents::getDailyAgentSavingAmount($date, $agent->agent_id);
      $agent->loan_amount = Agents::getDailyAgentLoanAmount($date, $agent->agent_id);
      $agent->total_amount = $agent->saving_amount + $agent->loan_amount;
    }
    $month = $this->getMonth($date);
    $total_daily_saving = Agents::getDailyTotalSavingCollectionAmount($date);
    $total_daily_loan = Agents::getDailyTotalLoanCollectionAmount($date);
    $total_daily_deposit = $total_daily_saving + $total_daily_loan;
    $total_monthly_saving = Agents::getMonthlyTotalSavingCollectionAmount($month);
    $total_monthly_loan = Agents::getMonthlyTotalLoanCollectionAmount($month);
    $total_expense = Agents::getMonthlyTotalExpenseCollectionAmount($month);
    $total_monthly_deposit = $total_monthly_saving + $total_monthly_loan;
    $total_balance = $total_monthly_deposit - $total_expense;
    $data = [
      'agents_list'=>$agents_list,
      'total_daily_saving'=>$total_daily_saving,
      'total_daily_loan'=>$total_daily_loan,
      'total_daily_deposit'=>$total_daily_deposit,
      'total_monthly_saving'=>$total_monthly_saving,
      'total_monthly_loan'=>$total_monthly_loan,
      'total_monthly_deposit'=>$total_monthly_deposit,
      'total_expense'=>$total_expense,
      'total_balance'=>$total_balance,
      'date'=>$date
    ];
    return $data;
  }
  
  public function getMonth($date){
    $date_arr = explode("-",$date);
    $month = $date_arr[0]."-".$date_arr[1];
    return $month;
  }
  
  public function getAgentSummaryList(Request $request){
    $date= $this->dateFormat($request->dashboard_date);
    $data = $this->getData($date);
    echo view('admin/agent_summary_list',$data);
    exit;
  }
  
  public function listStaff(Request $request){
    $staff = Staff::all();
    return view('admin/list_staff',['staff_list'=>$staff]);
  }
  
  public function addStaff(Request $request){
    return view('admin/add_staff');
  }
  
  public function editStaff(Request $request){
     $id = $request->segment('2');
     $staff = Staff::where('id', $id)->first();
     if ($staff) {
       return view('admin/edit_staff',compact('staff'));
     }else{
       return view('errors/record_not_found',['msg'=>'Record not Found']);
     }
  }
  
  public function updateStaff(Request $request, Staff $staff){
    // create the validation rules ------------------------
    $id = $request->id;
    $rules = Staff::updateRules($id);
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      $id = $request->id;
      return Redirect::to("admin/$id/editStaff")
          ->withErrors($validator)->withInput();
    }else{
      $this->updateStaffRecord($request);
    }
    return redirect('admin/listStaff');
  }
  
  public function createStaff(Request $request,  Staff $staff){
    $rules = Staff::createRules();
    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      return Redirect::to('admin/addStaff')
          ->withErrors($validator)->withInput();
    }else{
      $this->saveStaff($request, $staff);
    }
    return redirect('admin/listStaff');
  }
  
  public function updateStaffRecord($request){
    $status_id = ((isset($request->status_id)==true))?"1":"0";
    $mobile_no = ((isset($request->mobile_no)==true))?$request->mobile_no:"";
    
    $id = $request->id;
    $update_staff = array(
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'email' =>$request->email,
      'username' => $request->username,
      'password' => md5($request->password),
      'mobile_no' => $mobile_no,
      'status_id' => $status_id,
      'added_on' => Carbon::now()->format('Y-m-d H:i:s')
    );
    Staff::find($id)->update($update_staff);
  }
  
  public function saveStaff($request,$staff){
    $status_id = ((isset($request->status_id)==true))?"1":"0";
    $mobile_no = ((isset($request->mobile_no)==true))?$request->mobile_no:"";
    $staff->first_name = $request->first_name;
    $staff->last_name = $request->last_name;
    $staff->email = $request->email;
    $staff->username = $request->username;
    $staff->password = md5($request->password);
    $staff->mobile_no = $mobile_no;
    $staff->status_id = $status_id;
    $staff->added_on = Carbon::now()->format('Y-m-d H:i:s');
    $staff->save();
  }
  
  public function deleteStaff(Request $request){
    $id = $request->id;
    $staff = Staff::where('id', $id)->first();
    if ($staff) {
      Staff::destroy($id);
      return "success";
    }else{
      return "record not found";
    }
  }
  
  public function getAdminProfile(Request $request){
    $admin = $request->session()->get('admin');
    $id = $admin->id;
    $admin = Admin::where('id', $id)->first();
    return view('admin/profile',['admin'=>$admin]);
  }
  
  public function updateProfile(Request $request){
    $id = $request->id;
    $admin = Admin::where('id', $id)->first();
    if($admin){
      $rules = Admin::updateRules($id);
      $validator = Validator::make(Input::all(), $rules);
      if ($validator->fails()) {
        return Redirect::to("admin/profile")
            ->withErrors($validator)->withInput();
      }else{
        $update_profile = array(
          'first_name' => $request->first_name,
          'last_name' => $request->last_name,
          'email' => $request->email,
          'username' => $request->username,
          'password' => md5($request->password),
          'added_on' => Carbon::now()->format('Y-m-d H:i:s')
        );
        Admin::find($id)->update($update_profile);
        return  Redirect::to("/logout");
      }
    }else{
      return Redirect::to("/admin");
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
