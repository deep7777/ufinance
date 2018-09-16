@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title blue">
      <h2>Agents : </h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <div class="row">
        <div class="col-sm-12">
          <div class="card-box table-responsive">
            <table id="data-agent-summary-list" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Agent Name</th>
                  <th>Saving</th>
                  <th>Loan</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($agents as $agent)
                  <tr>
                    <td>{{$agent->agent_first_name." ".$agent->agent_last_name}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>  
@endsection