@extends('layouts.admin.app')
@section('css')
<style>
  .content-label::after {
    content: "*";
    color: red;
}
</style>
@endsection 
@section('content')
<div class="content-wrapper">
<section class="content-header">
  <h1>
    Configurations
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
    <li><a href="{{route('setting.index')}}">Configurations</a></li>
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
            <div class="box-body">
                <form action="{{route('setting.update')}}" method="POST" id="setting" enctype="multipart/form-data">
                    @csrf
                  <div class="modal-body">
                    @foreach($settings as $k=>$v)
                      
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="content" class="content-label">{{ucwords(str_replace('_',' ',$k))}}</label>
                          <input class="form-control" minlength="2" maxlength="255" placeholder="" name="{{$k}}" type="text" value="{{$v}}">
                          @error(strtolower($k))
                            <div class="help-block">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    
                    @endforeach
                  </div>
                  
                  <div class="modal-footer">
                    <button id="edit_btn" type="submit" class="btn btn-info btn-fill btn-wd">Save</button>
                  </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>
@endsection

