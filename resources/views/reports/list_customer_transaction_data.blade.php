<div class='row text-center'>
  <label class="purple">Customer Name: {{$customer_name}} </label>
</div>  
<div class="card-box table-responsive">
  <table id="customer-transaction-list" class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Amount</th>
        <th class='text-center'>Date</th>
        <th class='text-center'>Type</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach($transactions as $key=>$transaction)
      <?php $color=($transactions[$key]['type']=='saving')?'green':'red';?>
      <tr>
        <td>{{$transactions[$key]['amount']}}</td>
        <td class='text-center'>{{dmy($transactions[$key]['cdate'])}}</td>
        <td class="{{$color}} text-center">{{strtoupper($transactions[$key]['type'])}}</td>
        <td>{{$transactions[$key]['balance']}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>