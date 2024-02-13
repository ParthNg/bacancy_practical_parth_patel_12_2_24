<?php
$routename = Route::currentRouteName();
?>
<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      
      @if(auth()->user()->user_type == 'admin')
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="@if($routename == 'home') active @endif">
          <a href="{{route('home')}}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        
        <li class="{{ (request()->is('admin/products*')) ? 'active' : '' }}">
          <a href="{{route('products.index')}}">
            <i class="fa fa-user-o"></i> <span>Products</span>
          </a>
        </li>
        
        <li class="{{ (request()->is('admin/setting*')) ? 'active' : '' }}">
          <a href="{{route('setting.index')}}">
            <i class="fa fa-cog"></i> <span>Configurations</span>
          </a>
        </li> 
        
      </ul>
      @endif
    </section>
  </aside>