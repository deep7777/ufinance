@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Saving Data</h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
        @include('validate/errors')
        @include('validate/success')
        <br />
        <form id="frm_customer_saving_staff" action ="{{url('/saving/addCustomerSavingFromStaff')}}" method="POST"  data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <input id="url" type="hidden" value="{{url("/")}}">
          <div class="form-group col-xs-12 saving-customers-search-detail">
            <div class="form-group col-md-3">
              <label class="control-label requiredField" for="customer_account_no">
              Account No {{required_str()}}
              </label>
              <input required='' id="customer_account_no" value="UF-" name="customer_account_no" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label style="display:none;" id="account_not_found" class="red control-label requiredField" for="customer_account_no">Account Not found</label>
            </div>
          </div>
          <div class="form-group col-xs-12">
            <div class="form-group col-md-3">
             <label class="control-label requiredField" for="customer_name">
              Customer Name 
             </label>
              <input readonly="readonly" required="" value="" class="form-control clear-all" id="customer_name" name="customer_name" type="text"/>
            </div>
            <div class="form-group col-md-3">
             <label class="control-label requiredField" for="total_deposit">
              Total Deposit Amount
             </label>
              <input readonly="readonly" value="" class="form-control clear-all" id="total_deposit"  type="text"/>
            </div>
            <div class="form-group col-md-3">
             <label class="control-label requiredField" for="customer_agent_name">
              Agent Name
              <span class="asteriskField">*</span>
             </label>
              <input type="hidden" name="agent_id" id="agent_id" value=""  class="form-control clear-all"  type="text"> 
              <input readonly="readonly" required="" value="" class="form-control clear-all" id="agent_name" name="agent_name" type="text"/>
            </div>
          </div>
          <div class="form-group col-xs-12">
            <div class="form-group col-md-3">
             <label class="control-label requiredField" for="previous_date">
             Previous Date
             </label>
              <input readonly="readonly" required="" value="{{dmy($previous_date)}}" class="form-control clear-all" id="previous_date" name="previous_date" type="text"/>
            </div>
            <div class="form-group col-md-3">
             <label class="control-label requiredField" for="total_deposit">
              Amount
             </label>
              <input value="" class="form-control clear-all" id="previous_date_amount"  name="previous_date_amount" type="text"/>
            </div>
          </div>
          <div class="form-group col-xs-12">
            <div class="form-group col-md-3">
             <label class="control-label requiredField" for="current_date">
             Current Date
             </label>
              <input readonly="readonly" required="" value="{{$current_date}}" class="form-control clear-all" id="current_date" name="current_date" type="text"/>
            </div>
            <div class="form-group col-md-3">
             <label class="control-label requiredField" for="total_deposit">
              Amount
             </label>
              <input value="" class="form-control clear-all" id="current_date_amount"  name="current_date_amount" type="text"/>
            </div>
          </div>
          <div class="ln_solid col-xs-12"></div>
          <div class="form-group col-xs-12">
            <div class="text-left">
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </div>
        </form>
      </div>
  </div>
</div>
@endsection
