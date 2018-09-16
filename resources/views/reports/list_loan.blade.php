@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 blue">
  <div class="x_panel">
    <div class="x_title">
      <div>
        Loan Report
      </div>      
      <div class="clearfix"></div>
    </div>
    <div class="x_content loan">
      <form id="frm_loan_report">
      {{csrf_field()}}
      <div class="form-group col-xs-12">
        <div class="form-group col-md-3">
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
        <div class="form-group col-md-3">
         <label class="control-label requiredField" for="from_date">
          Loan Status
         </label>
         <select class="select form-control" id="account_status_id" name="account_status_id" required="">
          <option value="">All</option>
          @foreach($account_status as $account)
          <option value="{{$account->loan_status_id}}">{{$account->account}}</option>
          @endforeach 
          </select> 
        </div>
        <div class="form-group col-md-3 customer_details">
         <label class="control-label requiredField">
         Search By Account Number
         </label>
        </div>
      </div>
      <div class="form-group col-xs-12">
        <div class="form-group col-md-4">
          <button id="customer_loan_report" type="button" class="btn btn-success btn-large">Get Data</button>
          <button id="customer_loan_report_reset" type="button" class="btn btn-info btn-large">Reset</button>
        </div>
      </div>
       <div class="col-sm-12 customer_loan_report_data"></div>
      </form>
      
    </div>
  </div>
</div>
</div>  
@endsection