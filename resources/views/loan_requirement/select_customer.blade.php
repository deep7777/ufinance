@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <span>Loan Requirement</span>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        @include('validate/errors')
        @include('validate/success')
        <br />
        <form action ="{{url('/loan_requirement/createRequirement')}}" method="POST"  data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <input id="url" type="hidden" value="{{url("/")}}">
          <div class="form-group col-xs-12">
            <div class="form-group col-md-4 agent_customers">
            <label class="control-label requiredField" for="agent_name">
             Agent Name
             <span class="asteriskField">*</span>
            </label>
            <select class="select form-control" id="search_customer_agent_id" name="search_customer_agent_id" required="">
            <option value="">Select Agent</option>  
            @foreach($agents_list as $agent)
            <option value="{{$agent->agent_id}}">{{$agent->agent_first_name." ".$agent->agent_last_name}}</option>
            @endforeach 
            </select>
            </div>
            <div class="form-group col-md-4">
             <label class="control-label requiredField" for="account_type_id">
              Enter|Select Customer Account No
             </label>
              <input  id="txt-customers-data-list" class="form-control customers-search" list="customers-data-list">
              <datalist id="customers-data-list">
                @foreach($agent_customers as $customer)
                <option customer-id="{{$customer->customer_id}}" value="{{ $customer->customer_account_no."->".$customer->customer_first_name."->".$customer->agent_first_name." ".$customer->agent_last_name}}">
                @endforeach   
              </datalist>
              <br />
              <button style="display:none;" id="reset-customers" class="btn-small" type="button">Reset</button>
            </div>
          </div>
        </form>
        <div class="row">
        <div class="col-sm-12">
          <div class="card-box table-responsive">
            <table id="data-keytable-list" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Account No</th>
                  <th>File Date</th>
                  <th>Required Amount</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($customers_list as $customer)
                  <tr>
                    <td>{{getCustomerName($customer)}}</td>
                    <td>{{$customer->customer_account_no}}</td>
                    <td>{{dmy($customer->loan_file_login_date)}}</td>
                    <td>{{$customer->loan_requirement_amount}}</td>
                    <td>{{$customer->draft}}</td>
                    <td>
                      <a href="{{url('/loan_requirement/editLoanRequirement/'.$customer->loan_requirement_id)}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>
</div>
@endsection