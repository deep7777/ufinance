<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>UrjaFin</title>

    <!-- Bootstrap -->
    <link href="{{ asset('css/vendors/bootstrap/dist/css/bootstrap.min.css') }} " rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('css/vendors/font-awesome/css/font-awesome.min.css') }} " rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('css/custom.min.css') }} " rel="stylesheet">
  </head>
  
  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form id="frm_login" name="frm_login" method="POST" action="{{url('/validateLogin')}}">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <h1>Login</h1>
              <div>
                <input name="username" data-parsley-error-message="Username field is required" type="text" class="form-control" placeholder="Username" required="" />
              </div>
              <div>
                <input name="password" data-parsley-error-message="Password field is required" type="password" class="form-control" placeholder="Password" required="" />
              </div>
              @if(Session::has('message'))
              <p class="alert alert-danger">{{ Session::get('message') }}</p>
              @endif
              <div>
                <button type="submit" class="btn btn-default submit" href="#">Log in</button>
              </div>
              <div class="clearfix"></div>
              <div class="separator">
              </div>
            </form>
          </section>
        </div>
        
      </div>
    </div>
    <!-- jQuery -->
    <script src="{{ asset('css/vendors/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/parsley.min.js') }}"></script>
    <script src="{{ asset('/build/js/login_page.min.js') }}"></script>
  </body>
</html>