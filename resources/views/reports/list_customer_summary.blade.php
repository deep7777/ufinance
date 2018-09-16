@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 blue">
  <div class="x_panel">
    <div class="x_title">
      <div>
        All Customer Data
      </div>      
      <div class="clearfix"></div>
    </div>
    <div class="x_content loan">
      <form id="frm_customer_report">
      {{csrf_field()}}
      <div class="form-group col-xs-12">
        <div class="form-group col-md-2">
         <label class="control-label requiredField" for="customer_account_no">
          Agents
         </label>
          <select class="select form-control" id="agent_id" name="agent_id" required="">
          <option value="">Select Agent</option>  
          @foreach($agents_list as $agent)
          <option value="{{$agent->agent_id}}">{{$agent->agent_first_name." ".$agent->agent_last_name}}</option>
          @endforeach   
          </select>
        </div>
        <div class="form-group col-md-2">
         <label class="control-label requiredField" for="account_status_id">
          Account Status
         </label>
         <select class="select form-control" id="account_status_id" name="account_status_id" required="">
          <option value="">All</option>
          @foreach($account_status as $key=>$account_status)
          <option value="{{$key}}">{{$account_status}}</option>
          @endforeach 
          </select> 
        </div>
        <div class="form-group col-md-2">
         <label class="control-label requiredField" for="account_status_id">
          Account Type
         </label>
         <select class="select form-control" id="account_type_id" name="account_type_id" required="">
          <option value="">All</option>
          @foreach($account_type as $account_type)
          <option value="{{$account_type->deposit_type_id}}">{{$account_type->deposit_type}}</option>
          @endforeach 
          </select> 
        </div>
        <div class="form-group col-md-3">
          <label class="control-label requiredField">
          Account Number
          </label>
          <select class="select form-control" id="customer_account_no" name="customer_account_no" required="">
          <option value="">Select Account Number</option>  
          @foreach($customers_list as $customer)
          <option value="{{$customer->customer_account_no}}">{{$customer->customer_account_no}}</option>
          @endforeach 
          </select> 
        </div>
        <div class="form-group col-md-3 hidden">
          <label class="control-label requiredField">
          Search By Name
          </label>
          <select class="select form-control" id="customer_account_name" name="customer_account_name" required="">
          <option value="">Select Customer Name</option>  
          @foreach($customers_name_list as $customer)
          <option value="{{$customer->customer_account_no}}">{{getCustomerName($customer)}}</option>
          @endforeach 
          </select> 
        </div>
      </div>
      <div class="form-group col-xs-12">
        <div class="form-group col-md-4">
          <button id="customer_report" type="button" class="btn btn-success btn-large">Get Data</button>
          <button id="customer_report_reset" type="button" class="btn btn-info btn-large">Reset</button>
        </div>
      </div>
       <div class="col-sm-12 customer_report_data"></div>
      </form>
      
    </div>
  </div>
</div>
</div>  
@endsection