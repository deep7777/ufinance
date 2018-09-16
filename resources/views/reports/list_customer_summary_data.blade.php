 <div class="card-box table-responsive">
  <table id="data-all-list" class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Account No & Agent</th>
        <th>Customer Name</th>
        <th>Account Opening Date</th>
        @if($account_type_id!="4")
        <th>Total Deposit Amount</th>
        @else
        <th>Amount</th>
        @endif
        <th>Loan Approved Amount </th>
        <th>Loan Received Date</th>
        <th>Loan Closing Date </th>
        <th>Loan Amount Collected</th>
        <th>Loan Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach($customer as $customer)
      <tr>
        <td>{{$customer->customer_account_no}}<br>{{$customer->agent_first_name." ".$customer->agent_last_name}}</td>
        <td>{{$customer->customer_first_name." ".$customer->customer_last_name}}<br>{{$customer->customer_contact_no}}</td>
        <td>{{dmy($customer->customer_account_opening_date)}}</td>
        @if($account_type_id!="4")
        <td>{{$customer->deposit_amount}}</td>
        @else
        <td>{{$customer->customer_amount}}</td>
        @endif
        <td>{{$customer->loan_approved_amount}}</td>
        <td>{{dmy($customer->loan_received_date)}}</td>
        <td>{{dmy($customer->loan_closing_date)}}</td>
        <td>{{$customer->collected_amount}}</td>
        <td>{{$customer->loan_status}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>