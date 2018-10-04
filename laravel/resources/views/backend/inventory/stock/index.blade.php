@extends('backend/app')
@section('content')
<title>System | Product </title>
<div class="page-title">

  <div class="col-sm-12 title_left">
    <h3>Inventory Stock Management <small>show all product</small></h3>

  </div>
</div>
<div class="clearfix"></div>
  <div class="col-md-12 col-sm-12 col-xs-12">

    <ul class="nav nav-pills" style="text-align: center;">
      <li class="active"><a href="#ampty" data-toggle="tab">STOCK AVAILABLE</a></li>
      <li class=""><a href="#available" data-toggle="tab">STOCK EMPTY</a></li>
    </ul>
    <div class="tab-content"style="margin-top:30px;">
      @if(Session::has('success-create'))
          <div class="alert alert-success alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4>	<i class="icon fa fa-check"></i> Alert!</h4>
              {{ Session::get('success-create') }}
          </div>
        @endif
       @if(Session::has('success-update'))
          <div class="alert alert-success alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4>  <i class="icon fa fa-check"></i> Alert!</h4>
              {{ Session::get('success-update') }}
          </div>
        @endif
      @if(Session::has('success-delete'))
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4>	<i class="icon fa fa-check"></i> Alert!</h4>
            {{ Session::get('success-delete') }}
        </div>
      @endif
      @if(Session::has('no-delete'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></h4>
            {{ Session::get('no-delete') }}
        </div>
      @endif
      @if($errors->all())
      <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></h4>
        @foreach($errors->all() as $error)
        <?php echo $error."</br>";?>
        @endforeach
      </div>
      @endif
      <!-- First tab -->
      <div class="tab-pane active" id="ampty">
            <div class="x_panel">
              <div class="x_title">
                <h2>Inventory Stock list</h2>
                <div class="text-right" style="margin-bottom:20px;">
                      <a href="{{ url('backend/inventory/in/create') }}" class="btn btn-primary"><span class="fa fa-plus" aria-hidden="true" style="color:#fff;"></span> Add Inventory</a>
                </div>
                <div class="clearfix"></div>

              </div>
              <div class="x_content">
                <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Inventory ID</th>
                      <th>Inventory Product</th>
                      <th>Inventory Size</th>
                      <th>Inventory Color</th>
                      <th>Inventory Stock</th>
                      <th>Action</th>
                    </tr>
                  </thead>

                  <tbody>
                    @foreach($stock as $data)

                      <tr>
                        <td data-label="#">{{$data->inv_stock_id}}</td>
                        <td data-label="Product ">
                          Code: {{$data->prod_code}} - {{$data->prod_name}}<br>
                        </td>
                        <td data-label="Product ">
                          @if($data->inv_stock_size !==''){{$data->inv_stock_size}} @else - @endif<br>
                        </td>
                        <td data-label="Product ">
                          @if($data->inv_stock_color !==''){{$data->inv_stock_color}} @else - @endif<br>
                        </td>
                        <td data-label="Product ">
                          {{$data->inv_stock_qty}}<br>
                        </td>
                        <td data-label="Action">
                          <div  class="btn-group">
                            <form id="{{ $data->inv_stock_id }}" action="{{ url('backend/inventory/stock/'.$data->inv_stock_id)}}" method="get">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <input type="hidden" name="_method" value="DELETE">
                              <!-- <a href="{{ url('backend/inventory/stock/'.$data->inv_stock_id.'/edit')}}" title="View This Inventory" data-toggle="tooltip" class="btn btn-sm btn-primary" data-toggle="tooltip"><span class="fa fa-edit" aria-hidden="true"></span></a> -->
                              <button type="button"  title="Delete This Inventory" data-toggle="tooltip" class="btn btn-danger btn-sm" data-toggle="tooltip" onclick="checkdelete({{$data->inv_stock_id}})"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                            </form>
                          </div>
                        </td>
                      </tr>

                    @endforeach
                  </tbody>
                </table>
              </div>
          </div>
        </div>
        <!-- two tab -->
        <div class="tab-pane" id="available">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Inventory Stock list</h2>

                  <div class="text-right" style="margin-bottom:20px;">
                              <a href="{{ url('backend/inventory/in/create') }}" class="btn btn-primary"><span class="fa fa-plus" aria-hidden="true" style="color:#fff;"></span> Add Inventory</a>
                          </div>
                  <div class="clearfix"></div>

                </div>
                <div class="x_content">
                  <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Inventory ID</th>
                        <th>Inventory Product</th>
                        <th>Inventory Size</th>
                        <th>Inventory Color</th>
                        <th>Inventory Stock</th>
                        <th >Action</th>
                      </tr>
                    </thead>

                    <tbody>
                      @foreach($stockkosong as $data)

                        <tr>
                          <td data-label="#">{{$data->inv_stock_id}}</td>
                          <td data-label="Product ">
                            Code: {{$data->prod_code}} - {{$data->prod_name}}<br>
                          </td>
                          <td data-label="Product ">
                            @if($data->inv_stock_size !==''){{$data->inv_stock_size}} @else - @endif<br>
                          </td>
                          <td data-label="Product ">
                            @if($data->inv_stock_color !==''){{$data->inv_stock_color}} @else - @endif<br>
                          </td>
                          <td data-label="Product ">
                            {{$data->inv_stock_qty}}<br>
                          </td>

                          <td data-label="Action" class="btn-group">
                            <form id="{{ $data->inv_stock_id }}" action="{{ url('backend/inventory/stock/'.$data->inv_stock_id)}}" method="get">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <input type="hidden" name="_method" value="DELETE">
                              <!-- <a href="{{ url('backend/inventory/stock/'.$data->inv_stock_id.'/edit')}}" title="View This Inventory" data-toggle="tooltip" class="btn btn-sm btn-primary" data-toggle="tooltip"><span class="fa fa-edit" aria-hidden="true"></span></a> -->

                              <button type="button"  title="Delete This Inventory" data-toggle="tooltip" class="btn btn-danger btn-sm" data-toggle="tooltip" onclick="checkdelete({{$data->inv_stock_id}})"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                            </form>
                          </td>
                        </tr>

                      @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
          </div>
      </div>
  </div>
  <script>
  function checkdelete(id){

    swal({
      title: "Are you sure?",
      text: "",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Confirm",
      cancelButtonText: "Cancel",
      closeOnConfirm: false,
      closeOnCancel: false
      },
      function(isConfirm){
      if (isConfirm) {

        $('#'+id).submit();

        swal("Deleted!", "Your imaginary file has been deleted.", "success");
      } else {
        swal("Cancelled", "", "error");
      }
      });
  }
  </script>

  @endsection
