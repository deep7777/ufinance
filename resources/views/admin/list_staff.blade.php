@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="">
    <a type="button" class="btn btn-primary" href="{{url('/admin/addStaff')}}">Add Staff</a>
  </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Staff List</h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <div class="row">
        <div class="col-sm-12">
          <div class="card-box table-responsive">
            <table id="staff-list" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Username</th>
                  <th>Status</th>
                  <th>Account</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($staff_list as $staff)
                  <tr>
                    <td>{{$staff->first_name}}</td>
                    <td>{{$staff->last_name}}</td>
                    <td>{{$staff->email}}</td>
                    <td>{{$staff->mobile_no}}</td>
                    <td>{{$staff->username}}</td>
                    <td>{{(($staff->status_id=="1")?"Enabled":"Disabled")}}</td>
                    <td>
                      <a href="{{url('/admin/'.$staff->id.'/editStaff')}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                      <a data-token="{{ csrf_token() }}" data-staff-id="{{$staff->id}}" class="delStaff btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
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
<input type='hidden' id="delete_url" value="{{ url('/admin/deleteStaff') }}">
<input type='hidden' id="list_staff" value="{{ url('/admin/listStaff') }}">
@endsection