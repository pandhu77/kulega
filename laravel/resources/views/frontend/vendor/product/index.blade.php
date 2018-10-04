@extends('frontend/vendor/menu')
@section('isi')
<style>
	.panel-default > .panel-heading-custom2{
  background-image: none;
  background-color: #f4f5f4;
  color: #B2203D;
  border-radius: 0px;
  height: 50px;
  padding-top: 12px;
  font-weight: bold;
  font-size: 18px;
}
.btn.btn--tiny {
    padding: 6px;
    border: 1px solid;
    font-size: 10px;
}
.btn.btn--secondary {
    background-color: #fff;
    color: #000;
    border-color: #000;
}

.rfloat {
    float: right;
}
@media (min-width:768px){
	.group-imgprofile{
		width: 250px;
	}
	.group-username{
		width: 300px;
	}
	.group-email{
		width: 500px;
	}
	.group-name{
		width: 500px;
	}
	.group-phone{
		width: 400px;
	}
}
.select2-container--default .select2-selection--single {
    height: 40px!important;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    padding-top: 5px!important;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    padding-top: 5px!important;
}
.btn-gray{
	background: #333;
	border-color: #333;
	border-radius: 2px;
	color: #fff;
}
.btn-gray:hover {
	background-color: #fff;
	color: #333;
	border:1px solid #333;
}
.btn-gray:active, .pull-right.active, .open > .dropdown-toggle.pull-right {
    color: #fff;
    background-color: #B2203D;
    border-color: #204d74;
}

</style>
<title>{{web_name()}} | Product</title>
<div class="col-md-9  box-right">
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
		 @if($errors->all())
			<div class="alert alert-danger col-md-12 col-sm-12">
				 <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					@foreach($errors->all() as $error)
							<?php echo $error."</br>";?>
					@endforeach
			</div>
		@endif
	<div class="panel panel-default panel-contact" >
    <div class="panel-heading panel-heading-custom2"><span style="color:#333">Product</span>  Management
		 <a href="{{ url('vendor/product/create') }}" class="btn btn-default pull-right btn-gray"><span class="fa fa-plus" aria-hidden="true" style="color:#fff;"></span> New Product</a>
		</div>
    <div class="panel-body">
			<table id="example" class="table table-striped table-bordered tableresponsive" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>#</th>
					<th>Product Code</th>
					<th width="5%">Image</th>
					<th>Product Name</th>
					<th>Brand</th>
					<th>Price(IDR)</th>
					<th>Public</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($prod as $data)
					<tr>
						<td data-label="#">{{$data->prod_id}}</td>
						<td data-label="Code">{{$data->prod_code}}</td>
						<td data-label="Image"><img src="{{asset($data->front_image)}}"class="img-responsive"></td>
						<td data-label="Name">{{$data->prod_name}}</td>
						<td data-label="Category">{{$data->brand_name}}</td>
						<td data-label="Price">{{$data->prod_price}}</td>
						<td data-label="Enable">@if($data->prod_enable ==1)<span class="label label-primary">Enable</span> @else <span class="label label-warning">Disable</span> @endif</td>
						<td data-label="Action" class="btn-group">
						<form id="{{ $data->prod_id }}" action="{{ url('vendor/product/'.$data->prod_id)}}" method="post">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="_method" value="DELETE">
							<a href="{{ url('vendor/product/'.$data->prod_id.'/edit')}}" title="View This Product" data-toggle="tooltip" class="btn btn-sm btn-default btn-gray" data-toggle="tooltip"><span class="fa fa-edit" aria-hidden="true"></span></a>
							<button type="button"  title="Delete This Product" data-toggle="tooltip" class="btn btn-danger btn-sm" data-toggle="tooltip" onclick="checkdelete({{$data->prod_id}})"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>

						</form>
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
<script>
function readURL(input) {
	 if (input.files && input.files[0]) {
			 var reader = new FileReader();

			 reader.onload = function (e) {
					 $('#viewimg').attr('src', e.target.result);
			 }

			 reader.readAsDataURL(input.files[0]);
	 }
}
</script>


@endsection
