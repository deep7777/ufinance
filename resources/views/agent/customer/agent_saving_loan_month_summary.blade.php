<div class="row">
  <div class="form-group col-xs-12">
  <div class="form-group col-xs-6">
   <label class="control-label requiredField" for="customer_account_no">
    Total Deposit Saving Current Month
   </label>
    <input readonly="readonly" required="" value="{{$total_saving_deposit}}" class="form-control" id="customer_account_no" name="customer_account_no" type="text"/>
  </div>
  <div class="form-group col-xs-6">
   <label class="control-label requiredField" for="customer_id">
    Total Deposit Loan Current Month
   </label>
    <input required="" readonly="readonly" value="{{$total_loan_deposit}}"  class="form-control" id="customer_id" name="customer_id" type="text"/>
  </div>
</div>
  <div class="col-sm-12">
    <div class="card-box table-responsive">
      <table id="data-agent-summary-list" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Date</th>
            <th>Saving Amount</th>
            <th>Loan Amount</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($agents_list as $key=>$agent)
            <tr>
              <td>{{date('d-M-y', strtotime($agents_list[$key]['date']))}}</td>
              <td>{{$agents_list[$key]['saving_amount']}}</td>
              <td>{{$agents_list[$key]['loan_amount']}}</td>
              <td>{{$agents_list[$key]['total_amount']}}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>