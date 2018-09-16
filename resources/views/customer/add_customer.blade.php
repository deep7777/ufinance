@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <span>Add Customer</span>
        <div class="pull-right">
          <a type="button" class="btn-sm btn-primary" href="{{url('/customer/listCustomer')}}">Back</a>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        @if (count($errors) > 0)
          <div class="alert alert-danger text-center">
            <div>
              @foreach ($errors->all() as $error)
                <div class="">{{ $error }}</div>
              @endforeach
            </div>
          </div>
        @endif
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <strong>{{ $message }}</strong>
            </div>
        @endif
        <br />
        <form action ="{{url('/customer/createCustomer')}}" method="POST"  data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <input type="hidden" id="frm_type" name="frm_type" value="add" />
          <input type="hidden" name="customer_id" value="{{ $customer_id }}" />
          <input type="hidden" id="customer_account_no" name="customer_account_no" value="{{ $customer_account_no }}" />
          <input class="customer_reg_no" type="hidden" name="customer_reg_no" value="{{ $customer_reg_no }}" />
          <input class="org_customer_reg_no" type="hidden" name="org_customer_reg_no" value="{{ $customer_reg_no }}" />
          <div class="form-group col-xs-12">
            <div class="form-group col-md-6">
            <label class="control-label requiredField" for="agent_name">
             Agent Name
             <span class="asteriskField">*</span>
            </label>
            <select class="select form-control" id="customer_agent_id" name="customer_agent_id" required="">
            <option value="">Select Agent</option>  
            @foreach($agents_list as $agent)
            <option value="{{$agent->agent_id}}">{{$agent->agent_first_name." ".$agent->agent_last_name}}</option>
            @endforeach 
            </select>
            </div>
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="account_type_id">
              Account Type
             <span class="asteriskField">*</span>
             </label>
             <select class="select form-control" required="" id="account_type_id" name="account_type_id">
              <option value="">Select Deposit Type</option>   
              @foreach($deposit_types as $deposit)
              <option value="{{$deposit->deposit_type_id}}">
               {{$deposit->deposit_type}}
              </option>
              @endforeach
             </select>
            </div>
          </div>
          <div class="form-group col-xs-12">
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="customer_account_no">
              Account No
              <span class="asteriskField">*</span>
             </label>
              <input readonly="readonly" required="" value="{{$customer_account_no}}" class="form-control" id="customer_account_no" name="customer_account_no" type="text"/>
            </div>
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="customer_id">
              Customer Id
              <span class="asteriskField">*</span>
             </label>
              <input required="" readonly="readonly" value="{{$customer_id}}"  class="form-control" id="customer_id" name="customer_id" type="text"/>
            </div>
          </div>
          <div class="form-group col-xs-12">
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="customer_first_name">
              Customer First Name
              <span class="asteriskField">*</span>
             </label>
             <input required="" class="form-control" id="customer_first_name" name="customer_first_name" type="text"/>
            </div>
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="customer_last_name">
              Contact Last Name
              <span class="asteriskField">*</span>
             </label>
             <input required="" class="form-control" id="customer_last_name" name="customer_last_name" type="text"/>
            </div>
          </div>
          <div class="form-group col-xs-12">
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="customer_middle_name">
              Customer Middle Name
             </label>
             <input class="form-control" id="customer_middle_name" name="customer_middle_name" type="text"  />
            </div>
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="account_type_id">
              Gender
             <span class="asteriskField">*</span>
             </label>
             <select class="select form-control" required="" id="customer_gender" name="customer_gender">
              <option value="1">Male</option>
              <option value="2">Female</option>
             </select>
            </div>
          </div>
          <div class="form-group col-xs-12">
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="customer_contact_no">
              Contact No
              <span class="asteriskField">*</span>
             </label>
             <input required="" class="form-control" id="customer_contact_no" name="customer_contact_no" type="text"/>
            </div>
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="customer_account_opening_date">
              Opening Date
              <span class="asteriskField">*</span>
             </label>
             <input required="" class="form-control" id="customer_account_opening_date" name="customer_account_opening_date" type="text" onkeydown="return false" />
            </div>
          </div> 
          <div class="form-group col-xs-12">
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="customer_daily_deposit">
              Daily Deposit
              <span class="asteriskField">*</span>
             </label>
             <input required="" class="form-control" id="customer_daily_deposit" name="customer_daily_deposit" type="text"/>
            </div>
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="customer_total_deposit">
              Total Deposit
             </label>
             <input class="form-control" id="total_deposit" name="customer_total_deposit" type="text"/>
            </div>
            <div class="form-group col-md-6"></div>
          </div>  
          <div class="form-group col-xs-12">  
            <div class="form-group col-md-6">
             <label class="control-label " for="customer_address">
              Address
             </label>
             <textarea class="form-control" cols="40" id="customer_address" name="customer_address" rows="4"></textarea>
            </div>
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="customer_area">
             Area
             <span class="asteriskField">*</span>
            </label>
            <input class="form-control" id="customer_area" name="customer_area" type="text" required=""/>
            </div>
          </div>  
          <div class="form-group col-xs-12">
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="customer_account_status_id">
              Account Status
              <span class="asteriskField">*</span>
             </label>
             <select class="select form-control" id="customer_account_status_id" name="customer_account_status_id">
              @foreach($account_status as $account)
              <option value="{{$account->account_status_id}}">
               {{$account->status_name}}
              </option>
              @endforeach
             </select>
            </div>
            <div class="form-group col-md-6 customer_account_reopening_date">
              <label class="control-label " for="customer_account_reopening_date">
               Reopening Date
               <span class="asteriskField">*</span>
              </label>
              <input  class="form-control" id="customer_account_reopening_date" name="customer_account_reopening_date" type="text" onkeydown="return false" />
            </div>
          </div>  
          <div class="form-group col-xs-12">
            <div class="form-group col-md-6">
             <label class="control-label ">
              Loan Taken
             </label>
              <div>
              <div class="checkbox">
               <label class="checkbox">
                <input name="customer_loan_taken" type="checkbox" value="Loan Taken"/>
                Loan Taken
               </label>
              </div>
              </div>
            </div>
          </div> 
          
          <div class="x_title account_fd_or_rd">
             <span>Account Details</span>
             <div class="clearfix"></div>
          </div>
          <div class="form-group col-xs-12 account_fd_or_rd">
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="customer_reg_no">
              Reg No
              <span class="asteriskField">*</span>
             </label>
              <input readonly="readonly" value="{{$customer_reg_no}}" class="form-control customer_reg_no account_details" id="customer_reg_no" name="customer_reg_no" type="text"/>
            </div>
            <div class="form-group col-md-6 account_fd_or_rd">
             <label class="control-label requiredField" for="customer_amount">
              Customer Amount
              <span class="asteriskField">*</span>
             </label>
             <input data-parsley-type="number" class="form-control account_details" id="customer_amount" name="customer_amount" type="text"/>
            </div>
          </div>
          <div class="form-group col-xs-12 account_fd_or_rd">
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="customer_tenure">
              Tenure
              <span class="asteriskField">*</span>
             </label>
             <input data-parsley-type="number" class="form-control account_details" id="customer_tenure" name="customer_tenure" type="text"/>
            </div>
            <div class="form-group col-md-6 account_fd_or_rd">
             <label class="control-label requiredField" for="customer_interest_rate">
              Interest Rate
              <span class="asteriskField">*</span>
             </label>
             <input class="form-control account_details" id="customer_interest_rate" name="customer_interest_rate" type="text"/>
            </div>
          </div>
          <div class="form-group col-xs-12 account_fd_or_rd">
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="customer_account_maturity_date">
              Maturity Date
              <span class="asteriskField">*</span>
             </label>
             <input onkeydown="return false" class="form-control account_details" id="customer_account_maturity_date" name="customer_account_maturity_date" type="text"/>
            </div>
            <div class="form-group col-md-6 account_fd_or_rd">
             <label class="control-label requiredField" for="customer_maturity_value">
              Maturity Value
              <span class="asteriskField">*</span>
             </label>
             <input class="form-control account_details" id="customer_maturity_value" name="customer_maturity_value" type="text"/>
             </div>
          </div>  
          <div class="ln_solid col-xs-12"></div>
          <div class="form-group pull-right">
            <div class="col-md-9 text-right">
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection