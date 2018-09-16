<div class="row">
  <div class="form-group col-xs-2">
   <label class="control-label requiredField" for="customer_account_no">
    Total Daily Saving
   </label>
    <input readonly="readonly" required="" value="{{$total_daily_saving}}" class="form-control" id="customer_account_no" name="customer_account_no" type="text"/>
  </div>
  <div class="form-group col-xs-2">
   <label class="control-label requiredField" for="customer_id">
    Total Daily Loan
   </label>
    <input required="" readonly="readonly" value="{{$total_daily_loan}}"  class="form-control" id="customer_id" name="customer_id" type="text"/>
  </div>
  <div class="form-group col-xs-2">
    <label class="control-label requiredField" for="customer_id">
    Total Daily Deposit
    </label>
    <input required="" readonly="readonly" value="{{$total_daily_deposit}}"  class="form-control" id="customer_id" name="customer_id" type="text"/>
  </div>
  <div class="form-group col-xs-2">
   <label class="control-label requiredField" for="customer_account_no">
    Total Monthly Saving
   </label>
    <input readonly="readonly" required="" value="{{$total_monthly_saving}}" class="form-control" id="customer_account_no" name="customer_account_no" type="text"/>
  </div>
  <div class="form-group col-xs-2">
   <label class="control-label requiredField" for="customer_id">
    Total Monthly Loan
   </label>
    <input required="" readonly="readonly" value="{{$total_monthly_loan}}"  class="form-control" id="customer_id" name="customer_id" type="text"/>
  </div>
  <div class="form-group col-xs-2">
    <label class="control-label requiredField" for="customer_id">
    Total Monthly Deposit
    </label>
    <input required="" readonly="readonly" value="{{$total_monthly_deposit}}"  class="form-control" id="customer_id" name="customer_id" type="text"/>
  </div>
</div>
<div class="row">
  <div class="form-group col-xs-2">
   <label class="control-label requiredField" for="customer_account_no">
    Total Monthly Expense
   </label>
    <input readonly="readonly" required="" value="{{$total_expense}}" class="form-control" id="customer_account_no" name="customer_account_no" type="text"/>
  </div>
  <div class="form-group col-xs-2">
   <label class="control-label requiredField" for="customer_id">
    Balance Amount
   </label>
    <input required="" readonly="readonly" value="{{$total_balance}}"  class="form-control" id="customer_id" name="customer_id" type="text"/>
  </div>
</div>
<div class="col-sm-12 ">
  <div class="card-box table-responsive">
    <table id="data-all-agent-summary-list" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Agent Name</th>
          <th>Total Saving Amount</th>
          <th>Total Loan Amount</th>
          <th>Total Amount</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($agents_list as $agent)
          <tr>
            <td>{{getAgentName($agent)}}</td>
            <td>{{$agent->saving_amount}}</td>
            <td>{{$agent->loan_amount}}</td>
            <td>{{$agent->total_amount}}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

