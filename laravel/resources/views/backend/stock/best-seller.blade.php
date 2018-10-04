@extends('backend/app')
@section('content')
<title>System | Stock </title>
<div class="page-title">
  <div class="title_left">
    <h3>Best Seller <small>show all product</small>
    </h3>
  </div>
  <!-- <div class="title_right">
    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for...">
        <span class="input-group-btn">
          <button class="btn btn-default" type="button">Go!</button>
        </span>
      </div>
    </div>
  </div> -->
</div>
<div class="clearfix"></div>
  <div class="col-md-12 col-sm-12 col-xs-12">
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

    <div class="x_panel">
      <div class="x_title">
        <h2>Master Data <small>Product</small></h2>
        <div class="text-right" style="margin-bottom:20px;">
            <form class="" action="{{ url('backend/product-best-seller') }}" method="get">
                <div class="input-form">
                    <label for="">Show : </label>
                    <input type="text" name="showed" placeholder="Number" value="<?php echo $_GET['showed'] ?>" style="height: 34px;border-radius: 5px;">
                    <button class="btn btn-default" type="submit">OK</button>
                </div>
            </form>
        </div>
        <div class="clearfix"></div>

      </div>
      <div class="x_content">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th width="5%">Image</th>
              <th>Product Title</th>
              <th>Price(IDR)</th>
              <th>Stock</th>
              <th>Sold</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
            @foreach($prod as $key => $data)
            @if($key == $_GET['showed'])
                <?php break; ?>
            @endif
              <tr>
                <td data-label="#"><?php echo $key + 1; ?></td>
                <td data-label="Image"><img src="{{asset($data->front_image)}}"class="img-responsive"></td>
                <td data-label="Title">{{$data->prod_title}}</td>
                <td data-label="Price"><?php echo number_format($data->prod_price,0,',','.') ?></td>
                <td data-label="Stock">{{$data->prod_stock}}</td>
                <td data-label="Sold">{{$data->prod_sold}}</td>
                <td data-label="Action">
                  <div  class="btn-group">
                    <form id="{{ $data->prod_id }}" action="{{ url('backend/product/'.$data->prod_id)}}" method="post">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="_method" value="DELETE">
                      <a href="{{ url('backend/product/'.$data->prod_id.'/edit')}}" title="View This Product" data-toggle="tooltip" class="btn btn-sm btn-primary" data-toggle="tooltip"><span class="fa fa-edit" aria-hidden="true"></span></a>
                      <!-- <a href="{{ url('backend/product-stock/show/'.$data->prod_id)}}" title="Management Stock Product" data-toggle="tooltip" class="btn btn-sm btn-success" data-toggle="tooltip"><span class="fa fa-cube" aria-hidden="true"></span></a> -->
                      <!-- <button type="button"  title="Delete This Product" data-toggle="tooltip" class="btn btn-danger btn-sm" data-toggle="tooltip" onclick="checkdelete({{$data->prod_id}})"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button> -->
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
