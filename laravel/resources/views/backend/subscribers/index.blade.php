@extends('backend/app')
@section('content')
<title>System | Subscribers </title>
<div class="page-title">
   <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="title_left">
      <h3>Subscribers Management <small>show all slider</small></h3>
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
        <h2>Master Data <small>Subscribers</small></h2>
        <div class="text-right" style="margin-bottom:20px;">
                    <!-- <a href="{{ url('backend/banner/create') }}" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add New</a> -->
        </div>
        <div class="clearfix"></div>

      </div>
      <div class="x_slider">
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
        <table class="table table-bordered" id="datatable">
          <thead>
            <tr>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>

            @foreach($data as $key => $dat)
                <td data-label="First Name">{{ $dat->first_name }}</td>
                <td data-label="Last Name">{{ $dat->last_name }}</td>
                <td data-label="Email">{{ $dat->email }}</td>
                <td data-label="Action">
                  <!-- <div  class="btn-group">
                    <form id="{{ $dat->id }}" action="{{ url('backend/contact/'.$dat->id)}}" method="post">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="_method" value="DELETE">
                      <a href="{{ url('backend/contact/'.$dat->id.'/edit')}}" title="Reply" data-toggle="tooltip" class="btn btn-sm btn-primary" data-toggle="tooltip"><span class="fa fa-reply" aria-hidden="true"></span></a>
                      <button type="button"  title="Delete" data-toggle="tooltip" class="btn btn-danger btn-sm" data-toggle="tooltip" onclick="checkdelete({{ $dat->id }})"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                    </form>
                  </div> -->
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
