<!DOCTYPE html>
<html lang="en">
  @include('layouts/common_css')
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a class="site_title"><i class="fa fa-rupee"></i> <span>Urja Finance</span></a>
            </div>
            <div class="clearfix"></div>
            <br />
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3 id="staff_dashboard">Dashboard</h3>
                <input type="hidden" value="{{url("/")}}" id="url"/>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-users"></i> Customers <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li id="add_list"><a href="{{url('/customer/listCustomer')}}">List</a></li>                    
                    </ul>
                  </li>
                  <li><a><i class="fa fa-users"></i> Loan <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li id="add_list"><a href="{{url('/loan_requirement/selectCustomer')}}">Requirement</a></li>
                      <li id="add_list"><a href="{{url('/loan_requirement/customerLoanApproved')}}">Approved</a></li>                    
                    </ul>
                  </li>
                  <li><a><i class="fa fa-user"></i> Daily Entry <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{url("/saving/listSaving")}}">Saving</a></li>
                      <li><a href="{{url("/loan/listLoan")}}">Loan</a></li>
                      <li><a href="{{url("/withdrawal/listWithdrawal")}}">Withdrawal</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-money"></i> Expenses <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li id="add_list"><a href="{{url('/expense/listExpense')}}">List</a></li>                    
                    </ul>
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
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    {{ucwords(Session::get('staff')->first_name." ".Session::get('staff')->last_name) }}
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="{{url('/staff/profile')}}"> Profile</a></li>
                    <li><a href="{{url('/logout')}}"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main"style="min-height:1770px" >
          @yield('content') 
        </div>
        <!-- /page content -->
      </div>
    </div>
    
    @include('layouts/common_js')
    <script src="{{ asset('/build/js/admin_scripts.min.js') }}"></script>
    <script src="{{ asset('/build/js/module_scripts.min.js') }}"></script>
    <script src="{{ asset('/build/js/staff_scripts.min.js') }}"></script>
  </body>
</html>