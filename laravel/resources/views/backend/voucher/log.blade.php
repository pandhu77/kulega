@extends('backend/app')
@section('content')
<title>System | Voucher </title>
<div class="page-title">
  <div class="title_left">
    <h3>Voucher Log</h3>
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

        <!-- <h2>Master Data <small>Voucher</small></h2>
        <div class="text-right" style="margin-bottom:20px;">
            <a href="{{ url('backend/voucher/create') }}" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add New</a>
        </div> -->
        <form class="" action="{{ url('backend/voucher-log') }}" method="get">
            <div class="form-group">
                <label for="inputEmail3" style="padding-left:0px;padding-right:0px;" class="col-sm-1 text-left">Log Date</label>
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
        <div class="clearfix"></div>

      </div>
      <div class="x_content">
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

          <div class="col-md-7">
              <pre style="max-height:500px;overflow-y:auto;">@if(empty($log))
                    Empty
                  @else @foreach($log as $lo)<?php $voucher = DB::table('ms_voucher')->where('voucher_id',$lo->voucher_id)->first(); ?>[<?= date('d M Y H:i:s',strtotime($lo->created_at)) ?>] <?php if($lo->member_id == 0){echo "Guest";}else{echo "Member";} ?> {{ $lo->member_name }} used voucher code => {{ $voucher->voucher_code }}<br>@endforeach @endif
              </pre>
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
