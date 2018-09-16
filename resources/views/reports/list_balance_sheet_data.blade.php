<div class="card-box table-responsive">
  <table id="customer-transaction-list" class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Saving Balance</th>
        <th>Loan Balance</th>
        <th>Loan Distributed</th>
        <th>Loan Amount Due</th>
        <th>Withdrawal Amount</th>
        <th>Expenses</th>
        <th>Salary</th>
        <th>Balance Remaining</th>
      </tr>
    </thead>
    <tbody>
      @foreach($balance_report as $balance)
      <tr>
        <td>{{$balance->saving_amount}}</td>
        <td>{{$balance->loan_collection}}</td>
        <td>{{$balance->loan_amount_distributed}}</td>
        <td>&nbsp;</td>
        <td>{{$balance->withdrawal_amount}}</td>
        <td>{{$balance->expense_amount}}</td>
        <td>{{$balance->agent_salary}}</td>
        <td>{{$balance->balance_amount}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>