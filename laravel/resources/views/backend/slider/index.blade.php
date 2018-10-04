@extends('backend/app')
@section('content')
<title>System | Slider </title>
<div class="page-title">
   <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="title_left">
      <h3>Slider Management <small>show all slider</small></h3>
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
        <h2>Master Data <small>slider</small></h2>
        <div class="text-right" style="margin-bottom:20px;">
                    <a href="{{ url('backend/slider/create') }}" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add New</a>
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
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Image</th>
              <th>Title</th>
              <th>Url</th>
              <th>Public</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="current-file">

            @foreach($slider as $key => $sliders)

              <tr>
                  <input type="hidden" name="main_id" value="{{ $sliders->slider_id }}">
                <td data-label="#" width="5%"><i class="fa fa-arrows"></i></td>
                <td data-label="Image"width="30%">  <img src="{{asset($sliders->image)}}" width="100%"/></td>
                <td data-label="title">{{$sliders->title}}</td>
                <td data-label="url" width="">{{$sliders->url}}</td>
                <td data-label="post" width="">@if($sliders->enable==1)<span class="label label-primary">Enable</span>  @else <span class="label label-warning">Disable</span> @endif</td>
                <td data-label="Action">
                  <div  class="btn-group">
                    <form id="{{ $sliders->slider_id }}" action="{{ url('backend/slider/'.$sliders->slider_id)}}" method="post">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="_method" value="DELETE">
                      <a href="{{ url('backend/slider/'.$sliders->slider_id.'/edit')}}" title="View This slider" data-toggle="tooltip" class="btn btn-sm btn-primary" data-toggle="tooltip"><span class="fa fa-edit" aria-hidden="true"></span></a>
                      <button type="button"  title="Delete This slider" data-toggle="tooltip" class="btn btn-danger btn-sm" data-toggle="tooltip" onclick="checkdelete({{$sliders->slider_id}})"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
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
            'table'  : 'cms_slider_home'
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
