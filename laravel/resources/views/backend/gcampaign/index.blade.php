@extends('backend/app')
@section('content')
<title>System | Gallery Campaign {{ $tcam->name }}</title>
<div class="page-title">
  <div class="title_left">
    <h3>Gallery Campaign <small>show all gallery campaign {{ $tcam->name }}</small></h3>
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
        <h2>Master Data <small>Gallery Campaign {{ $tcam->name }}</small></h2>
        <div class="text-right" style="margin-bottom:20px;">
                    <a href="{{ url('backend/gallerycampaign/create/'.$campaignid) }}" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add New</a>
                </div>
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
              <th width="10px">#</th>
              <th>Name</th>
              <th width="5%">Image</th>
              <th width="">Enable</th>
              <th width="">Show</th>
              <th width="">Action</th>
            </tr>
          </thead>

          <tbody>
            @foreach($row as $data)
              <tr>
                <td data-label="#">{{$data->id}}</td>
                <td data-label="name">{{$data->name}}</td>
                <td data-label="Image"><img src="{{asset($data->image)}}"class="img-responsive"></td>
                <td data-label="Enable">@if($data->enable ==1)<span class="label label-primary">Enable</span> @else <span class="label label-warning">Disable</span> @endif</td>
                <td data-label="Show">@if($data->show ==1)<span class="label label-primary">Showed</span> @else <span class="label label-warning">Unshowed</span> @endif</td>
                <td data-label="Action">
                  <div  class="btn-group" data-id="{{ $data->id }}">
                      <a href="{{ url('backend/gallerycampaign/edit/'.$data->id)}}" title="View This Photo" data-toggle="tooltip" class="btn btn-sm btn-primary" data-toggle="tooltip"><span class="fa fa-edit" aria-hidden="true"></span></a>

                      <button title="Delete This Photo" data-toggle="tooltip" class="btn btn-sm btn-danger btnDelete" data-toggle="tooltip"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
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
<script type="text/javascript">
$(document).ready(function(){
    $('.btnDelete').click(function(e){
        e.preventDefault();
        var self = this;
        var _id = $(self).parent().attr('data-id');

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
        },function(isConfirm){
          if (isConfirm) 
          {
            $.ajax({
                url : "{{ url('/backend/gallerycampaign/delete/'.$campaignid) }}",
                method : "POST",
                data : { id : _id,_token : "{{ csrf_token() }}" }
            }).success(function(response){
                if("OK" === response.Result)
                {
                    location.href = "{{ url('/backend/gallerycampaign/show/'.$campaignid) }}";
                }
                else
                {
                    swal("Oooops",'Something went wrong.','error');
                }
            });     
          }
        });
    });
});
</script>

    @endsection
