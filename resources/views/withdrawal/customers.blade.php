<label class="control-label requiredField" for="customer_name">
 Select Customer
 <span class="asteriskField">*</span>
</label>
<select class="select form-control" id="customer_account_no" name="customer_account_no" required="">
<option value="">Select Customer</option>  
@foreach($customers_list as $customer)
  <option value="{{$customer->customer_account_no}}">{{getCustomerName($customer)}}</option>
@endforeach 
</select>