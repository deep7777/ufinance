@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="">
    <a type="button" class="btn btn-primary" href="{{url('/customer/addCustomer')}}">Add Customer</a>
  </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Customer List</h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <div class="row">
        <div class="col-sm-12">
          <div class="card-box table-responsive">
            <table id="data-keytable-list" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Account No</th>
                  <th>Account Type</th>
                  <th>Mobile No</th>
                  <th>Opening Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($customers_list as $customer)
                  <tr>
                    <td>{{getCustomerName($customer)}}</td>
                    <td>{{$customer->customer_account_no}}</td>
                    <td>{{$customer->deposit_type}}</td>
                    <td>{{$customer->customer_contact_no}}</td>
                    <td>{{date('d/m/Y', strtotime($customer->customer_account_opening_date))}}</td>
                    <td>
                      <a href="{{url('/customer/editCustomer/'.$customer->customer_id)}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
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
<input type='hidden' id="delete_url" value="{{ url('/customer/deleteCustomer') }}">
<input type='hidden' id="list_staff" value="{{ url('/customer/listCustomer') }}">
@endsection