@extends('layouts.admin.app')
@section('css')
<link rel="stylesheet" href="{{asset('adminAsset/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('adminAsset/bower_components/datatables.net-bs/css/buttons.dataTables.min.css')}}">
<style type="text/css">
  td form{
    display: inline;
  }
  .dt-buttons{
    margin-right: 10px;
  }
  .select2-selection {
    padding: 0px 5px !important;
  }
  .fa-trash {color: red}
</style>
@endsection    
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Product Management
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{route('products.index')}}">Product List</a></li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-info">
          <div class="box-header">
            <h3 class="box-title">Products</h3>
            <h3 class="box-title pull-right"><a href="{{route('products.create')}}" class="btn btn-success pull-right">Add new Product</a></h3>
          </div>
          <div class="box-body">
            <table id="datalist_table" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>SKU</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>SKU</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
@section('js')
<script src="{{asset('adminAsset/bower_components/datatables.net-bs/export/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('adminAsset/bower_components/datatables.net-bs/export/jszip.min.js')}}"></script>
<script src="{{asset('adminAsset/bower_components/datatables.net-bs/export/buttons.html5.min.js')}}"></script>
<!-- <script src="{{asset('adminAsset/bower_components/datatables.net-bs/export/buttons.print.min.js')}}"></script> -->
<script type="text/javascript">
  $(document).on('change','.item_status',function(){
    var status = $(this).val();
    var id = $(this).attr('id');
    var delay = 500;
    var element = $(this);
    $.ajax({
      type:'post',
      url: "{{route('status_pizza')}}",
      data: {
              "status": status, 
              "id" : id,  
              "_token": "{{ csrf_token() }}"
            },
      beforeSend: function () {
          element.next('.loading').css('visibility', 'visible');
      },
      success: function (data) {
        setTimeout(function() {
              element.next('.loading').css('visibility', 'hidden');
          }, delay);
        toastr.success(data.success);
      },
      error: function () {
        toastr.error(data.error);
      }
    })
  })
  $(document).ready(function(){
    fill_datatable();
    function fill_datatable() {
      var table = $('#datalist_table').DataTable({
        aaSorting : [[0, 'desc']],
        dom: 'Blfrtip',
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        pageLength: 10,
        buttons: [
          /*{
            extend: 'excel',
            text: '<span class="fa fa-file-excel-o"></span> {{trans("common.export")}}',
            exportOptions: {
                modifier: {
                    search: 'applied',
                    order: 'applied'
                },
                columns: [0,1,2,3,6]
            },
          },*/
          // {
          //     extend: 'print',
          //     text: '<i class="fa fa-print" aria-hidden="true"></i> {{trans("common.print")}}',
          //     autoPrint: true,
          //     exportOptions: {
          //         modifier: {
          //             search: 'applied',
          //             order: 'applied'
          //         },
          //         columns: [0, 1, 2, 3]
          //     },
          // }

        ],
        processing: true,
        serverSide: true,
        serverMethod:'POST',
        processing: true,
        language: {
              processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">{{trans("common.loading")}}</span>',
        },
        ajax: {
            url: "{{route('dt_products')}}",
            data: {"_token": "{{csrf_token()}}"},
        },
        columns: [
          { data: 'id'},
          { data: 'name',orderable: false},
          { data: 'sku',orderable: false},
          { data: 'status',
            mRender : function(data, type, row) {
                  var status=data;
                  if(status=='active'){
                    type = "selected";
                    data = '';
                  } else {
                    data = 'selected';
                    type = '';
                  }
                  return '<select class="item_status form-control" id="'+row["id"]+'"><option value="active"'+type+'>'+'Active'+'</option><option value="inactive"'+data+'>'+'InActive'+'</option></select><span class="loading" style="visibility: hidden;"><i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><span class="sr-only">'+'{{trans("common.loading")}}'+'</span></span>';
              },orderable: true
          },
          { 
            mRender : function(data, type, row) {
                return '<a class="btn" href="'+row["edit"]+'"><i class="fa fa-edit"></i></a><!--<a class="btn" href="'+row["show"]+'"><i class="fa fa-eye"></i></a>--><form action="'+row["delete"]+'" method="post" onsubmit=" return delete_alert()"><button class="btn" type="submit" ><i class="fa fa-trash"></i></button>@method("delete")@csrf</form>';  
            }, orderable: false, searchable: false
          },
        ]
      });
    }
    $('.select2').select2();
  });
  function delete_alert() {
    if(confirm("Do you really want to delete the item?")){
      return true;
    } else {
      return false;
    }
  }
</script>
@endsection