@extends('backend/app')
@section('content')
<title>System | Canpaign Buyyer</title>
<div class="page-title">
  <div class="title_left">
    <h3>Campaign Buyyer <small>show all Campaign Buyyer</small></h3>
  </div>
</div>
<div class="clearfix"></div>
  <div class="col-md-12 col-sm-12 col-xs-12">

    <div class="x_panel">
      <div class="x_title">
        <h2>Master Data <small>Campaign Buyyer</small></h2>
        <div class="text-right" style="margin-bottom:20px;">
            <a href="{{ url('backend/campaignbuy/create/') }}" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add New</a>
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
              <th width="">Status</th>
              <th width="">Target</th>
              <th width="">File PDF</th>
              <th width="">Action</th>
            </tr>
          </thead>

          <tbody>
            @foreach($row as $data)
              <tr>
                <td data-label="#">{{$data->id}}</td>
                <td data-label="name">{{$data->name}}</td>
                <td data-label="Enable">@if($data->status==1)<span class="label label-primary">Confirmed</span>@elseif($data->status==2)<span class="label label-danger">Rejected</span>@else<span class="label label-warning">Review</span>@endif</td>
                <td data-label="parent">Target</td>
                <td data-label="Image">@if(!empty($data->pdf))<a href="{{ url('public/docs/'.$data->pdf) }}" target="_blank">Download File</a>@else Sorry, No File @endif</td>
                <td data-label="Action">
                  <div  class="btn-group" data-id="{{ $data->id }}">
                      <a href="{{ url('backend/campaignbuy/edit/'.$data->id)}}" title="Update This Campaign Buyyer" data-toggle="tooltip" class="btn btn-sm btn-primary" data-toggle="tooltip"><span class="fa fa-edit" aria-hidden="true"></span></a>

                      <a href="{{ url('backend/gallerycampaignbuy/show/'.$data->id.'/')}}" title="View This Gallery Campaign Buyyer" data-toggle="tooltip" class="btn btn-sm btn-info" data-toggle="tooltip"><span class="fa fa-camera-retro" aria-hidden="true"></span></a>

                      <button title="Update Status Confirmed" data-toggle="tooltip" class="btn btn-sm btn-success btnConfirm" data-toggle="tooltip"><span class="fa fa-check-square-o" aria-hidden="true"></span></button>

                      <button title="Update Status Rejected" data-toggle="tooltip" class="btn btn-sm btn-dark btnCanceled" data-toggle="tooltip"><span class="fa fa-close" aria-hidden="true"></span></button>

                      <button title="Delete This Campaign Buyyer" data-toggle="tooltip" class="btn btn-sm btn-danger btnDelete" data-toggle="tooltip"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
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
    $('.btnConfirm').click(function(e){
        e.preventDefault();
        var self = this;
        var _id = $(self).parent().attr('data-id');

        swal({
          title: "Are you sure for update status to confirmed?",
          text: "",
          type: "warning",
          showCancelButton: true,
          confirmButtonText: "Yes",
          cancelButtonText: "Cancel",
          closeOnConfirm: false,
          closeOnCancel: true
        },function(isConfirm){
          if (isConfirm) 
          {
            $.ajax({
                url : "{{ url('/backend/campaignbuy/confirmed/') }}",
                method : "POST",
                data : { id : _id,_token : "{{ csrf_token() }}" }
            }).success(function(response){
                if("OK" === response.Result)
                {
                    location.href = "{{ url('/backend/campaignbuy/show/') }}";
                }
                else
                {
                    swal("Oooops",'Something went wrong.','error');
                }
            });     
          }
        });
    });

    $('.btnCanceled').click(function(e){
        e.preventDefault();
        var self = this;
        var _id = $(self).parent().attr('data-id');

        swal({
          title: "Are you sure for update status to rejected?",
          text: "",
          type: "warning",
          showCancelButton: true,
          confirmButtonText: "Yes",
          cancelButtonText: "Cancel",
          closeOnConfirm: false,
          closeOnCancel: true
        },function(isConfirm){
          if (isConfirm) 
          {
            $.ajax({
                url : "{{ url('/backend/campaignbuy/rejected/') }}",
                method : "POST",
                data : { id : _id,_token : "{{ csrf_token() }}" }
            }).success(function(response){
                if("OK" === response.Result)
                {
                    location.href = "{{ url('/backend/campaignbuy/show/') }}";
                }
                else
                {
                    swal("Oooops",'Something went wrong.','error');
                }
            });     
          }
        });
    });

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
          closeOnCancel: true
        },function(isConfirm){
          if (isConfirm) 
          {
            $.ajax({
                url : "{{ url('/backend/campaignbuy/delete/') }}",
                method : "POST",
                data : { id : _id,_token : "{{ csrf_token() }}" }
            }).success(function(response){
                if("OK" === response.Result)
                {
                    location.href = "{{ url('/backend/campaignbuy/show/') }}";
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
