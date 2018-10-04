@extends('backend/app')
@section('content')
<title>System | discount </title>
<div class="page-title">
  <div class="title_left">
    <h3>Discount Management <small>show all discount</small></h3>
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

        <h2>Master Data <small>discount</small></h2>
        <div class="text-right" style="margin-bottom:20px;">
                    <a href="{{ url('backend/discount/create') }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add New</a>
                </div>
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
        <table id="datatable" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th width="">Code</th>
              <th width="">Type</th>
              <th width="">Name</th>
              <th width="">Discount Request</th>
              <th width="">Request Min</th>
              <th width="">Request Max</th>
              <th width="">Discount Reward</th>
              <th width="">Reward Value</th>
              <th width="">Start Date</th>
              <th width="">End Date</th>
              <th width="">Enable</th>
              <th width="">Action</th>
            </tr>
          </thead>

          <tbody>
            @foreach($discount as $data)
              <tr>
                <td data-label="#">{{$data->disc_id}}</td>
                <td data-label="Code">{{$data->disc_code}}</td>
                <td data-label="Type">{{$data->disc_type}}</td>
                <td data-label="Name">{{$data->disc_name}}</td>
                <td data-label="Request">{{$data->disc_req}}</td>
                <td data-label="Min"><span class="price_format">{{$data->disc_min}}</span></td>
                <td data-label="Max"><span class="price_format">{{$data->disc_max}}</span></td>
                <td data-label="Reward">{{$data->disc_reward}}</td>
                <td data-label="Value">@if($data->disc_reward=='percent'){{$data->disc_reward_value}}% @else <span class="price_format">{{$data->disc_reward_value}}</span> @endif</td>
                <td data-label="Start">{{$data->disc_start_date}}</td>
                <td data-label="End">{{$data->disc_end_date}}</td>

                <td data-label="Enable">@if($data->disc_enable ==1)<span class="label label-primary">Enable</span> @else <span class="label label-warning">Disable</span> @endif</td>
                <td data-label="Action">
                  <div  class="btn-group">
                    <form id="{{ $data->disc_id }}" action="{{ url('backend/discount/'.$data->disc_id)}}" method="post">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="_method" value="DELETE">
                      <a href="{{ url('backend/discount/'.$data->disc_id.'/edit')}}" title="View This discount" data-toggle="tooltip" class="btn btn-sm btn-primary" data-toggle="tooltip"><span class="fa fa-edit" aria-hidden="true"></span></a>
                      <button type="button"  title="Delete This discount" data-toggle="tooltip" class="btn btn-danger btn-sm" data-toggle="tooltip" onclick="checkdelete({{$data->disc_id}})"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
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
