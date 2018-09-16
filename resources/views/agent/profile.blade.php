@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Update Profile</h2>
        <div class="pull-right">
          <a type="button" class="btn btn-primary" href="{{url('/agent')}}">Back</a>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        @if (count($errors) > 0)
          <div class="alert alert-danger text-center">
            <div>
              @foreach ($errors->all() as $error)
                <div class="">{{ $error }}</div>
              @endforeach
            </div>
          </div>
        @endif
        <br />
        <form action ="{{url('/profile/updateAgent')}}" method="POST"  data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <input type="hidden" value="{{$agent->agent_id}}" name="id">
          <input value="{{ $agent->username }}" type="hidden" id="username" name="username" required="required" class="form-control col-md-7 col-xs-12">
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="agent_first_name">First Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ $agent->agent_first_name }}" type="text" id="agent_first_name" name="agent_first_name" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="agent_last_name">Last Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ $agent->agent_last_name }}" type="text" id="agent_last_name" name="agent_last_name" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="agent_primary_contact">Primary Contact
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ $agent->agent_primary_contact }}" type="text" id="agent_primary_contact" name="agent_primary_contact" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="agent_secondary_contact">Secondary Contact
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ $agent->agent_secondary_contact }}" type="text" id="agent_secondary_contact" name="agent_secondary_contact" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input data-parsley-equalto="#confirmPassword" data-parsley-minlength="4" type="password" id="password" name="password" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Confirm Password <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ old('confirmPassword') }}" data-parsley-equalto="#password" data-parsley-minlength="4" type="text" id="confirmPassword" name="confirmPassword" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-9 text-right">
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection