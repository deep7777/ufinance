 
  <div class="card-box table-responsive">
  <table id="data-all-list" class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Account No & Agent</th>
        <th>Customer Name</th>
        <th>Account Opening Date</th>
        <th>Received Date</th>
        <th>Closing Date </th>
        <th>Saving</th>
        <th>Approved Amount </th>
        <th>Loan Amount Collected</th>
        <th>Loan Amount Due</th>
        <th>Loan Collection Should be</th>
        <th>Loan Shortage</th>
      </tr>
    </thead>
    <tbody>
      @foreach($loan as $loan)
      <tr>
        <td>{{$loan->customer_account_no}}<br>{{$loan->agent_first_name." ".$loan->agent_last_name}}</td>
        <td>{{$loan->customer_first_name." ".$loan->customer_last_name}}<br>{{$loan->customer_contact_no}}</td>
        
        <td>{{dmy($loan->account_opening_date)}}</td>
        <td>{{dmy($loan->loan_received_date)}}</td>
        <td>{{dmy($loan->loan_closing_date)}}</td>
        <td>{{$loan->saving}}</td>
        <td>{{$loan->loan_approved_amount}}</td>
        <td>{{$loan->collected_amount}}</td>
        <td>{{$loan->loan_amount_due}}</td>
         <td>{{$loan->loan_collection_should_be}}</td>
        <td class="red">{{$loan->loan_shortage}}</td>
       
        
      </tr>
      @endforeach
    </tbody>
  </table>
</div>