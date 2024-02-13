
<header class="main-header">

    <!-- Logo -->
    <a href="{{route('home')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">{{ @$app_settings['app_short_name'] }}</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="{{asset('website/images/logo.png')}}"></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            
            @can('notification-list')
            <!-- <li class="dropdown user user-menu @if(request()->is('admin/notifications*')) active @endif">
              <a href="{{route('notifications.index')}}"><i class="fa fa-bell"></i></a>
            </li> -->
            @endcan
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            
              <span class="hidden-xs">{{ (Auth::user()->first_name) ? Auth::user()->first_name : @Auth::user()->profile->first_name  }}</span>
            </a>
            <ul class="dropdown-menu">
             
              <!-- Menu Footer-->
              <li class="user-footer">
                
                <div class="pull-right">
                    <a href="#" class="btn btn-default btn-flat" href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                    Sign Out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>

    </nav>
</header>