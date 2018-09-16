@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Add Expense</h2>
        <div class="pull-right">
          <a type="button" class="btn btn-primary" href="{{url('/expense/listExpense')}}">Back</a>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        @include('validate/errors')
        @include('validate/success')
        <br />
        <form action ="{{url('/expense/createExpense')}}" method="POST"  data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expense_name">Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input  value="" type="text" id="expense_name" name="expense_name" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expense_amount">Amount <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input data-parsley-type="number" value="" type="text" id="expense_amount" name="expense_amount" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expense_date">Date <span class="expense_joining_date">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="expense_date"  value="" type="text" required="required" name="expense_date"  class="form-control col-md-7 col-xs-12 date_class" onkeydown="return false">
              </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expense_purpose">Purpose <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input  value="" type="text" id="expense_purpose" name="expense_purpose" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expense_desc" >Description
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea rows="4" cols="40" name="expense_desc" id="expense_desc" class="form-control"  data-parsley-trigger="keyup"  data-parsley-maxlength="300" >{{ old('expense_desc') }}</textarea>
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