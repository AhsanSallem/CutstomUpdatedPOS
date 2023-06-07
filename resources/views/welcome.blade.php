@extends('layouts.auth2')
@section('title', __('lang_v1.login'))

@section('content')
<div class="mn-vh-100 d-flex align-items-center">
    <div class="container">
      <div class="card justify-content-center auth-card">
        <div class="row justify-content-center">
          <div class="col-xl-7 col-lg-9">
            <h4 class="mb-5 font-20">Welcome To @lang('lang_v1.login')
            </h4>
            <form method="POST" action="{{ route('login') }}" id="login-form">
                {{ csrf_field() }}
                @php
                $username = old('username');
                $password = null;
                if(config('app.env') == 'demo'){
                    $username = 'admin';
                    $password = '123456';

                    $demo_types = array(
                        'all_in_one' => 'admin',
                        'super_market' => 'admin',
                        'pharmacy' => 'admin-pharmacy',
                        'electronics' => 'admin-electronics',
                        'services' => 'admin-services',
                        'restaurant' => 'admin-restaurant',
                        'superadmin' => 'superadmin',
                        'woocommerce' => 'woocommerce_user',
                        'essentials' => 'admin-essentials',
                        'manufacturing' => 'manufacturer-demo',
                    );

                    if( !empty($_GET['demo_type']) && array_key_exists($_GET['demo_type'], $demo_types) ){
                        $username = $demo_types[$_GET['demo_type']];
                    }
                }
            @endphp
              <div class="form-group mb-20">
                <label for="username" class="mb-2 font-14 bold black">User Name
                </label> 
                <input id="username" type="text" name="username" class="theme-input-style" value="{{ $username }}" required autofocus placeholder="@lang('lang_v1.username')">
                @if ($errors->has('username'))
                <span class="help-block">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
                 @endif
              </div>
              <div class="form-group mb-20">
                <label for="password" class="mb-2 font-14 bold black">Password
                </label> 
                <input id="password" type="password" class="theme-input-style" name="password"
                value="{{ $password }}" required placeholder="@lang('lang_v1.password')">
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
              </div>
              <div class="d-flex justify-content-between mb-20">
                <div class="d-flex align-items-center">
                  <label class="custom-checkbox position-relative mr-2">
                    <input type="checkbox" id="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 

                  </label> 
                  <label for="checkbox" class="font-14">@lang('lang_v1.remember_me')
                  </label>
                </div>
                @if(config('app.env') != 'demo')
                <a href="{{ route('password.request') }}" class="font-12 text_color">
                    @lang('lang_v1.forgot_your_password')
                </a>
                 @endif
                </a>
              </div>
              <div class="d-flex align-items-center">
                <button type="submit" class="btn long mr-20">@lang('lang_v1.login')</button>
              
              </div>
            </form>
          </div>
          @if(config('app.env') == 'demo')
          <div class="col-md-12 col-xs-12" style="padding-bottom: 30px;">
              @component('components.widget', ['class' => 'box-primary', 'header' => '<h4 class="text-center">Demo Shops <small><i> Demos are for example purpose only, this application <u>can be used in many other similar businesses.</u></i></small></h4>'])
      
                  <a href="?demo_type=all_in_one" class="btn btn-app bg-olive demo-login" data-toggle="tooltip" title="Showcases all feature available in the application." data-admin="{{$demo_types['all_in_one']}}"> <i class="fas fa-star"></i> All In One</a>
      
                  <a href="?demo_type=pharmacy" class="btn bg-maroon btn-app demo-login" data-toggle="tooltip" title="Shops with products having expiry dates." data-admin="{{$demo_types['pharmacy']}}"><i class="fas fa-medkit"></i>Pharmacy</a>
      
                  <a href="?demo_type=services" class="btn bg-orange btn-app demo-login" data-toggle="tooltip" title="For all service providers like Web Development, Restaurants, Repairing, Plumber, Salons, Beauty Parlors etc." data-admin="{{$demo_types['services']}}"><i class="fas fa-wrench"></i>Multi-Service Center</a>
      
                  <a href="?demo_type=electronics" class="btn bg-purple btn-app demo-login" data-toggle="tooltip" title="Products having IMEI or Serial number code."  data-admin="{{$demo_types['electronics']}}" ><i class="fas fa-laptop"></i>Electronics & Mobile Shop</a>
      
                  <a href="?demo_type=super_market" class="btn bg-navy btn-app demo-login" data-toggle="tooltip" title="Super market & Similar kind of shops." data-admin="{{$demo_types['super_market']}}" ><i class="fas fa-shopping-cart"></i> Super Market</a>
      
                  <a href="?demo_type=restaurant" class="btn bg-red btn-app demo-login" data-toggle="tooltip" title="Restaurants, Salons and other similar kind of shops." data-admin="{{$demo_types['restaurant']}}"><i class="fas fa-utensils"></i> Restaurant</a>
                  <hr>
      
                  <i class="icon fas fa-plug"></i> Premium optional modules:<br><br>
      
                  <a href="?demo_type=superadmin" class="btn bg-red-active btn-app demo-login" data-toggle="tooltip" title="SaaS & Superadmin extension Demo" data-admin="{{$demo_types['superadmin']}}"><i class="fas fa-university"></i> SaaS / Superadmin</a>
      
                  <a href="?demo_type=woocommerce" class="btn bg-woocommerce btn-app demo-login" data-toggle="tooltip" title="WooCommerce demo user - Open web shop in minutes!!" style="color:white !important" data-admin="{{$demo_types['woocommerce']}}"> <i class="fab fa-wordpress"></i> WooCommerce</a>
      
                  <a href="?demo_type=essentials" class="btn bg-navy btn-app demo-login" data-toggle="tooltip" title="Essentials & HRM (human resource management) Module Demo" style="color:white !important" data-admin="{{$demo_types['essentials']}}">
                          <i class="fas fa-check-circle"></i>
                          Essentials & HRM</a>
                          
                  <a href="?demo_type=manufacturing" class="btn bg-orange btn-app demo-login" data-toggle="tooltip" title="Manufacturing module demo" style="color:white !important" data-admin="{{$demo_types['manufacturing']}}">
                          <i class="fas fa-industry"></i>
                          Manufacturing Module</a>
      
                  <a href="?demo_type=superadmin" class="btn bg-maroon btn-app demo-login" data-toggle="tooltip" title="Project module demo" style="color:white !important" data-admin="{{$demo_types['superadmin']}}">
                          <i class="fas fa-project-diagram"></i>
                          Project Module</a>
      
                  <a href="?demo_type=services" class="btn btn-app demo-login" data-toggle="tooltip" title="Advance repair module demo" style="color:white !important; background-color: #bc8f8f" data-admin="{{$demo_types['services']}}">
                          <i class="fas fa-wrench"></i>
                          Advance Repair Module</a>
      
                  <a href="{{url('docs')}}" target="_blank" class="btn btn-app" data-toggle="tooltip" title="Advance repair module demo" style="color:white !important; background-color: #2dce89">
                          <i class="fas fa-network-wired"></i>
                          Connector Module / API Documentation</a>
              @endcomponent   
          </div>
          @endif 
        </div>
      </div>
    </div>
  </div>
  @stop
@section('javascript')
<script type="text/javascript">
    $(document).ready(function(){
        $('#change_lang').change( function(){
            window.location = "{{ route('login') }}?lang=" + $(this).val();
        });

        $('a.demo-login').click( function (e) {
           e.preventDefault();
           $('#username').val($(this).data('admin'));
           $('#password').val("{{$password}}");
           $('form#login-form').submit();
        });
    })
</script>
@endsection