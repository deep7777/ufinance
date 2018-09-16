@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="">
    <a type="button" class="btn btn-primary" href="{{url('/agent/addAgent')}}">Add Agent</a>
  </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Agent List</h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <div class="row">
        <div class="col-sm-12">
          <div class="card-box table-responsive">
            <table id="data-keytable-list" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Joining Date</th>
                  <th>Salary</th>
                  <th>Mobile No</th>
                  <th>Username</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($agents_list as $agent)
                  <tr>
                    <td>{{$agent->agent_first_name}}</td>
                    <td>{{$agent->agent_last_name}}</td>
                    <td>{{date('d/m/Y', strtotime($agent->agent_joining_date))}}</td>
                    <td>{{$agent->agent_fixed_salary}}</td>
                    <td>{{$agent->agent_primary_contact}}</td>
                    <td>{{$agent->username}}</td>
                    <td>
                      <a href="{{url('/agent/editAgent/'.$agent->agent_id)}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
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
<input type='hidden' id="delete_url" value="{{ url('/agent/deleteAgent') }}">
<input type='hidden' id="list_staff" value="{{ url('/agent/listAgent') }}">
@endsection