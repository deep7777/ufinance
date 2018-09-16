@extends('layouts.main')
@section('content')
<form id="frm_all_agent_daily_collection">
{{ csrf_field() }}
<div class="clearfix"></div>
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_content">
      <div class="form-group col-xs-12">
        <div class="form-group col-md-6">
         <label class="control-label requiredField" for="collection_date">
          Select Date
         </label>
          <input type="text" id="collection_date" name="collection_date" class="form-control date_class" value="">
        </div>
        <div class="form-group col-md-6">
         <label class="control-label requiredField" for="customer_account_opening_date">
          Agent:
         </label>
         <select class="select form-control" id="agent_id" name="agent_id" required="">
          @foreach($agents_list as $agent)
          <option value="{{$agent->agent_id}}">{{$agent->agent_first_name." ".$agent->agent_last_name}}</option>
          @endforeach 
          </select> 
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="row purple">
        <div class="col-sm-12">
          <div class="card-box table-responsive agent_customer_daily_collection">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</form>
@endsection