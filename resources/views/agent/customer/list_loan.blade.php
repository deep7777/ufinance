@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Loan</h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <br />
      @include('validate/errors')
      @include('validate/success')
      <br />
      <form id="frm_customer_loan" action ="{{url('/customer/addLoanDailyCollection')}}" method="POST"  data-parsley-validate class="form-horizontal form-label-left">
        {{ csrf_field() }}
        <input type="hidden" id="url" value="{{url("/")}}">
        <input type="hidden" name="agent_id" value="{{$agent->agent_id}}">        
        <div class="form-group col-xs-12">
          <div class="form-group col-md-6">
            <label class="control-label requiredField" for="customer_id">
             Customer Name
             <span class="asteriskField">*</span>
            </label>
            <select class="select form-control" id="customer_account_no" name="customer_account_no" required="">
            <option value="">Select Customer</option>  
            @foreach($agent_customers as $customer)
            <option value="{{$customer->customer_account_no}}">{{getCustomerName($customer)}}</option>
            @endforeach 
            </select>
          </div>
          <div class="form-group col-md-6">
          <label class="control-label requiredField" for="agent_name">
           Account No
           <span class="asteriskField">*</span>
          </label>
          <input name="account_no" value=""  class="form-control account_no"   type="hidden"/>
          <input readonly="readonly" value=""  class="form-control account_no"  type="text"/>
          </div>
        </div>
        <div class="form-group col-xs-12">
          <div class="form-group col-md-6">
          <label class="control-label requiredField" for="total_deposit">
           Total Deposit
           <span class="asteriskField">*</span>
          </label>
          <input readonly="readonly" value=""  class="form-control" id="total_deposit" type="text"/>
          </div>
          <div class="form-group col-md-6">
          <label class="control-label requiredField" for="current_date">
           Date
           <span class="asteriskField">*</span>
          </label>
          <input readonly="readonly" value="{{getCurrentDate()}}"  class="form-control" id="current_date" name="current_date" type="text"/>
          </div>
        </div>
        <div class="form-group col-xs-12">
          <div class="form-group col-md-6">
          <label class="control-label requiredField" for="current_date">
           Daily Collection Amount
           <span class="asteriskField">*</span>
          </label>
          <input required="" data-parsley-type="number" name="daily_collection_amount" value=""  class="form-control" type="text"/>
          </div>
        </div>
        <div class="form-group col-xs-12 ln_solid"></div>
        <div class="form-group col-xs-12">
          <div class="form-group col-md-6">
            <button type="submit" class="btn btn-success">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection