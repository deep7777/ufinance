@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Edit Saving</h2>
        <div class="pull-right">
          <a type="button" class="btn btn-primary" href="{{url('/saving/listSaving')}}">Back</a>
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
        <form id="frm_agent_saving" action ="{{url('/saving/updateSaving')}}" method="POST" data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <input type="hidden" id="url" value="{{url("/")}}">
          <input type="hidden" name="id" value="{{ $saving->saving_id }}">
          <input type="hidden" name="agent_id" value="{{ $saving->agent_id }}">
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="agent_name">
             Agent Name
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label class="control-label" for="agent_name">
              <span>{{$saving->agent_first_name." ".$saving->agent_last_name}}</span>
              </label>
            </div>  
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="agent_fixed_saving">Fixed Saving <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input readonly="" value="{{ $saving->agent_fixed_saving}}" style="background:yellow" data-parsley-type="number" value="" type="text" id="agent_fixed_saving" name="agent_fixed_saving" required="required" class="form-control col-md-7 col-xs-12 agent_saving">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="agent_comission">Comission  % <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="3" data-parsley-error-message="Not Valid" data-parsley-pattern="/^[+-]?\d+(\.\d+)?$/" placeholder="Percent %"  value="" type="text" id="agent_comission_per" name="agent_comission_per" required="required" class="form-control col-md-7 col-xs-12 cal_comission">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="agent_month_saving_deposit">Total Deposit [per month] <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input  value="" data-parsley-error-message="Not Valid" data-parsley-pattern="/^[+-]?\d+(\.\d+)?$/" value="" type="text" id="agent_month_saving_deposit" name="agent_month_saving_deposit" required="required" class="form-control col-md-7 col-xs-12 cal_comission">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="agent_comission">Comission <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="3" type="text" id="agent_comission" name="agent_comission" required="required" class="form-control col-md-7 col-xs-12 cal_comission agent_saving" style="background:yellow" >
            </div>
          </div>
          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="agent_saving_paid_date">Paid Date <span class="saving_joining_date">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="agent_saving_paid_date"  value="{{dmy($saving->agent_saving_paid_date)}}" type="text" required="required" name="agent_saving_paid_date"  class="form-control col-md-7 col-xs-12 date_class" onkeydown="return false">
              </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="agent_total_saving">Total Saving <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input  value="{{ $saving->agent_total_saving}}" type="text" id="agent_total_saving" name="agent_total_saving" required="required" class="form-control col-md-7 col-xs-12" style="background:skyblue" >
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
