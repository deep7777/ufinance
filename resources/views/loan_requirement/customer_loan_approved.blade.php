@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <span>Loan Approved</span>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        @include('validate/errors')
        @include('validate/success')
        <br />
        <div class="row">
        <div class="col-sm-12">
          <div class="card-box table-responsive">
            <table id="data-keytable-list" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Account No</th>
                  <th>Received Date</th>
                  <th>Closing Date</th>
                  <th>Approved Amount</th>
                  <th>Loan Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($customers_list as $customer)
                  <tr>
                    <td>{{getCustomerName($customer)}}</td>
                    <td>{{$customer->customer_account_no}}</td>
                    <td>{{dmy($customer->loan_received_date)}}</td>
                    <td>{{dmy($customer->loan_closing_date)}}</td>
                    <td>{{$customer->loan_approved_amount}}</td>
                    <td>{{getLoanStatus($customer->loan_status_id)}}</td>
                    <td>
                      <a href="{{url('/loan_requirement/editLoanApprovedRequirement/'.$customer->loan_requirement_id)}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                    </td>
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