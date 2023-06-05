@inject('request', 'Illuminate\Http\Request')
<!-- Main Header -->
<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{asset('fonts/icofont/icofont.min.css')}}">
<style>
.btn-pill{
  border-radius: 100vh !important;
}
.btn-pos{
  border-radius: 100vh !important;
  padding: 12px 24px;
}
.btn-report{
  border-radius: 100vh;
    padding: 5px 16px;
}
.skin-blue .main-header .navbar, .skin-blue-light .main-header .navbar {
     background-color: #ffffff;
    background-image: linear-gradient(to right,#ffffff,#ffffff);
}
.nav-head {
  color:#333333;font-weight: 700;
}
.sidebar-toogle-pin {
  width: 35px;
  height: 35px;
  cursor: pointer;
  font-size: 24px;
  display: inline-block;
  margin-left: -5px;
}
.skin-blue-light .main-header .navbar .sidebar-toggle {
  font-size: 24px;
  color: #333;
}
.skin-blue-light .main-header .navbar .sidebar-toggle:hover {
    background-color: #E9E7FF;
}
.skin-blue .content-wrapper .content-header-custom, .skin-blue-light .content-wrapper .content-header-custom {
  background-image: linear-gradient(to right,#E9E7FF,#E9E7FF);
}
.skin-blue-light .main-header .logo {
  background-color: #f0f0f0;
}
.skin-blue .main-header .logo:hover, .skin-blue-light .main-header .logo:hover {
    background: #E9E7FF;
}
.skin-blue .main-header li.user-header, .skin-blue-light .main-header li.user-header {
    background-color: #E9E7FF;
}
.navbar-nav>.user-menu>.dropdown-menu>li.user-header>p {
    z-index: 5;
    color: #333;
    font-size: 24px;
    margin-top: 10px;
}
.skin-black-light .sidebar-menu>li.active>a, .skin-black-light .sidebar-menu>li.menu-open>a, .skin-black-light .sidebar-menu>li:hover>a, .skin-blue-light .sidebar-menu>li.active>a, .skin-blue-light .sidebar-menu>li.menu-open>a, .skin-blue-light .sidebar-menu>li:hover>a, .skin-green-light .sidebar-menu>li.active>a, .skin-green-light .sidebar-menu>li.menu-open>a, .skin-green-light .sidebar-menu>li:hover>a, .skin-purple-light .sidebar-menu>li.active>a, .skin-purple-light .sidebar-menu>li.menu-open>a, .skin-purple-light .sidebar-menu>li:hover>a, .skin-red-light .sidebar-menu>li.active>a, .skin-red-light .sidebar-menu>li.menu-open>a, .skin-red-light .sidebar-menu>li:hover>a, .skin-yellow-light .sidebar-menu>li.active>a, .skin-yellow-light .sidebar-menu>li.menu-open>a, .skin-yellow-light .sidebar-menu>li:hover>a {
  color: #8280fd;
}
.skin-blue-light .sidebar-menu .treeview-menu>li.active>a, .skin-blue-light .sidebar-menu .treeview-menu>li>a:hover {
    color: #8280fd;
}
.btn-primary {
    background: #6045e2;
    border-color: #6045e2;
}
.btn-success{
  background: #67cf94;
    border-color: #67cf94;
}
.btn-info {
    background: #6045e2;
    border-color: #6045e2;
}
.skin-blue .content-wrapper .content-header-custom a, .skin-blue .content-wrapper .content-header-custom h1, .skin-blue .content-wrapper .content-header-custom small, .skin-blue-light .content-wrapper .content-header-custom a, .skin-blue-light .content-wrapper .content-header-custom h1, .skin-blue-light .content-wrapper .content-header-custom small {
    color: #333333!important;
    font-weight: 700;
}
div.pos-tab-menu div.list-group>a.active, div.pos-tab-menu div.list-group>a.active .glyphicon, div.pos-tab-menu div.list-group>a.active .fa {
    background-color: #6045e2;
    color: #ffffff;
    border-color: #6045e2;
}
a.list-group-item:focus, a.list-group-item:hover, button.list-group-item:focus, button.list-group-item:hover {
    color: #555;
    text-decoration: none;
    color: #8280fd;
}
</style>
  <header class="main-header no-print">
    <a href="{{route('home')}}" class="logo">
      
      <span class="logo-lg" style="color:#333333; font-size:24px;">{{ Session::get('business.name') }} <i class="fa fa-circle text-success" id="online_indicator"></i></span> 

    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
     <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
       
        {{-- <span class="sr-only">Toggle navigation</span> --}}
        <i class="icofont-tack-pin"></i>
      </a>
        <!-- Sidebar Toggle Pin Button -->

        {{-- <div class="sidebar-toogle-pin">
          <i class="icofont-tack-pin"></i>
       </div> --}}
       <!-- End Sidebar Toggle Pin Button -->

      @if(Module::has('Superadmin'))
        @includeIf('superadmin::layouts.partials.active_subscription')
      @endif

        @if(!empty(session('previous_user_id')) && !empty(session('previous_username')))
            <a href="{{route('sign-in-as-user', session('previous_user_id'))}}" class="btn btn-flat btn-danger m-8 btn-sm mt-10"><i class="fas fa-undo"></i> @lang('lang_v1.back_to_username', ['username' => session('previous_username')] )</a>
        @endif
        <ul class="nav navbar-nav">
      
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              @php
                $profile_photo = auth()->user()->media;
              @endphp
              @if(!empty($profile_photo))
                <img src="{{$profile_photo->display_url}}" class="user-image" alt="User Image">
              @endif
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="nav-head">{{ Auth::User()->first_name }} {{ Auth::User()->last_name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                @if(!empty(Session::get('business.logo')))
                  <img src="{{ asset( 'uploads/business_logos/' . Session::get('business.logo') ) }}" alt="Logo">
                @endif
                <p>
                  {{ Auth::User()->first_name }} {{ Auth::User()->last_name }}
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{action([\App\Http\Controllers\UserController::class, 'getProfile'])}}" class="btn btn-default btn-flat">@lang('lang_v1.profile')</a>
                </div>
                <div class="pull-right">
                  <a href="{{action([\App\Http\Controllers\Auth\LoginController::class, 'logout'])}}" class="btn btn-default btn-flat">@lang('lang_v1.sign_out')</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        </ul>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">

        @if(Module::has('Essentials'))
          @includeIf('essentials::layouts.partials.header_part')
        @endif

        {{-- <div class="btn-group">
          <button id="header_shortcut_dropdown" type="button" class="btn btn-success dropdown-toggle btn-flat pull-left m-8 btn-sm mt-10" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-plus-circle fa-lg"></i>
          </button>
          <ul class="dropdown-menu">
            @if(config('app.env') != 'demo')
              <li><a href="{{route('calendar')}}">
                  <i class="fas fa-calendar-alt" aria-hidden="true"></i> @lang('lang_v1.calendar')
              </a></li>
            @endif
            @if(Module::has('Essentials'))
              <li><a href="#" class="btn-modal" data-href="{{action([\Modules\Essentials\Http\Controllers\ToDoController::class, 'create'])}}" data-container="#task_modal">
                  <i class="fas fa-clipboard-check" aria-hidden="true"></i> @lang( 'essentials::lang.add_to_do' )
              </a></li>
            @endif
            <!-- Help Button -->
            @if(auth()->user()->hasRole('Admin#' . auth()->user()->business_id))
              <li><a id="start_tour" href="#">
                  <i class="fas fa-question-circle" aria-hidden="true"></i> @lang('lang_v1.application_tour')
              </a></li>
            @endif
          </ul>
        </div> --}}
        {{-- <button id="btnCalculator" title="@lang('lang_v1.calculator')" type="button" class="btn btn-success btn-flat pull-left m-8 btn-sm mt-10 popover-default hidden-xs" data-toggle="popover" data-trigger="click" data-content='@include("layouts.partials.calculator")' data-html="true" data-placement="bottom">
            <strong><i class="fa fa-calculator fa-lg" aria-hidden="true"></i></strong>
        </button> --}}
        
        @if($request->segment(1) == 'pos')
          @can('view_cash_register')
          <button type="button" id="register_details" title="{{ __('cash_register.register_details') }}" data-toggle="tooltip" data-placement="bottom" class="btn-pill btn btn-success btn-flat pull-left m-8 btn-sm mt-10 btn-modal" data-container=".register_details_modal" 
          data-href="{{ action([\App\Http\Controllers\CashRegisterController::class, 'getRegisterDetails'])}}">
            <strong><i class="fa fa-briefcase fa-lg" aria-hidden="true"></i></strong>
          </button>
          @endcan
          @can('close_cash_register')
          <button type="button" id="close_register" title="{{ __('cash_register.close_register') }}" data-toggle="tooltip" data-placement="bottom" class="btn-pill btn btn-danger btn-flat pull-left m-8 btn-sm mt-10 btn-modal" data-container=".close_register_modal" 
          data-href="{{ action([\App\Http\Controllers\CashRegisterController::class, 'getCloseRegister'])}}">
            <strong><i class="fa fa-window-close fa-lg"></i></strong>
          </button>
          @endcan
        @endif

        @if(in_array('pos_sale', $enabled_modules))
          @can('sell.create')
            <a href="{{action([\App\Http\Controllers\SellPosController::class, 'create'])}}" title="@lang('sale.pos_sale')" data-toggle="tooltip" data-placement="bottom" class="btn m-8 mt-10 btn-primary btn-pos">
              <strong><i class="fa fa-th-large"></i> &nbsp; @lang('sale.pos_sale')</strong>
            </a>
          @endcan
        @endif

        @if(Module::has('Repair'))
          @includeIf('repair::layouts.partials.header')
        @endif

        @can('profit_loss_report.view')
          <button type="button" id="view_todays_profit" title="{{ __('home.todays_profit') }}" data-toggle="tooltip" data-placement="bottom" class="btn btn-primary   pull-left m-8 btn-sm mt-10 btn-report">
            <strong><i class="fas fa-money-bill-alt fa-lg"></i></strong>
          </button>
        @endcan
        <div class="m-8 pull-left mt-15 hidden-xs" style="margin-top: 0px;">
          <h3 class="time nav-head" style="margin-bottom: 0px;">
              <span id="hours">{{ \Carbon\Carbon::now()->format('H') }}</span>
              <span id="point">:</span>
              <span id="min">{{ \Carbon\Carbon::now()->format('i') }}</span>
          </h3>
          <span class="date"><span id="date" style="color:#727289;">{{ \Carbon\Carbon::now()->format('Y-m-d') }}</span></span>
        </div>
        {{-- <d iv class="m-8 pull-left mt-15 hidden-xs" style="color: #fff;"><strong>{{ @format_date('now') }}</strong></div> --}}

        <ul class="nav navbar-nav">
          @include('layouts.partials.header-notifications')
          <!-- User Account Menu -->
          
          <!-- Control Sidebar Toggle Button -->
        </ul>
      </div>
    </nav>
  </header>