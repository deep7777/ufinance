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
        <form id="frm_saving" action ="{{url('/saving/addCustomerSaving')}}" method="POST"  data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <input id="url" type="hidden" value="{{url("/")}}">
          <div class="row">
          <div class="form-group col-md-12">
            <label class="control-label requiredField blue" for="saving-customers-data-list">
             Type | Select Customer Account No
            </label>
             <input  id="txt-saving-customers-data-list" class="form-control" list="saving-customers-data-list">
             <datalist id="saving-customers-data-list">
               @foreach($agent_customers as $customer)
               <option customer-account-no="{{$customer->customer_account_no}}" value="{{ $customer->customer_account_no."->".$customer->customer_first_name." ".$customer->customer_last_name."->".$customer->agent_first_name." ".$customer->agent_last_name}}">
               @endforeach   
             </datalist>
           </div>
          </div>  
          <div class="clearfix"></div>
          <div class="row saving-customers-search-detail">
            <div class="form-group col-md-2">
              <label class="control-label requiredField" for="customer_account_no">
              Account No {{required_str()}}
              </label>
              <input required='' id="customer_account_no" value="{{$customer_account_no}}" name="customer_account_no" class="form-control">
            </div>
            <div class="form-group col-md-2">
              <label class="control-label requiredField" for="saving-month-year">
              Date
              </label>
              <input id="month_year" value="{{getCurrentMonthYear()}}" name="month_year" class="form-control month-picker" style="display:block;" onkeydown="return false">
            </div>
            <div class="form-group col-md-2">
             <label class="control-label requiredField" for="customer_name">
              Customer Name 
             </label>
              <input readonly="readonly" required="" value="" class="form-control clear-all" id="customer_name" name="customer_name" type="text"/>
            </div>
            <div class="form-group col-md-2">
             <label class="control-label requiredField" for="total_deposit">
              Total Deposit Amount
             </label>
              <input readonly="readonly" value="" class="form-control clear-all" id="total_deposit"  type="text"/>
            </div>
            <div class="form-group col-md-2">
             <label class="control-label requiredField" for="customer_agent_name">
              Agent Name
              <span class="asteriskField">*</span>
             </label>
              <input type="hidden" name="agent_id" id="agent_id" value=""  class="form-control clear-all"  type="text"> 
              <input readonly="readonly" required="" value="" class="form-control clear-all" id="agent_name" name="agent_name" type="text"/>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="clearfix saving_customer_data"></div>
        </form>
      </div>
  </div>
</div>
@endsection
