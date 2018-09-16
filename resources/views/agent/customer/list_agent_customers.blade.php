@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title blue">
      <h2>Customers : {{ count($agent_customers)}}</h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <div class="row purple">
        <div class="col-sm-12">
          <div class="card-box table-responsive">
            <table id="data-agent-summary-list" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Customer Name</th>
                  <th>Mobile Number</th>
                  <th>Account No</th>
                  <th>Saving Collection</th>
                  <th>Loan Collection</th>
                  <th>Type</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($agent_customers as $customer)
                  <tr>
                    <td>{{getCustomerName($customer)}}</td>
                    <td>{{$customer->customer_contact_no}}</td>
                    <td>{{$customer->customer_account_no}}</td>
                    <td>{{$customer->balance_amount}}</td>
                    <td>{{$customer->loan_amount}}</td>
                    <td>{{(($customer->customer_loan_taken==1)?"Loan":"Saving")}}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>  
@endsection