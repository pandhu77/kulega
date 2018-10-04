@extends('backend/app')
@section('content')
<title>System | backend-menu </title>
<div class="page-title col-sm-12">
  <div class="title_left">
    <h3>Bankend Menu Management <small>show all menu</small></h3>
  </div>
</div>
<div class="clearfix"></div>
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">

        <h2>Master Data <small>menu</small></h2>
        <div class="text-right" style="margin-bottom:20px;">
           <a href="{{ url('backend/backend-menu/create') }}" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add New</a>
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
          <div class="over">
              <table id="datatable" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Menu</th>
                    <th>Url</th>
                    <th>Icon</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($menu as $key => $menus)
                  <tr>
                    <td data-label="#" width="5%">{{$menus->menu_id }}</td>
                    <td data-label="Menu" width="">{{$menus->menu}}</td>
                    <td data-label="Url" width=""><?php  echo substr($menus->url,8)?></td>
                    <td data-label="Icon" width=""><?php echo nl2br($menus->icon);?></td>
                    <td data-label="Status" width="">@if($menus->status_menu==1)<span class="label label-primary">Enable</span>  @else <span class="label label-warning">Disable</span> @endif</td>
                    <td>
                      <div class="btn-group">
                        <form id="{{ $menus->menu_id }}" action="{{ url('backend/backend-menu/'.$menus->menu_id)}}" method="post">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="_method" value="DELETE">
                          <a href="{{ url('backend/backend-menu/'.$menus->menu_id.'/edit')}}" title="View This backend menu" data-toggle="tooltip" class="btn btn-sm btn-primary" data-toggle="tooltip"><span class="fa fa-edit" aria-hidden="true"></span></a>
                          <button type="button"  title="Delete This backend-menu" data-toggle="tooltip" class="btn btn-danger btn-sm" data-toggle="tooltip" onclick="checkdelete({{$menus->menu_id}})"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                        </form>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </table>
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
