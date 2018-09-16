<form  id="{{$frm_id}}" name="{{$frm_id}}" accept-charset="utf-8" action="#" class="simform">
 <input type="hidden" name="_token" value="{{ csrf_token() }}">
 <div class="sminputs">
  <div class="input full">
    <label class="string optional" for="user-name">Username*</label>
    <input data-parsley-error-message="Username field is required"  data-parsley-errors-container="#err-username-msg" autocomplete="off" required="" class="string optional" maxlength="255" id="username" name="username" placeholder="Username" type="text" size="50" />
  </div>
</div>
<div class="sminputs">
  <div class="input full">
    <label class="string optional" for="user-pw">Password*</label>
    <input data-parsley-error-message="Password field is required" data-parsley-errors-container="#err-pwd-msg" required="" class="string optional" maxlength="255" id="password" name="password" placeholder="Password" type="password" size="50" />              						
  </div>
</div>
<div class="simform__actions">
  <input id="{{$button_id}}" class="sumbit" name="{{$button_id}}" type="button" value="Log In" />
  <span style="display:none;" class="simform__actions-sidetext"><a class="special" role="link" href="#">Forgot your password?<br>Click here</a></span>
</div> 
</form>