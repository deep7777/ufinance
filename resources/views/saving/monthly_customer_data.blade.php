<div class="x_title">
  <h2>Customer Details</h2>
  <div class="clearfix"></div>
</div>
<input type="hidden" value="{{$customer->customer_id}}" class="form-control" id="customer_id" name="customer_id"/>
<input type="hidden" value="{{$customer->agent_id}}" class="form-control" id="agent_id" name="agent_id"/>
<input type="hidden" value="{{$last_day}}" class="form-control" name="last_day"/>
<input type="hidden" value="{{$selected_month_year}}" class="form-control" name="selected_month_year"/>

<div class="x_title">
  <div class="pull-left red">Daily Saving Collection Amount - {{ getMYName($selected_month_year) }}</div>
  <div class="clearfix"></div>
</div>
<table style="width:910px;color:black;" border="1" bordercolor="grey">
  <tr style="background: skyblue;">
    <td width="130px">Sun</td>
    <td width="130px">Mon</td>
    <td width="130px">Tue</td>
    <td width="130px">Wed</td>
    <td width="130px">Thu</td>
    <td width="130px">Fri</td>
    <td width="130px">Sat</td>
  </tr>
  <tr>
  @foreach($columns as $key=>$column)
    @if(getDay("1",$selected_month_year)==$column )
      <td width="130px">
        <table width="100%">
          <tr>
            <td width="50%">&nbsp;1</td> 
            <td width="50%" align="right" class="red"><b>{{ getCollectionAmount("1",$get_monthly_collection)}}</b></td>
          </tr>
        </table>
      </td>
      @for($i=2;$i<=(8-$key);$i++)
      <?php $j=1;?>
      <td width="130px">
        <table width="100%">
          <tr>
            <td width="50%">&nbsp;{{$i}}</td> 
            <td width="50%" align="right" class="red"><b>{{ getCollectionAmount($i,$get_monthly_collection)}}</b></td>
          </tr>
        </table> 
      </td>
      @endfor
    @else
      @if($j<=0)
      <td width="130px">&nbsp;</td>
      @endif
    @endif
  @endforeach
  </tr>
  <?php $k=1;?>
  @for($j=$i;$j<=$last_day;$j++)
    @if($k==1)
      <tr>
        <td width="130px">
          <table width="100%">
            <tr>
              <td width="50%">&nbsp;{{$j}}</td> 
              <td width="50%" align="right" class="red"><b>{{ getCollectionAmount($j,$get_monthly_collection)}}</b></td>
            </tr>
          </table> 
        </td>  
    @elseif($k==7)
      <td>
        <table width="100%">
          <tr>
            <td width="50%">&nbsp;{{$j}}</td> 
            <td width="50%" align="right" class="red"><b>{{ getCollectionAmount($j,$get_monthly_collection)}}</b></td>
          </tr>
        </table>
      </td>
      </tr>
      <?php $k=0;?>
    @else
    <td>
      <table width="100%">
        <tr>
          <td width="50%">&nbsp;{{$j}}</td> 
          <td width="50%" align="right" class="red"><b>{{ getCollectionAmount($j,$get_monthly_collection)}}</b></td>
        </tr>
      </table>
    </td> 
    @endif
    <?php $k++;?>
  @endfor
</table>
<?php $j=0;$style="width:75px; background-color: #F7F7F7;margin-top:1px;";?>
<br>
<div class="x_title">
  <div class="pull-left red">Modify Daily Saving Collection Amount - {{ getMYName($selected_month_year) }}</div>
  <div class="clearfix"></div>
</div>
<table style="width:910px;color:black;" border="1" bordercolor="grey">
  <tr style="background: skyblue;">
    <td width="130px">Sun </td>
    <td width="130px">Mon</td>
    <td width="130px">Tue</td>
    <td width="130px">Wed</td>
    <td width="130px">Thu</td>
    <td width="130px">Fri</td>
    <td width="130px">Sat</td>
  </tr>
  <tr>
  @foreach($columns as $mkey=>$column)
    @if(getDay("1",$selected_month_year)==$column )
      <td width="130px">
        <table width="100%">
          <tr>
            <td width="50%">&nbsp;1 </td> 
            <td width="50%" align="right"><input style="{{$style}}}"  data-parsley-error-message="Not valid"  data-parsley-type="number"  name="{{getTxtFieldName("1")}}"value="" type="text"/></td>
          </tr>
        </table>
      </td>
      @for($i=2;$i<=(8-$mkey);$i++)
      <?php $j=1;?>
      <td width="130px">
        <table width="100%">
          <tr>
            <td width="50%">&nbsp;{{$i}}</td> 
            <td width="50%" align="right"><input style="{{$style}}}" data-parsley-error-message="Not valid" data-parsley-type="number" name="{{getTxtFieldName($i)}}"value=""  type="text"/></td>
          </tr>
        </table> 
      </td>
      @endfor
    @else
      @if($j<=0)
      <td width="130px">&nbsp;</td>
      @endif
    @endif
  @endforeach
  </tr>
  <?php $k=1;?>
  @for($j=$i;$j<=$last_day;$j++)
    @if($k==1)
      <tr>
        <td width="130px">
          <table width="100%">
            <tr>
              <td width="50%">&nbsp;{{$j}}</td> 
              <td width="50%" align="right"><input style="{{$style}}}" data-parsley-error-message="Not valid" data-parsley-type="number" name="{{getTxtFieldName($j)}}"value=""  type="text"/></td>
            </tr>
          </table> 
        </td>  
    @elseif($k==7)
      <td>
        <table width="100%">
          <tr>
            <td width="50%">&nbsp;{{$j}}</td> 
            <td width="50%" align="right"><input style="{{$style}}}" data-parsley-error-message="Not valid" data-parsley-type="number" name="{{getTxtFieldName($j)}}"value=""  type="text"/></td>
          </tr>
        </table>
      </td>
      </tr>
      <?php $k=0;?>
    @else
    <td>
      <table width="100%">
        <tr>
          <td width="50%">&nbsp;{{$j}}</td> 
          <td width="50%" align="right"><input style="{{$style}}}" data-parsley-error-message="Not valid" data-parsley-type="number" name="{{getTxtFieldName($j)}}"value=""  type="text"/></td>
        </tr>
      </table>
    </td> 
    @endif
    <?php $k++;?>
  @endfor
</table>

<div class="ln_solid col-xs-12"></div>
    <div class="form-group pull-left">
      <button  class="btn btn-large btn-primary" type="submit">Save Amount</button>
    </div>
</div>
