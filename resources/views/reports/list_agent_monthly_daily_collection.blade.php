@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 blue">
  <div class="x_panel">
    <div class="x_title">
      <div>
        Agent Daily Collection of Month Saving And Loan Summary
      </div>      
      <div class="clearfix"></div>
    </div>
    <div class="x_content agent_monthly_daily_collection">
      <form id="frm_agent_monthly_daily_collection_report">
      {{csrf_field()}}
      <div class="row">
        <div class="form-group col-md-3">
          <input id="month_year" value="{{getCurrentMonthYear()}}" name="month_year" class="form-control month-picker"  onkeydown="return false">
        </div>
        <div class="form-group col-md-3">
          <select class="select form-control" id="agent_id" name="agent_id" required="">
            <option value="">Select Agent</option>  
            @foreach($agents_list as $agent)
            <option value="{{$agent->agent_id}}">{{$agent->agent_first_name." ".$agent->agent_last_name}}</option>
            @endforeach 
            </select>
        </div>
        <div class="form-group col-md-3">
          <button id="agent_monthly_daily_collection_report" type="button" class="btn btn-success btn-large">Get Monthly Collection</button>
        </div>
        <div class="col-sm-12 agent_monthly_daily_collection_report_data">
          
        </div>
      </div>
      </form>
      
    </div>
  </div>
</div>
</div>  
@endsection