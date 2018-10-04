@extends('backend/app')
@section('content')
<title>System | Inventory In </title>
<div class="page-title">
  <div class="title_left col-sm-12">
    <h3>Inventory In <small>show all Inventory In</small></h3>
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
      <div class="x_title ">
        <h2>Master Data <small>Inventory In</small></h2>

        <div class="clearfix"></div>

      </div>

      <!-- general form elements -->
      <div class="x_content">
        <div class="box-header with-border" style="text-align:center;margin-bottom:30px;" >
          <h3 class="box-title">Form Inventory In Report</h3>
        </div><!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="{{url('backend/inventory/report/in')}}" class="form-horizontal searching"method="GET">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <div class="box-body">
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
            <div class="row">
              <div class="col-md-6 col-md-offset-3">
                <div class="form-group">
                  <label class="col-sm-3 control-label">From Date</label>
                  <div class="col-sm-9">
                    <input class="form-control" type="text" name ="fromdate"  id="txtFrom" value="{{$from}}" data-provide="datepicker" data-date-format="yyyy-mm-dd"  placeholder="From">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">As of</label>
                  <div class="col-sm-9">
                    <input class="form-control" data-provide="datepicker"  id="txtTo"  value="{{$end}}" type="text" name ="enddate"  data-date-format="yyyy-mm-dd"  placeholder="Until">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Inventory Code</label>
                  <div class="col-sm-9">
                    <input class="form-control"type="text" name ="code" value="{{$code}}" placeholder="Code">
                  </div>
                </div>
              </div><!--./col-->

            </div><!--./row-->
          </div><!-- /.box-body -->
          <div class="box-footer">
            <div class="btn-group">
              <button type="submit" class="btn btn-default" name="button" value="print"><i class="fa fa-print"></i> Print</button>
              <button type="submit" class="btn btn-success" name="button" value="search"><i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp; View</button>

            </div>
            <div class="btn-group pull-right" >
              <a href="{{ url('backend/inventory/in') }}" type="reset" class="btn btn-warning"><i class="glyphicon glyphicon-repeat"></i> Reset</a>
              <a href="{{ url('backend/inventory/in/create') }}" class="btn btn-primary "><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add New</a>
            </div>
          </div>
        </form>
      </div><!-- /.box -->

      <div class="x_content">

        <table id="datatable" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>Code</th>
              <th>Date</th>
              <th>Notes</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
            @foreach($inventory  as $data)
              <tr>
                <td data-label="#">{{$data->inv_in_id}}</td>
                <td data-label="Code">{{$data->inv_in_code}}</td>
                <td data-label="Date">{{$data->inv_in_date}}</td>
                <td data-label="Notes">{{$data->inv_in_notes}}</td>
                <td  data-label="Action">
                  <div  class="btn-group">
                    <form id="{{ $data->inv_in_id }}" action="{{ url('backend/inventory/in/'.$data->inv_in_id)}}" method="get">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="_method" value="DELETE">
                      <a href="{{ url('backend/inventory/in/edit/'.$data->inv_in_id)}}" title="View This Inventory In" data-toggle="tooltip" class="btn btn-sm btn-primary" data-toggle="tooltip"><span class="fa fa-edit" aria-hidden="true"></span></a>
                      <button type="button"  title="Delete This Inventory In" data-toggle="tooltip" class="btn btn-danger btn-sm" data-toggle="tooltip" onclick="checkdelete({{$data->inv_in_id}})"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
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
