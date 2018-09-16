<div class="x_title text-center">
  <div class="red">Withdrawal History</div>
  <div class="clearfix"></div>
</div>
<div class="row">
  <div class="col-sm-12">
    <div class="card-box table-responsive">
      <table id="data-withdrawal-keytable-list" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Withdrawal Date</th>
            <th>Total Deposit</th>
            <th>Withdrawal Amount</th>
            <th>Withdrawal Percentage</th>
            <th>Amount In hand</th>
            <th>Total Balance</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($customer_withdrawal_list as $customer)
            <tr>
              <td>{{getWithdrawalDateFormat($customer->withdrawal_date)}}</td>
              <td>{{$customer->total_deposit}}</td>
              <td>{{$customer->withdrawal_amount}}</td>
              <td>{{$customer->withdrawal_percentage}}</td>
              <td>{{$customer->amount_in_hand}}</td>
              <td>{{$customer->total_balance}}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>  