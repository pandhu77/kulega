@extends('backend/app')
@section('content')
<title>System | Menu</title>
<div class="page-title col-sm-12">
  <div class="title_left">
    <h3>Frontend Menu Management <small>show all menu</small></h3>
  </div>
</div>
<div class="clearfix"></div>
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">

        <h2>Master Data <small>menu</small></h2>
        <div class="text-right" style="margin-bottom:20px;">
           <a href="{{ url('backend/frontend-menu/create') }}" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add New</a>
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
              <!-- <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Menu</th>
                    <th>Type</th>
                    <th>URL</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="current-file">
                  @foreach($menumain as $key => $main)
                    @if($main->menu == 'Shop')
                        @if($websetting->type == 'ecommerce')
                        <tr>
                            <input type="hidden" name="main_id" value="{{ $main->menu_id }}">
                          <td data-label="#" width="5%"><i class="fa fa-arrows"></i></td>
                          <td data-label="Menu" width="">{{ $main->menu }}</td>
                          <td data-label="Type" width="">{{ $main->type }}</td>
                          <td data-label="URL" width="">{{ $main->url }}</td>
                          <td data-label="Status" width="">
                              @if($main->enable == 1)
                                  <span class="label label-primary">Enable</span>
                              @else
                                  <span class="label label-warning">Disable</span>
                              @endif
                          </td>
                          <td>
                            <div class="btn-group">
                                <a href="{{ url('backend/frontend-menu/'.$main->menu_id.'/edit')}}" title="View This backend menu" data-toggle="tooltip" class="btn btn-sm btn-primary" data-toggle="tooltip"><span class="fa fa-edit" aria-hidden="true"></span></a>
                              @if($main->fix != 1)
                              <form id="{{ $main->menu_id }}" action="{{ url('backend/frontend-menu/'.$main->menu_id)}}" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="DELETE">

                                <button type="button"  title="Delete This frontend-menu" data-toggle="tooltip" class="btn btn-danger btn-sm" data-toggle="tooltip" onclick="checkdelete({{$main->menu_id}})"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                              </form>
                              @endif
                            </div>
                          </td>
                        </tr>
                        @endif
                    @else
                      <tr>
                          <input type="hidden" name="main_id" value="{{ $main->menu_id }}">
                        <td data-label="#" width="5%"><i class="fa fa-arrows"></i></td>
                        <td data-label="Menu" width="">{{ $main->menu }}</td>
                        <td data-label="Type" width="">{{ $main->type }}</td>
                        <td data-label="URL" width="">{{ $main->url }}</td>
                        <td data-label="Status" width="">
                            @if($main->enable == 1)
                                <span class="label label-primary">Enable</span>
                            @else
                                <span class="label label-warning">Disable</span>
                            @endif
                        </td>
                        <td>
                          <div class="btn-group">
                              <a href="{{ url('backend/frontend-menu/'.$main->menu_id.'/edit')}}" title="View This backend menu" data-toggle="tooltip" class="btn btn-sm btn-primary" data-toggle="tooltip"><span class="fa fa-edit" aria-hidden="true"></span></a>
                            @if($main->fix != 1)
                            <form id="{{ $main->menu_id }}" action="{{ url('backend/frontend-menu/'.$main->menu_id)}}" method="post">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <input type="hidden" name="_method" value="DELETE">

                              <button type="button"  title="Delete This frontend-menu" data-toggle="tooltip" class="btn btn-danger btn-sm" data-toggle="tooltip" onclick="checkdelete({{$main->menu_id}})"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                            </form>
                            @endif
                          </div>
                        </td>
                      </tr>
                    @endif
                  @endforeach
                </table> -->

                <br>

                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Menu</th>
                      <th>Type</th>
                      <th>URL</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="current-file2">
                    @foreach($menufoot as $key => $foot)
                    <tr>
                        <input type="hidden" name="foot_id" value="{{ $foot->menu_id }}">
                      <td data-label="#" width="5%"><i class="fa fa-arrows"></i></td>
                      <td data-label="Menu" width="">{{ $foot->menu }}</td>
                      <td data-label="Type" width="">{{ $foot->type }}</td>
                      <td data-label="URL" width="">{{ $foot->url }}</td>
                      <td data-label="Status" width="">
                          @if($foot->enable == 1)
                              <span class="label label-primary">Enable</span>
                          @else
                              <span class="label label-warning">Disable</span>
                          @endif
                      </td>
                      <td>
                        <div class="btn-group">
                          <form id="{{ $foot->menu_id }}" action="{{ url('backend/frontend-menu/'.$foot->menu_id)}}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                            <a href="{{ url('backend/frontend-menu/'.$foot->menu_id.'/edit')}}" title="View This backend menu" data-toggle="tooltip" class="btn btn-sm btn-primary" data-toggle="tooltip"><span class="fa fa-edit" aria-hidden="true"></span></a>
                            <button type="button"  title="Delete This frontend-menu" data-toggle="tooltip" class="btn btn-danger btn-sm" data-toggle="tooltip" onclick="checkdelete({{$foot->menu_id}})"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
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

  <script type="text/javascript">
    $("#current-file").sortable({
        update: function() {
           updtrow();
        }
    });

    function updtrow(){
        var array = $("[name=main_id]").map(function() {return this.value;}).get().join();
        var datapost = {
            '_token' : '{{ csrf_token() }}',
            'arrayid': array,
            'table'  : 'cms_menu'
        }

        $.ajax({
            type : "POST",
            url : "{{ url('backend/menu/updaterow') }}",
            data:datapost,
            success:function(data){
                if (data == 1) {
                    location.reload();
                }
            }
        })
    }
  </script>

  <script type="text/javascript">
    $("#current-file2").sortable({
        update: function() {
           updtrow2();
        }
    });

    function updtrow2(){
        var array = $("[name=foot_id]").map(function() {return this.value;}).get().join();
        var datapost = {
            '_token' : '{{ csrf_token() }}',
            'arrayid': array,
            'table'  : 'cms_menu'
        }

        $.ajax({
            type : "POST",
            url : "{{ url('backend/menu/updaterow') }}",
            data:datapost,
            success:function(data){
                if (data == 1) {
                    location.reload();
                }
            }
        })
    }
  </script>

    @endsection
