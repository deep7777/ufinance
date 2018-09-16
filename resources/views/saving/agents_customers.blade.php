<div class="form-group col-md-3 agent_saving_customers">
  <label class="control-label requiredField" for="agent_name">Agent Name</label>
  <select class="select form-control" id="search_saving_customer_agent_id" name="search_saving_customer_agent_id">
  <option value="">Select Agent</option>  
  @foreach($agents_list as $agent)
  <option value="{{$agent->agent_id}}">{{$agent->agent_first_name." ".$agent->agent_last_name}}</option>
  @endforeach 
  </select>
</div>
<div class="form-group col-md-3">
  <label class="control-label requiredField" for="account_type_id">
   Select Customer Account No
  </label>
  <select class="select form-control" id="txt-saving-customers-data-list" name="txt-saving-customers-data-list">
  <option value="">Select Customer</option>  
  @foreach($agent_customers as $customer)
  <option value="{{$customer->customer_id}}">{{ $customer->customer_account_no."->".$customer->customer_first_name."->".$customer->agent_first_name." ".$customer->agent_last_name}}</option>
  @endforeach 
  </select>
  <br />
</div>