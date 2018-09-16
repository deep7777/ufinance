<div class="form-group col-xs-12">
  <div class="form-group col-md-4 red">
   <label class="control-label requiredField" for="collection_date">
    Total Saving Amount : {{$total_saving_amount}}
   </label>
  </div>
  <div class="form-group col-md-4 red">
   <label class="control-label requiredField" for="collection_date">
    Total Loan Amount : {{$total_loan_amount}}
   </label>
  </div>
  <div class="form-group col-md-4 red">
   <label class="control-label requiredField" for="collection_date">
    Total Amount : {{$total_saving_amount+$total_loan_amount}}
   </label>
  </div>
</div>
<table id="data-keytable-list" class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>Account No </th>
      <th>Name</th>
      <th>Collection Amount</th>
      <th>Type</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($customer_reports as $customer)
      <tr>
        <td>{{$customer->customer_account_no}}</td>
        <td>{{$customer->customer_name}}</td>
        <td>{{$customer->daily_collection_amount}}</td>
        <td>{{$customer->type}}</td>
      </tr>
    @endforeach
  </tbody>
</table>