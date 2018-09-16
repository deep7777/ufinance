@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 blue">
  <div class="x_panel">
    <div class="x_title">
      <div>
        Monthly Collection Saving And Loan Summary
      </div>      
      <div class="clearfix"></div>
    </div>
    <div class="x_content agent_saving_loan_month_summary">
      @include("agent/customer/agent_saving_loan_month_summary")
    </div>
  </div>
</div>
</div>  
@endsection