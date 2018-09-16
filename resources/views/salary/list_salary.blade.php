@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="">
    <a type="button" class="btn btn-primary" href="{{url('/salary/addSalary')}}">Add Salary</a>
  </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Salary List</h2>
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
                  <th>Fixed Salary</th>
                  <th>Total Salary</th>
                  <th>Paid Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($salary_list as $salary)
                  <tr>
                    <td>{{$salary->agent_first_name." ".$salary->agent_last_name}}</td>
                    <td>{{$salary->agent_fixed_salary}}</td>
                    <td>{{$salary->agent_total_salary}}</td>
                    <td>{{dmy($salary->agent_salary_paid_date)}}</td>
                    <td>
                      <a href="{{url('/salary/editSalary/'.$salary->salary_id)}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                      <a onclick="return delRecord(this)" data-token="{{ csrf_token() }}" data-id="{{$salary->salary_id}}" class="btn btn-danger btn-xs" data-go-to="{{url('/salary/listSalary')}}" data-url="{{url("/salary/deleteSalary")}}"><i class="fa fa-trash-o"></i> Delete </a>
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
<input type='hidden' id="delete_url" value="{{ url('/agent/deleteSalary') }}">
<input type='hidden' id="list_staff" value="{{ url('/agent/listSalary') }}">
@endsection
