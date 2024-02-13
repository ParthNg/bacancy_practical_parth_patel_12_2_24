@extends('layouts.admin.app')
@section('css')

<meta name="apple-mobile-web-app-title" content="CodePen">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.4.0/cropper.css">

<style>
  .content-label::after {
    content: "*";
    color: red;
  }
  .deal_item_heading_h3 {margin-top: 10px;}
  .deal_items_row {background: #f9f9f9; margin-bottom:10px}
  .or_p {margin-bottom: 0px;}
  .for_items_select {max-height: 200px; overflow: auto;}
  legend {font-size: 16px;  padding-top: 10px; margin-bottom: 2px;}
</style>
@endsection
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
       Update Product
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li><a href="{{route('products.index')}}">Products</a></li>
      <li class="active">Edit</li>
    </ol>
  </section>
  <section class="content">
    @if ($errors->any())
      <div class="alert alert-danger">
        <b>Whoops</b>
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <div class="row">
      <div class="col-md-12">
        <div class="box box-warning">
              <div class="box-header with-border">
                  <h3 class="box-title">Product Details</h3>
                  <ul class="pull-right">
                      <a href="{{route('products.index')}}" class="btn btn-success">
                          <i class="fa fa-arrow-left"></i>
                          Back
                      </a>
                  </ul>
              </div>
          <div class="box-body">
            <form method="POST" id="editForm" accept-charset="UTF-8" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">
                <!-- <h4 class="box-section-title">Pizza Details</h4> -->
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="name" class="required_lable">Name</label>
                      <input class="form-control" placeholder="Enter Name" name="name" minlength="3" maxlength="100" type="text" value="{{$data->name}}" required>
                    </div>
                    <div class="form-group">
                      <label for="name" class="required_lable">SKU</label>
                      <input class="form-control" placeholder="Enter SKU" name="sku" minlength="3" maxlength="100" type="text" value="{{$data->sku}}" required>
                    </div>
                  </div>
                </div>

                <hr>
                  <div id="deals_items_div">
                    @foreach($lots as $lik=>$litem)
                    <!-- <input name="deal_item_{{$lik+1}}" value="{{$litem->id}}"> -->
                    <div class="row deal_items_row" data-row-index="{{$lik+1}}">
                      <div class="col-md-12 deal_item_heading">
                        <h3 class="pull-left deal_item_heading_h3">Lot {{$lik+1}}</h3>
                      </div>  
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="name" class="">Lot Name</label>
                          <input class="form-control numberonly" name="lot_name_{{$lik+1}}" value="{{$litem->lot_name}}">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="name" class="">Quantity</label>
                          <input class="form-control numberonly quantity" name="quantity_{{$lik+1}}" value="{{$litem->quantity}}">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="name" class="">Expiry Date</label>
                          <input class="form-control" type="date" name="expiry_date_{{$lik+1}}" value="{{$litem->expiry_date}}">
                        </div>
                      </div>
                    </div>
                    @endforeach
                    <div class="col-md-12 text-right">
                      <p class="btn btn-primary add-row">+ Add New</p>
                    </div>
                  </div>
                <hr>
                  

                </div>
              </div>
              <div class="modal-footer">
                <button id="action_btn" class="btn btn-info btn-fill btn-wd">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@section('js')

@include('admin.products.script')

@endsection
