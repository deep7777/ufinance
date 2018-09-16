@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title blue">
      <span>Agent Monthly Collection : </span>
      <div class="clearfix"></div>
    </div>
    <div class="x_content blue">
      <form id="frm_agent_monthly_collection_report">
      {{csrf_field()}}
      <div class="row">
        <div class="form-group col-md-3">
          <input id="month_year" value="{{getCurrentMonthYear()}}" name="month_year" class="form-control month-picker"  onkeydown="return false">
        </div>
        <div class="form-group col-md-3">
          <button id="agent_monthly_collection_report" type="button" class="btn btn-success btn-large">Get Monthly Collection</button>
        </div>
        <div class="col-sm-12 agent_monthly_collection_data">
          @include('reports/agent_monthly_collection_data')
        </div>
      </div>
      </form>  
    </div>
  </div>
</div>
</div>  
@endsection