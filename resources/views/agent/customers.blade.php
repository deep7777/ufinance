<div class="form-group col-md-4 agent_customers_list">
  <label class="control-label requiredField" for="customer_name">
   Customer Name
   <span class="asteriskField">*</span>
  </label>
  <select class="select form-control" id="search_customer_id" name="search_customer_id" required="">
  <option value="">Select Customer</option>  
  @foreach($customers_list as $customer)
    <option value="{{$customer->customer_id}}">{{getCustomerName($customer)}}</option>
  @endforeach 
  </select>
</div>