<div class="form-group col-xs-12">
  <div class="form-group col-md-6 red">
   <label class="control-label requiredField" for="collection_date">
    Total Saving Amount : {{$total_saving_amount}}
   </label>
  </div>
  <div class="form-group col-md-6 red">
   <label class="control-label requiredField" for="collection_date">
    Total Loan Amount : {{$total_loan_amount}}
   </label>
  </div>
</div>
<table id="data-keytable-list" class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>Account No </th>
      <th>Name</th>
      <th>Saving Amount</th>
      <th>Loan Amount</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($customer_reports as $customer)
      <tr>
        <td>{{$customer['customer_account_no']}}</td>
        <td>{{$customer['customer_name']}}</td>
        <td>{{$customer['saving_amount']}}</td>
        <td>{{$customer['loan_amount']}}</td>
        <td>{{$customer['total_amount']}}</td>
      </tr>
    @endforeach
  </tbody>
</table>