@extends('backend/app')
@section('content')
<title>System | Product </title>
<div class="page-title">
  <div class="title_left">
    <h3>Themes Setting</h3>
  </div>
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
        <h2>Master Data <small>Themes</small></h2>
        <!-- <div class="text-right" style="margin-bottom:20px;">
            <a href="{{ url('backend/product/create') }}" class="btn btn-default"><span class="fa fa-plus" aria-hidden="true" style="color:#fff;"></span> Add New</a>
        </div> -->
        <div class="clearfix"></div>

      </div>
      <div class="x_content">
        <table id="datatable" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Version</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
            @foreach($setting as $set)
              <tr>
                <td data-label="#">{{ $set->id }}</td>
                <td data-label="Name">{{ $set->name }}</td>
                <td data-label="Version">{{ $set->version }}</td>
                <td data-label="Status">
                    <?php if($set->active == 0){ ?>
                        <span class="label label-danger">Inactive</span>
                    <?php } else { ?>
                        <span class="label label-success">Active</span>
                    <?php } ?>
                </td>
                <td data-label="Action">
                  <div  class="btn-group">
                    <form id="{{ $set->id }}" action="{{ url('backend/themes-setting/uninstall/'.$set->id) }}" method="post">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <a href="{{ url('backend/themes-setting/active/'.$set->id) }}" title="Active / Deactive" data-toggle="tooltip" class="btn btn-sm btn-primary" data-toggle="tooltip"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></a>
                      <button type="button"  title="Uninstall" data-toggle="tooltip" class="btn btn-danger btn-sm" data-toggle="tooltip" onclick="checkdelete({{ $set->id }})"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
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
