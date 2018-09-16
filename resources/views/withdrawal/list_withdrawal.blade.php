@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Withdrawal Details</h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      @include('validate/errors')
      @include('validate/success')
      <br />
      <form id="frm_withdrawal" action ="{{url('/withdrawal/addCustomerWithdrawal')}}" method="POST"  data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <input id="url" type="hidden" value="{{url("/")}}">
          <div class="form-group col-xs-12">
            <div class="form-group col-md-4">
              <label class="control-label requiredField" for="customer_account_no">
              Account No {{required_str()}}
              </label>
              <input autocomplete="off" required="" name="customer_account_no" id="customer_account_no" value="UF-"  class="form-control account_no"  type="text">
            </div>
            <div class="form-group col-md-4">
              <label class="control-label requiredField" for="customer_account_no">
              Customer Name{{required_str()}}
              </label>
              <input readonly required="" id="customer_name" value=""  class="form-control clear-all"  type="text">
            </div>
            <div class="form-group col-md-4">
              <label class="control-label requiredField" for="customer_account_no">
              Agent Name {{required_str()}}
              </label>
              <input type="hidden" name="agent_id" id="agent_id" value=""  class="form-control clear-all"  type="text">
              <input readonly required="" id="agent_name" value=""  class="form-control clear-all account_no"  type="text">
            </div>
          </div>
          <div class="form-group col-xs-12">
            <div class="form-group col-md-4">
              <label class="control-label requiredField" for="total_deposit">
              Total Deposit {{required_str()}}
              </label>
              <input readonly required="" id="total_deposit" value="" name="total_deposit" class="form-control clear-all amount_in_hand"  type="text">
            </div>
            <div class="form-group col-md-4">
              <label class="control-label requiredField" for="withdrawal_date">
              Withdrawal Date {{required_str()}}
              </label>
              <input required="" id="withdrawal_date" value="{{date("d/m/Y")}}" name="withdrawal_date" class="form-control date_class"  onkeydown="return false">
            </div>
            <div class="form-group col-md-4">
              <label class="control-label requiredField" for="withdrawal_amount">
              Withdrawal Amount {{required_str()}}
              </label>
              <input data-parsley-error-message="This value should be less or equal to Total Deposit" data-parsley-le="#total_deposit" required="" id="withdrawal_amount" value="" name="withdrawal_amount" class="form-control clear-all amount_in_hand"  type="text">
            </div>
          </div>
          <div class="form-group col-xs-12">
            <div class="form-group col-md-4">
              <label class="control-label requiredField" for="withdrawal_percentage">
              Withdrawal Percentage % {{required_str()}}
              </label>
              <input required="" data-parsley-error-message="Not Valid" data-parsley-pattern="/^-?[0-9]\d*(\.\d+)?$/" id="withdrawal_percentage" value="" name="withdrawal_percentage" class="form-control clear-all amount_in_hand"  type="text">
            </div>
            <div class="form-group col-md-4">
              <label class="control-label requiredField" for="amount_in_hand">
               Amount In Hand {{required_str()}}
              </label>
              <input required="" id="amount_in_hand" value="" name="amount_in_hand" class="form-control clear-all amount_in_hand"  type="text">
            </div>
            <div class="form-group col-md-4">
              <label class="control-label requiredField" for="total_balance">
               Balance {{required_str()}}
              </label>
              <input required="" id="total_balance" value="" name="total_balance" class="form-control clear-all"  type="text">
            </div>
          </div>
          <div class="ln_solid col-xs-12"></div>
          <div class="form-group col-xs-12">
            <div class="col-md-1 text-right">
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </div>
          <div class="withdrawal_history"></div>
        </form>
    </div>
  </div>
</div>
@endsection
