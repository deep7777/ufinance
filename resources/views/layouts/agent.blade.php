<!DOCTYPE html>
<html lang="en">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Urjafin</title>
  <!-- Bootstrap -->
  <link href="{{ asset('css/vendors/bootstrap/dist/css/bootstrap.min.css') }} " rel="stylesheet">
  <!-- Font Awesome -->
  <link href="{{ asset('css/vendors/font-awesome/css/font-awesome.min.css') }} " rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <!-- Custom Theme Style -->
  <link href="{{ asset('css/custom.min.css') }} " rel="stylesheet">
  <!-- Date Time Picker Style -->
  <link href="{{ asset('bower_components/datetimepicker/jquery.datetimepicker.css') }}" rel="stylesheet">
  
  <!-- Jquery UI css -->
  <link href="{{ asset('/bower_components/jquery-ui-monthpicker/jquery-ui.css') }}" rel="stylesheet">
</head>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="{{url('/agent')}}" class="site_title"><i class="fa fa-rupee"></i> <span>Urja Finance</span></a>
            </div>
            <div class="clearfix"></div>
            <br />
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3 id="agent_dashboard">Dashboard</h3>
                <input type="hidden" value="{{url("/")}}" id="url"/>
                <ul class="nav side-menu">
                  <li><a  href="{{url("/customer/listDailyEntry")}}"><i class="fa fa-user"></i> Daily Entry </a>
                  </li>
                </ul>
                <ul class="nav side-menu">
                  <li><a  href="{{url("/getAgentDailyCollectionReport")}}"><i class="fa fa-user"></i> Reports</a>
                  </li>
                </ul>
                <ul class="nav side-menu" style="display:block;">
                  <li><a  href="{{url("/customer/agentCustomers")}}"><i class="fa fa-user"></i> Customers </a>
                  </li>
                </ul>
                <ul class="nav side-menu" style="display:none;">
                  <li><a  href="{{url("/customer/listSaving")}}"><i class="fa fa-user"></i> Saving </a>
                  </li>
                </ul>
                <ul class="nav side-menu" style="display:none;">
                  <li><a  href="{{url("/customer/listLoan")}}"><i class="fa fa-user"></i> Loan </a>
                  </li>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav class="" role="navigation">
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li>
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    {{ucwords(Session::get('agent')->agent_first_name." ".Session::get('agent')->agent_last_name) }}
                    <span class="fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="{{url('/profile/agent')}}"> Profile </a></li>
                    <li><a href="{{url('/logout')}}"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          @yield('content') 
        </div>
        
      </div>
    </div>
    
    <script src="{{ asset('css/vendors/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('css/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>    
    <!-- Custom Theme Scripts -->
    <script src="{{ asset('/js/custom.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/parsley.min.js') }}"></script>
    <script src="{{ asset('/bower_components/jquery-ui-monthpicker/jquery-ui.js') }}"></script>        
    <script src="{{ asset('/bower_components/jquery-ui-monthpicker/jquery.ui.monthpicker.js') }}"></script>
    <script src="{{ asset('/build/js/agent_scripts.min.js') }}"></script>
  </body>
</html>