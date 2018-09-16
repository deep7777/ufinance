@extends('layouts.main')
@section('content')
<div class="row">

<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_content">
      @include('validate/errors')
      @include('validate/success')
      <br />
      <form id="frm_customer_daily_entry" action ="{{url('/customer/addDailyCollection')}}" method="POST"  data-parsley-validate class="form-horizontal form-label-left">
        {{ csrf_field() }}
        <input type="hidden" id="url" value="{{url("/")}}">
        <input type="hidden" name="agent_id" value="{{$agent->agent_id}}">
        <div class="form-group col-xs-12">
          <div class="form-group col-md-6">
          <label class="control-label requiredField" for="agent_name">
           Account No
          </label>
          <button id="btn-customer" type="button" class="btn btn-primary btn-sm">Search</button>
          <label style="display:none;" id="error_msg" class="control-label red" for="agent_name">Account Not Found</label>
          <input id="customer_account_no" name="customer_account_no" value="UF-"  class="form-control customer_account_no"  type="text"/>
          </div>
        </div>
        <div class="form-group col-xs-12">
          <div class="form-group col-md-6">
            <label class="control-label requiredField" for="customer_id">
             Customer Name
             <span class="asteriskField">*</span>
            </label>
            <input readonly="readonly" value=""  class="form-control clear-all" id="customer_name" type="text"/>
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
          <div class="form-group col-md-6 green">
          <label class="control-label requiredField" for="current_date">
           Daily Saving Collection Amount
           <span class="asteriskField">*</span>
          </label>
          <input  data-parsley-type="number" name="daily_saving_collection_amount" value=""  class="form-control clear-all" type="text"/>
          </div>
          <div class="form-group col-md-6 green">
          <label class="control-label requiredField" for="total_deposit">
           Total Saving Deposit
          </label>
          <input readonly="readonly" value=""  class="form-control clear-all" id="total_saving_deposit" type="text"/>
          </div>
        </div>
        
        <div class="form-group col-xs-12 loan_account">
          <div class="form-group col-md-6 blue">
          <label class="control-label requiredField" for="daily_collection_amount">
           Daily Loan Collection Amount
           <span class="asteriskField">*</span>
          </label>
          <input data-parsley-type="number" name="daily_loan_collection_amount" value=""  class="form-control clear-all " type="text"/>
          </div>
          <div class="form-group col-md-6 blue">
          <label class="control-label requiredField" for="total_deposit">
           Total Loan Deposit
           <span class="asteriskField">*</span>
          </label>
          <input readonly="readonly" value=""  class="form-control clear-all" id="total_loan_deposit" type="text"/>
          </div>
        </div>
        <div class="form-group col-xs-12 ln_solid"></div>
        <div class="form-group col-xs-12">
          <div class="form-group col-md-6">
            <button style="display:none;" id="btn-submit" type="submit" class="btn btn-success">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<input type='hidden' id="url" value="{{ url('/') }}">
@endsection