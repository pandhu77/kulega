@extends('backend/app')
@section('content')
<title>System | Order</title>
<div class="page-title">
  <div class="title_left">
    <h3>List Order</h3>
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

    <div class="x_panel">
      <div class="x_title">
        <!-- <h2>List Data <small>Order Management</small></h2> -->
        <!-- <div class="text-right" style="margin-bottom:20px;">
                    <a href="{{ url('backend/recent-order/create') }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add New</a>
                </div> -->
        <form class="" action="{{ url('backend/report-order') }}" method="get">
            <div class="form-group">
                <label for="inputEmail3" style="padding-left:0px;padding-right:0px;" class="col-sm-1 text-left">Order Date</label>
                <div class="col-sm-2" style="padding-left:0px;padding-right:0px;">
                      <input type="text" class="form-control" id="dateFrom"   placeholder="From"  name="datefrom" required value="<?php if(!empty($_GET['datefrom'])){echo $_GET['datefrom'];} ?>">
                </div>
                <label for="inputEmail3"style="padding-left:0px;padding-right:0px;" class="col-sm-1 text-center" style="height: 34px; padding: 0px; ">-</label>
                <div class="col-sm-2"style="padding-left:0px;padding-right:0px;">
                      <input type="text" class="form-control" id="dateTo"  placeholder="To" name="dateto" required value="<?php if(!empty($_GET['dateto'])){echo $_GET['dateto'];} ?>">
                </div>
                <div class="col-sm-2"style="padding-left:0px;padding-right:0px;">
                      <button type="submit" class="btn btn-warning">Search</button>
                </div>
            </div>
        </form>

        <form class="" action="{{ url('backend/report-order/print') }}" method="post" style="text-align:right;" target="_blank">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="datefrom" value="<?php if(!empty($_GET['datefrom'])){echo $_GET['datefrom'];} ?>">
            <input type="hidden" name="dateto" value="<?php if(!empty($_GET['dateto'])){echo $_GET['dateto'];} ?>">
            <button type="buttom" class="btn btn-success" name="button" onclick="myFunction()">Print</button>
        </form>
        <div class="clearfix"></div>

      </div>
      <div class="x_content">
        @if(Session::has('success-create'))
          <div class="alert alert-success alert-dismissible fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4>  <i class="icon fa fa-check"></i> Success!</h4>
            {{ Session::get('success-create') }}
          </div>
        @endif
        @if(Session::has('error_get'))
          <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i></h4>
            {{ Session::get('error_get') }}
          </div>
        @endif

        @if(Session::has('success-delete'))
          <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4>  <i class="icon fa fa-check"></i> Success!</h4>
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
        <div class="table-responsive">
            <table id="datatable" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Invoice ID</th>
                  <th>Order Date</th>
                  <th>Members</th>
                  <th>Payment Status</th>
                  <th>Order Status</th>
                  <th>Total</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                @foreach($order as $data)
                  <tr>
                    <td data-label="#">#{{$data->order_id}}</td>

                    <td data-label="Order Date">{{$data->order_date}}</td>
                    <td data-label="Member">{{$data->member_fullname}}</td>
                    <td data-label="Payment Status">
                        @if($data->payment_status==2)
                            <span class="label label-success">Accepted </span>
                        @elseif($data->payment_status==1)
                            <span class="label label-default">Waiting Confirmation</span>
                        @elseif($data->payment_status==3)
                            <span class="label label-danger">Failed</span>
                        @else
                            <span class="label label-warning">Waiting Payment</span>
                        @endif
                    </td>
                    <td data-label="Enable">
                        @if($data->order_status==0)
                              <span class="label label-warning"> Pending </span>
                        @elseif($data->order_status==1)
                              <span class="label label-primary">  Processing </span>
                        @elseif($data->order_status==2)
                            <span class="label label-default">@if($data->dilivery_method=='pick') Ready to Pickup @else Ready to Send   @endif</span>
                        @elseif($data->order_status==3)
                            <span class="label label-primary"  style="background-color:#DA70D6">@if($data->dilivery_method=='pick') In Pickup  @else In Delivery @endif</span>
                        @elseif($data->order_status==4)
                            <span class="label label-success"> Completed(Send) </span>
                        @elseif($data->order_status==5)
                           <span class="label label-danger"> Canceled  </span>
                       @endif
                    </td>
                    <td data-label="Total"><span class="price_format">{{$data->order_total}}</span></td>

                    <td data-label="Action">
                      <div  class="btn-group">
                        <form id="{{ $data->order_id }}" action="{{ url('backend/recent-order/'.$data->order_id)}}" method="post">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="_method" value="DELETE">
                          <?php
                          if($data->payment_status==1 and $data->payment_service==1){?>

                          <a href="#" class="btn btn-sm btn-warning" title="Transfer Detail" data-toggle="modal" data-target="#quickModal{{$data->order_id}}"><i class="fa fa-exchange"></i></a>
                          <?php } ?>
                         <?php if($data->payment_status==2 and $data->payment_service==1){?>

                          <a href="#" class="btn btn-sm btn-success" title="Transfer Detail" data-toggle="modal" data-target="#quickModal{{$data->order_id}}"><i class="fa fa-exchange"></i></a>
                          <?php } ?>
                          <a href="{{ url('backend/recent-order/show/'.$data->order_id)}}" title="View This Order" data-toggle="tooltip" class="btn btn-sm btn-primary" data-toggle="tooltip"><span class="fa fa-edit" aria-hidden="true"></span></a>

                          <button type="button"  title="Cancel This Order" data-toggle="tooltip" class="btn btn-danger btn-sm" data-toggle="tooltip" onclick="checkdelete({{$data->order_id}})"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
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
  </div>

  <script type="text/javascript">
      $(document).ready(function() {
        $('#datatable').DataTable( {
            "order": [[ 1, "desc" ]]
        } );
    } );
  </script>
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

        swal("Deleted!", "Your order has been canceled.", "success");
      } else {
        swal("Cancelled", "", "error");
      }
      });
  }
  </script>

  <script type="text/javascript">
      $(function () {
          $("#dateFrom").datepicker({
              numberOfMonths: 2,
              dateFormat: 'yy-mm-dd',
              onSelect: function (selected) {
                  var dt = new Date(selected);
                  dt.setDate(dt.getDate() + 1);
                  $("#txtTo").datepicker("option", "minDate", dt);
              }


          });
          $("#dateTo").datepicker({
              numberOfMonths: 2,
              dateFormat: 'yy-mm-dd',
              onSelect: function (selected) {
                  var dt = new Date(selected);
                  dt.setDate(dt.getDate() - 1);
                  $("#txtFrom").datepicker("option", "maxDate", dt);
              }
          });
      });
  </script>
@endsection