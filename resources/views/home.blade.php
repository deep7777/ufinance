<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Urja Finance</title>
    <link rel="stylesheet" href="{{ asset('/css/normalize.css') }}">
    <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
  </head>

  <body>
  <div class="logmod">
  <div class="logmod__wrapper">
    <div class="logmod__container">
      <ul class="logmod__tabs">
        <li data-tabtar="lgm-1"><a href="#">Staff</a></li>
        <li data-tabtar="lgm-2"><a href="#">Admin</a></li>
      </ul>
      <div class="logmod__heading">
        <p id="err-username-msg" class="alert-danger"></p>
        <p id="err-pwd-msg" class="alert-danger"></p>
        <p id="err-auth-failure" class="alert-danger"></p>
      </div>
      <div class="logmod__tab-wrapper">
      <div class="logmod__tab lgm-1">
        <div class="logmod__form">
          @include("partials.loginForm",["frm_id"=>"frm_staff","button_id"=>"btn_staff"])
        </div> 
      </div>
      <div class="logmod__tab lgm-2">
        <div class="logmod__form">
          @include("partials.loginForm",["frm_id"=>"frm_admin","button_id"=>"btn_admin"])
        </div> 
          </div>
      </div>
    </div>
  </div>
</div>
    
  <script src="{{ asset('/build/js/plugins.js') }}"></script>
  <script src="{{ asset('/build/js/login_page.min.js') }}"></script>
  </body>
</html>