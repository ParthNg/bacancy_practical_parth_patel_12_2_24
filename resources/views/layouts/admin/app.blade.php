<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> {{ @$app_settings['app_name'] }} @if(@$page_title) - {{$page_title}} @endif</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon" href="{{asset('website/images/favicon.png')}}" type="image/x-icon">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('adminAsset/bower_components/bootstrap/dist/css/bootstrap.min.css') }} ">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminAsset/bower_components/font-awesome/css/font-awesome.min.css') }} ">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('adminAsset/bower_components/Ionicons/css/ionicons.min.css') }} ">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('adminAsset/bower_components/select2/dist/css/select2.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/multiselect/multiselect.css') }}">
  <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminAsset/dist/css/AdminLTE.min.css') }} ">
  
  <link rel="stylesheet" href="{{asset('adminAsset/plugins/datetimepicker/bootstrap-datetimepicker.min.css')}}">

  <!-- <link rel="stylesheet" href="{{ asset('admin/dist/css/AdminLTE.min.css') }} "> -->
  <!-- iCheck -->

  <link rel="stylesheet" href="{{ asset('adminAsset/dist/css/skins/_all-skins.min.css') }}">

  <!-- Toaster -->
  <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}" />
  <link rel="stylesheet" href="{{asset('adminAsset/custom/developer.css')}}" />
    <link rel="stylesheet" href="{{asset('css/select.dataTables.min.css')}}" />
 
  @yield('css')
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <audio id="beepAudio" preload="auto" src="{{asset('website/beep.mp3')}}"></audio>
    

  @include('layouts.admin.partials.header')  
  @include('layouts.admin.partials.sidebar')  
      @yield('content')
  @include('layouts.admin.partials.footer')


</div>

<!-- jQuery 3 -->
<script src="{{ asset('adminAsset/bower_components/jquery/dist/jquery.min.js') }} "></script>
<!-- Bootstrap 3.3.7 -->

<script src="{{ asset('adminAsset/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('adminAsset/dist/js/adminlte.min.js') }}"></script>



<!-- DataTables -->
<script src="{{asset('adminAsset/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminAsset/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('js/dataTables.select.min.js')}}"></script>
<!-- DataTables Checkbox -->
<script src="{{asset('js/dataTables.checkboxes.min.js')}}"></script>
<!--Toaster JS-->
<script src="{{asset('js/toastr.min.js')}}"></script>

<script type="text/javascript">
    @if(Session::has('success'))
      toastr.success("{{ Session::get('success') }}");
    @elseif(Session::has('error'))
      toastr.error("{{ Session::get('error') }}");
    @elseif(Session::has('warning'))
      toastr.warning("{{ Session::get('warning') }}");
    @elseif(Session::has('info'))
      toastr.info("{{ Session::get('info') }}");
    @endif
</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

@yield('js')
</body>
</html>