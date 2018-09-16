@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Edit Expense</h2>
        <div class="pull-right">
          <a type="button" class="btn btn-primary" href="{{url('/expense/listExpense')}}">Back</a>
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
        <form action ="{{url('/expense/updateExpense')}}" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <input type="hidden" value="{{$expense->expense_id}}" name="id">
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expense_name">Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input  value="{{$expense->expense_name}}" type="text" id="expense_name" name="expense_name" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expense_amount">Amount <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{$expense->expense_amount}}" data-parsley-type="number"  type="text" id="expense_amount" name="expense_amount" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expense_date">Date <span class="expense_joining_date">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input value="{{dmy($expense->expense_date)}}" id="expense_date"  type="text" required="required" name="expense_date"  class="form-control col-md-7 col-xs-12 date_class" onkeydown="return false">
              </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expense_purpose">Purpose <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input  value="{{$expense->expense_purpose}}" type="text" id="expense_purpose" name="expense_purpose" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expense_desc" >Description
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea rows="4" cols="40" name="expense_desc" id="expense_desc" class="form-control"  data-parsley-trigger="keyup"  data-parsley-maxlength="300" >{{$expense->expense_desc}}</textarea>
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