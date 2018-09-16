@extends('layouts.main')
@section('content')
<form id="frm_agent_daily_collection">
{{ csrf_field() }}
<div class="clearfix"></div>
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <div>
        <label>Daily Deposit Defaulters </label>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <div class="row purple">
        <div class="col-sm-12">
          <div class="card-box table-responsive">
            <table id="data-all-list" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Agent Name </th>
                <th>Account No</th>
                <th>Customer Name </th>
                <th>Not Paid from (days)</th>
                <th>Contact No</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($customer_reports as $customer)
                <tr>
                  <td>{{$customer['agent_first_name']." ".$customer['agent_last_name']}}</td>
                  <td>{{$customer['customer_account_no']}}</td>
                  <td>{{$customer['customer_first_name']." ".$customer['customer_last_name']}}</td>
                  <td class="red">{{$customer['days']}}</td>
                  <td>{{$customer['customer_contact_no']}}</td>
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
</form>
@endsection