@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row blue">
  <form id="frm_dashboard" class="form-horizontal form-label-left">
    <input type="hidden" id="url" value="{{url("/")}}">  
    {{ csrf_field() }}
    <div class="form-group col-md-12">
      <h2>Agent Daily Collection Saving And Loan Summary</h2>
      <label class="control-label requiredField" for="customer_account_opening_date">
       Select Date
      </label>
      <input value="{{dmy($date)}}" id="dashboard_date"  type="text" required="required" name="dashboard_date"  class=" date_class" onkeydown="return false">
    </div>
    <div class="col-xs-12">
  </form>
</div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_content">
      <div class="clearfix col-xs-12"></div>
      <div class="row agent_list">
        @include("admin/agent_summary_list")
      </div>
    </div>
  </div>
</div>
</div>  
@endsection