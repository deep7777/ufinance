<div class="row">
  <div class="form-group col-xs-4">
   <label class="control-label requiredField" for="customer_account_no">
    Total Deposit Saving Current Month
   </label>
    <input readonly="readonly" required="" value="{{$total_saving}}" class="form-control" id="customer_account_no" name="customer_account_no" type="text"/>
  </div>
  <div class="form-group col-xs-4">
   <label class="control-label requiredField" for="customer_id">
    Total Deposit Loan Current Month
   </label>
    <input required="" readonly="readonly" value="{{$total_loan}}"  class="form-control" id="customer_id" name="customer_id" type="text"/>
  </div>
  <div class="form-group col-xs-4">
    <label class="control-label requiredField" for="customer_id">
    Total
    </label>
    <input required="" readonly="readonly" value="{{$total}}"  class="form-control" id="customer_id" name="customer_id" type="text"/>
  </div>
</div>
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
        <td>{{$agent['agent_name']}}</td>
        <td>{{$agent['saving_amount']}}</td>
        <td>{{$agent['loan_amount']}}</td>
        <td>{{$agent['total_amount']}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>