<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\AgentCustomers;
class ExportController extends Controller
{
  public function __construct(Request $row){
    //$this->middleware('userAuth');    
  }
  
  public function index(Request $request){
    echo "Exporting File Started ...... \n";
    echo "Exporting File end ......";
    $fName = "customer1.csv";
    $file_name = public_path("exports/$fName");
    echo $file_name;
    //$customer = AgentCustomers::class;
    Excel::load($file_name, function($reader) {
      $reader->each(function($row) {
        $customer = new AgentCustomers;
        $customer->customer_agent_id = $row->customer_agent_id;
        $customer->account_type_id = $row->account_type_id;
        $customer->customer_account_no = $row->customer_account_no;
        $customer->customer_first_name = ucwords($row->customer_first_name);
        $customer->customer_middle_name = ucwords($row->customer_middle_name);
        $customer->customer_last_name = ucwords($row->customer_last_name);
        $customer->customer_gender = $row->customer_gender;
        $customer->customer_contact_no = $row->customer_contact_no;
        $customer->customer_account_opening_date = $row->customer_account_opening_date;
        $customer->customer_daily_deposit = $row->customer_daily_deposit;
        $customer->customer_address = $row->customer_address;
        $customer->customer_area = $row->customer_area;
        $customer->customer_account_status_id = $row->customer_account_status_id;
        
        $customer->customer_loan_taken = (isset($row->customer_loan_taken)=="true")?"1":"0";
        $customer->customer_total_deposit_amount = (isset($row->customer_total_deposit_amount)==true)?$row->customer_total_deposit_amount:"0";
        if($row->account_type_id=="3"||$row->account_type_id==4){
          $customer->customer_reg_no = $row->customer_reg_no;
          $customer->customer_amount = $row->customer_amount;
          $customer->customer_account_maturity_date = $this->dateFormat($row->customer_account_maturity_date);
          $customer->customer_interest_rate = $row->customer_interest_rate;
          $customer->customer_tenure = $row->customer_tenure;
          $customer->customer_maturity_value = $row->customer_maturity_value;
        }
        $customer->save();
        echo "<br>\n";
      });
    });

   
  }
  
  
}
