@extends('layouts.admin.app')

@section('css')
  <style>
    .select2-container {border: 1px solid #fd9d3e;}
    #EnquiryChart{border: 2px solid #fd9d3e;}
  </style>
@endsection

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="{{route('products.index')}}">
            <div class="info-box">
              <span class="info-box-icon bg-yellow" style="padding: 20px;"><i class="fa fa-list"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Products</span>
                <span class="info-box-number">{{$total_products}}</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="{{route('sent_notification_manually')}}" class="btn btn-success pull-right" contenteditable="false" style="cursor: pointer;">Send Notification Mannually</a>
        </div>
      </div>

       <!-- Info boxes -->
       <div class="row">

        <div class="col-md-7">
          <h3>Inventory Map</h3>
          <table class="table" style="background-color: #fff;">
            <tr>
              <th>Product</th>
              <th>SKU</th>
              <th>Inventory</th>
            </tr>
            @foreach($products as $product) 
              <tr>
                <td>{{$product->name}}</td>
                <td>{{$product->sku}}</td>
                <td>
                  <div>
                    <table>
                    @foreach($product->product_inventory as $inv)
                      <tr>
                        <td>
                          Lot: {{$inv->lot_name}}<br/>
                          Quantity: {{$inv->quantity}}<br/>
                          Expiry Date: {{$inv->expiry_date}}<br/>
                          <hr/>
                        </td>
                      </tr>
                    @endforeach
                    </table>
                  </div>
                </td>
              </tr>
            @endforeach

          </table>
        </div>
      
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection

@section('js')
<!-- jvectormap  -->
<script src="{{ asset('adminAsset/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('adminAsset/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('adminAsset/bower_components/chart.js/Chart.js') }}"></script>
<!-- adminAssetLTE for demo purposes -->
<script src="{{ asset('adminAsset/dist/js/demo.js') }}"></script>


@section('css')
<!-- <link rel="stylesheet" href="{{ asset('admin/dist/css/skins/_all-skins.min.css') }}"> -->
@endsection
