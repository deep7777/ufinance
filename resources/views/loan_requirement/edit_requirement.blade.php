@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Estimate Loan Requirement</h2>
        <div class="pull-right">
          <a type="button" class="btn btn-primary" href="{{url('/loan_requirement/selectCustomer')}}">Back</a>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        @include('validate/errors')
        @include('validate/success')
        <br />
        <form id="frm_edit_loan_requirement" action ="{{url('/loan_requirement/updateCustomerRequirement')}}" method="POST"  data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
          @include('loan_requirement/edit_frm_loan_requirement')
        </form>
      </div>
    </div>
  </div>
</div>
@endsection