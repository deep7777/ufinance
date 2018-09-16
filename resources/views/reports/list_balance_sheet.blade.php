@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 blue">
  <div class="x_panel">
    <div class="x_title">
      <div>Balance Sheet</div>
      <div class="clearfix"></div>
    </div>
    <div class="x_content balance_sheet">
      <form id="frm_balance_sheet_report">
      {{csrf_field()}}
      <div class="form-group col-xs-12">
        <div class="form-group col-md-4">
         <label class="control-label requiredField" for="from_date">
          From Date
         </label>
          <input type="text" id="from_date" name="from_date" class="form-control date_class" value="">
        </div>
        <div class="form-group col-md-4">
         <label class="control-label requiredField" for="to_date">
          To Date
         </label>
          <input type="text" id="to_date" name="to_date" class="form-control date_class" value="">
        </div>
      </div>
      <div class="form-group col-xs-12">
        <div class="form-group col-md-4">
          <button id="balance_sheet_report" type="button" class="btn btn-success btn-large">Get Data</button>
          <button id="balance_sheet_reset" type="button" class="btn btn-info btn-large">Reset</button>
        </div>
      </div>
       <div class="col-sm-12 balance_sheet_report_data"></div>
      </form>
      
    </div>
  </div>
</div>
</div>  
@endsection