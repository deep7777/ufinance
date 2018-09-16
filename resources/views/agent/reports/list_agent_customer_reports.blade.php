@extends('layouts.agent')
@section('content')
<form id="frm_agent_daily_collection">
{{ csrf_field() }}
<div class="clearfix"></div>
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <div>
        <label>Collection Report</label>
      </div>
      <div>
        <label>Change Date (d/m/Y) Format : </label>
        <input type="text" id="collection_date" name="collection_date" class="" value="{{date('d/m/Y')}}">
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <div class="row purple">
        <div class="col-sm-12">
          <div class="card-box table-responsive agent_customer_daily_collection">
            @include("agent/reports/agent_customer_daily_report")
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</form>
@endsection