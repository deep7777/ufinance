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