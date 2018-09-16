@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="">
    <a type="button" class="btn btn-primary" href="{{url('/expense/addExpense')}}">Add Expense</a>
  </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Expense List</h2>
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
                  <th>Amount</th>
                  <th>Date</th>
                  <th>Purpose</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($expenses_list as $expense)
                  <tr>
                    <td>{{$expense->expense_name}}</td>
                    <td>{{$expense->expense_amount}}</td>
                    <td>{{dmy($expense->expense_date)}}</td>
                    <td>{{$expense->expense_purpose}}</td>
                    <td>
                      <a href="{{url('/expense/editExpense/'.$expense->expense_id)}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                      <a onclick="return delRecord(this)" data-token="{{ csrf_token() }}" data-id="{{$expense->expense_id}}" class="btn btn-danger btn-xs" data-go-to="{{url('/expense/listExpense')}}" data-url="{{url("/expense/deleteExpense")}}"><i class="fa fa-trash-o"></i> Delete </a>
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
<input type='hidden' id="delete_url" value="{{ url('/agent/deleteExpense') }}">
<input type='hidden' id="list_staff" value="{{ url('/agent/listExpense') }}">
@endsection