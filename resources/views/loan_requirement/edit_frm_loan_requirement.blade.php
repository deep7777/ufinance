<input type="hidden" id="url" name="url" value="{{ url("/") }}" />
<input type="hidden" name="id" value="{{ $customer->loan_requirement_id }}" />
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
   <input value="{{$customer->loan_requirement_amount}}" data-parsley-type="number" required="" class="form-control" id="loan_requirement_amount" name="loan_requirement_amount" type="text"/>
  </div>
  <div class="form-group col-md-6">
   <label class="control-label requiredField" for="loan_file_login_date">
    Loan File Login Date
    <span class="asteriskField">*</span>
   </label>
   <input value="{{dmy($customer->loan_file_login_date)}}"required="" class="form-control date_class" id="loan_file_login_date" name="loan_file_login_date" type="text"/>
  </div>
</div>
<div class="form-group col-xs-12">
  <div class="form-group col-md-6">
   <label class="control-label requiredField" for="loan_approved_amount">
    Estimated Loan Approved Amount
   </label>
   <input value="{{$customer->loan_approved_amount}}" class="form-control" id="loan_approved_amount" name="loan_approved_amount" type="text" />
  </div>
  <div class="form-group col-md-6">
   <label class="control-label requiredField" for="loan_approved_date">
    Estimated Loan Approved Date
   </label>
   <input value="{{dmy($customer->loan_approved_date)}}" class="form-control date_class" id="loan_approved_date" name="loan_approved_date" type="text"/>
  </div>
</div> 
<div class="form-group col-xs-12">
  <div class="form-group col-md-6">
   <label class="control-label requiredField" for="loan_in_hand_amount">
    Loan In Hand Amount
   </label>
   <input value="{{$customer->loan_in_hand_amount}}" data-parsley-type="number" class="form-control" id="loan_in_hand_amount" name="loan_in_hand_amount" type="text"/>
  </div>
  <div class="form-group col-md-6">
   <label class="control-label requiredField" for="loan_per_day_collection">
    Loan Per Day Collection
   </label>
   <input value="{{$customer->loan_per_day_collection}}" data-parsley-type="number" class="form-control" id="loan_per_day_collection" name="loan_per_day_collection" type="text"/>
  </div>
</div>
<div class="form-group col-xs-12">
  <div class="form-group col-md-6">
   <label class="control-label requiredField" for="loan_received_date">
    Loan Received Date
    <span class="asteriskField">*</span>
   </label>
   <input  value="{{dmy($customer->loan_received_date)}}" required="" class="form-control date_class loan_closing_date" id="loan_received_date" name="loan_received_date" type="text" onkeydown="return false" />
  </div>
  <div class="form-group col-md-6">
   <label class="control-label requiredField" for="customer_account_opening_date">
    Loan Closed Date
    <span class="asteriskField">*</span>
   </label>
   <input  value="{{dmy($customer->loan_closing_date)}}" required="" class="form-control date_class" id="loan_closing_date" name="loan_closing_date" type="text" onkeydown="return false" />
  </div>
</div>
<div class="form-group col-xs-12">
  <div class="form-group col-md-6">
   <label class="control-label requiredField" for="loan_tenure">
   Loan Tenure (In Days)
   <span class="asteriskField">*</span>
  </label>
  <input value="{{$customer->loan_tenure}}" data-parsley-type="number"class="form-control loan_closing_date" id="loan_tenure" name="loan_tenure" type="text" required=""/>
  </div>
  <div class="form-group col-md-6">
  <label class="control-label requiredField" for="agent_name">
   Loan Account Status
  </label>
  <select class="select form-control" id="loan_account_status_id" name="loan_account_status_id">
  <option value="">Select Status</option>  
  @foreach($loan_account_status as $account)
  @if($account->loan_account_status_id==$customer->loan_account_status_id)
  <option selected="selected" value="{{$account->loan_account_status_id}}">{{$account->draft}}</option>
  @else
  <option value="{{$account->loan_account_status_id}}">{{$account->draft}}</option>
  @endif
  @endforeach 
  </select>
  </div>
</div>

<div class="form-group col-xs-12">
  <div class="form-group col-md-6">
  <label class="control-label requiredField" for="agent_name">
   Loan Status
  </label>
  <select class="select form-control" id="loan_status_id" name="loan_status_id">
  @foreach($loan_status as $loan_status)
  @if($loan_status->loan_status_id==$customer->loan_status_id)
  <option selected="selected" value="{{$loan_status->loan_status_id}}">{{$loan_status->account}}</option>
  @else
  <option value="{{$loan_status->loan_status_id}}">{{$loan_status->account}}</option>
  @endif
  @endforeach 
  </select>
  </div>
  <div class="form-group col-md-6">
  <label class="control-label requiredField" for="agent_name">
   Loan Received 
  </label>
  <select class="select form-control" id="loan_received_id" name="loan_received_id">
  <option value="">Select Status</option>  
  @foreach($loan_received as $loan_received)
  @if($loan_received->loan_received_id==$customer->loan_received_id)
  <option selected="selected" value="{{$loan_received->loan_received_id}}">{{ $loan_received->status }}</option>
  @else
  <option  value="{{$loan_received->loan_received_id}}">{{ $loan_received->status }}</option>
  @endif
  @endforeach 
  </select>
  </div>
</div>
@if($show_fields=="1")
<div class="form-group col-xs-12">
  <div class="form-group col-md-6">
   <label class="control-label requiredField" for="loan_amount_to_be_received">
   Loan Amount To Be Received
  </label>
  <input readonly="" value="{{$loan_amount_to_be_received}}" data-parsley-type="number"class="form-control loan_closing_date" id="loan_amount_to_be_received" name="loan_amount_to_be_received" type="text"/>
  </div>
  <div class="form-group col-md-6">
   <label class="control-label requiredField" for="total_interest">
   Total Interest
  </label>
    <input readonly="" value="{{$total_interest}}" class="form-control loan_closing_date" id="total_interest" name="total_interest" type="text"/>
  </div>
</div>
@endif
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
    @if($customer->loan_document_list!='null' && in_array($document->document_id,json_decode($customer->loan_document_list)))
    <input checked="checked" type="checkbox" class="" value="{{$document->document_id}}" name="loan_document_list[]"/>
    @else
    <input type="checkbox" class="" value="{{$document->document_id}}" name="loan_document_list[]"/>              
    @endif
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
   <textarea class="form-control" cols="40" id="loan_comment" name="loan_comment" rows="4">{{$customer->loan_comment}}</textarea>
  </div>
</div>
<div class="ln_solid col-xs-12"></div>
<div class="form-group pull-right">
  <div class="col-md-9 text-right">
    <button type="submit" class="btn btn-success">Submit</button>
  </div>
</div>