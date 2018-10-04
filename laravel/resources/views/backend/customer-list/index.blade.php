@extends('backend/app')
@section('content')
<title>System | Member</title>
<div class="page-title">
  <div class="title_left">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h3>Customer List  <small>show all customer</small></h3>
  </div>
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
        <h2>Master Data<small> Customer List</small></h2>
        <!-- <div class="text-right" style="margin-bottom:20px;">
                    <a href="{{ url('backend/customer-list/create') }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add New</a>
                </div> -->
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
        <table id="datatable" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Customer ID</th>
              <th>Customer Date</th>
              <th>Customer Name</th>
              <th>Customer Email</th>
              <th>Customer Phone</th>
              <th width="">Status</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
            @foreach($member as $data)
              <tr>
                <td data-label="ID">#{{$data->member_id}}</td>
                <td data-label="Date">{{$data->member_created_at}}</td>
                <td data-label="Name">{{$data->member_fullname}}</td>
                <td data-label="Email">{{$data->member_email}}</td>
                <td data-label="Phone">{{$data->member_phone}}</td>
                <td data-label="Enable">@if($data->member_status ==1)<span class="label label-primary">Enable</span> @else <span class="label label-warning">Disable</span> @endif</td>
                <td data-label="Action">
                  <div  class="btn-group">
                    <form id="{{ $data->member_id }}" action="{{ url('backend/customer-list/'.$data->member_id)}}" method="get">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="_method" value="DELETE">
                      <a href="{{ url('backend/customer-list/edit/'.$data->member_id)}}" title="View This Member" data-toggle="tooltip" class="btn btn-sm btn-primary" data-toggle="tooltip"><span class="fa fa-edit" aria-hidden="true"></span></a>
                      <button type="button"  title="Delete This Member" data-toggle="tooltip" class="btn btn-danger btn-sm" data-toggle="tooltip" onclick="checkdelete({{$data->member_id}})"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
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
