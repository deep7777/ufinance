@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <span>Loan  Requirement</span>
        <div class="pull-right">
          <a type="button" class="btn-sm btn-primary" href="{{url('/loan_requirement/selectCustomer')}}">Back</a>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        @include('validate/errors')
        @include('validate/success')
        <br />
        <form action ="{{url('/loan_requirement/createCustomerRequirement')}}" method="POST"  data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <input type="hidden" name="customer_id" value="{{ $customer->customer_id }}" />
          <input type="hidden" name="agent_id" value="{{ $customer->customer_agent_id }}" />
          <div class="form-group col-xs-12">
            <div class="form-group col-md-6">
            <label class="control-label requiredField" for="agent_name">
             Agent Name
             <span class="asteriskField">*</span>
            </label>
            <input required="" readonly="readonly" value="{{$customer->agent_first_name." ".$customer->agent_last_name}}"  class="form-control" id="agent_name" name="agent_name" type="text"/>
            </div>
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="customer_account_no">
              Account No
              <span class="asteriskField">*</span>
             </label>
              <input readonly="readonly" required="" value="{{$customer->customer_account_no}}" class="form-control" id="customer_account_no" name="customer_account_no" type="text"/>
            </div>
          </div>
          <div class="form-group col-xs-12">
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="account_type_id">
              Customer Name
             <span class="asteriskField">*</span>
             </label>
             <input required="" readonly="readonly" value="{{getCustomerName($customer)}}"  class="form-control" id="customer_name" name="customer_name" type="text"/>
            </div>
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="customer_account_opening_date">
              Opening Date
              <span class="asteriskField">*</span>
             </label>
             <input readonly value="{{dmy($customer->customer_account_opening_date)}}" required="" class="form-control" id="customer_account_opening_date" name="customer_account_opening_date" type="text" onkeydown="return false" />
            </div>
          </div>
          <div class="form-group col-xs-12">
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="loan_requirement_amount">
              Loan Requirement Amount
              <span class="asteriskField">*</span>
             </label>
             <input data-parsley-type="number" required="" class="form-control" id="loan_requirement_amount" name="loan_requirement_amount" type="text"/>
            </div>
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="loan_file_login_date">
              Loan File Login Date
              <span class="asteriskField">*</span>
             </label>
             <input required="" class="form-control date_class" id="loan_file_login_date" name="loan_file_login_date" type="text"/>
            </div>
          </div>
          <div class="form-group col-xs-12">
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="loan_approved_amount">
              Estimated Loan Approved Amount
             </label>
             <input class="form-control" id="loan_approved_amount" name="loan_approved_amount" type="text" />
            </div>
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="loan_approved_date">
              Estimated Loan Approved Date
             </label>
             <input  class="form-control date_class" id="loan_approved_date" name="loan_approved_date" type="text"/>
            </div>
          </div> 
          <div class="form-group col-xs-12">
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="loan_in_hand_amount">
              Loan In Hand Amount
             </label>
             <input data-parsley-type="number" class="form-control" id="loan_in_hand_amount" name="loan_in_hand_amount" type="text"/>
            </div>
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="loan_per_day_collection">
              Loan Per Day Collection
             </label>
             <input data-parsley-type="number" class="form-control" id="loan_per_day_collection" name="loan_per_day_collection" type="text"/>
            </div>
          </div>  
          <div class="form-group col-xs-12">
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="loan_tenure">
             Loan Tenure (In Days)
            </label>
            <input data-parsley-type="number"class="form-control" id="loan_tenure" name="loan_tenure" type="text"/>
            </div>
            
            <div class="form-group col-md-6">
            <label class="control-label requiredField" for="agent_name">
             Loan Account Status
            </label>
            <select class="select form-control" id="loan_account_status_id" name="loan_account_status_id">
            @foreach($loan_account_status as $account)
            <option value="{{$account->loan_account_status_id}}">{{$account->draft}}</option>
            @endforeach 
            </select>
            </div>
          </div>
          <div class="form-group col-xs-12">
            <div class="x_title">
              <span>Documents</span>
              <div class="clearfix"></div>
            </div>
            <div class="form-group col-md-12">
             @foreach($documents as $document)
              <div class="form-group col-md-2">
              <label class="control-label requiredField" for="loan_document_list">
               {{$document->document_name}}&nbsp;
              </label>
              <input type="checkbox" class="" value="{{$document->document_id}}" name="loan_document_list[]"/>
             </div>
             @endforeach
            </div>
          </div>
          <div class="ln_solid col-xs-12"></div>
          <div class="form-group col-xs-12">
            <div class="form-group col-md-6">
             <label class="control-label " for="loan_comment">
              Comment
             </label>
             <textarea class="form-control" cols="40" id="loan_comment" name="loan_comment" rows="4"></textarea>
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