@extends('backend/app')
@section('content')
<title>Page Management</title>
<div class="page-title">
   <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="title_left">
      <h3>Page Management <small>show all Page</small></h3>
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
<!-- <div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">

      <h2>Data <small>Fix</small></h2>
      <div class="clearfix"></div>

    </div>
    <div class="x_content">
        @if(Session::has('success-create-fix'))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4>	<i class="icon fa fa-check"></i> Alert!</h4>
                {{ Session::get('success-create-fix') }}
            </div>
          @endif
      <table id="datatable" class="table table-striped table-bordered">
        <thead>
          <tr>
              <th>#</th>
              <th>Name</th>
              <th>Action</th>
          </tr>
        </thead>

        <tbody>
          @foreach($pagefix as $key => $fix)
          <tr>
            <td data-label="#">{{ $fix->id }}</td>
            <td data-label="Name">{{ $fix->name }}</td>
            <td data-label="Action">
              <div  class="btn-group">
                  <a href="{{ url('backend/themes-pages/'.$fix->id.'/edit')}}" title="Edit" data-toggle="tooltip" class="btn btn-sm btn-primary" data-toggle="tooltip"><span class="fa fa-edit" aria-hidden="true"></span></a>

              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div> -->

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">

        <h2>Data <small>Costume</small></h2>
        <div class="text-right" style="margin-bottom:20px;">
                    <a href="{{ url('backend/page/create') }}" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add New</a>
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
              <th>Title</th>
              <th>Public</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
            @foreach($page as $key => $pages)
              <tr>
                <td data-label="Id">{{$pages->id }}</td>
                <td data-label="title" width="30%">{{$pages->title}}</td>
                <td data-label="post" width="">@if($pages->enable==1)<span class="label label-primary">Enable</span>  @else <span class="label label-warning">Disable</span> @endif</td>
                <td data-label="Action">
                  <div  class="btn-group">
                    <!-- <form id="{{ $pages->id }}" action="{{ url('backend/page/delete/'.$pages->id)}}" method="get">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="_method" value="DELETE"> -->
                      <a href="{{ url('backend/page/edit/'.$pages->id)}}" title="View This content" data-toggle="tooltip" class="btn btn-sm btn-primary" data-toggle="tooltip"><span class="fa fa-edit" aria-hidden="true"></span></a>
                      <!-- <button type="button"  title="Delete This page" data-toggle="tooltip" class="btn btn-danger btn-sm" data-toggle="tooltip" onclick="checkdelete({{$pages->id}})"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                    </form> -->
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
