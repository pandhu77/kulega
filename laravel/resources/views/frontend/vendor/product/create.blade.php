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
.control-label{
  text-align: left!important;
}

.btn-file {
  position: relative;
  overflow: hidden;
}
.btn-file input[type=file] {
  position: absolute;
  top: 0;
  right: 0;
  min-width: 100%;
  min-height: 100%;
  font-size: 100px;
  text-align: right;
  filter: alpha(opacity=0);
  opacity: 0;
  outline: none;
  background: white;
  cursor: inherit;
  display: block;
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
    <div class="panel-heading panel-heading-custom2"><span style="color:#333">Create</span>  Product
		</div>
    <div class="panel-body">
      <form action="{{action('VendorProductsController@store')}}" method="post" enctype="multipart/form-data" id="eventForm" data-parsley-validate class="form-horizontal form-label-left">
        <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
        <div class="row" style="padding-bottom:50px;">
          <div class="col-md-6 col-left" >
            <!-- <div class="form-group">
              <label for="inputEmail3" class="col-sm-12 text-left">Date Range</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="txtFrom"   placeholder="From" name="fromDate" value="{{ old('fromDate') }}">
              </div>
              <label for="inputEmail3" class="col-sm-1 text-center" style="height: 34px; padding: 0px; ">-</label>
              <div class="col-sm-6">
                <input type="text" class="form-control"  id="txtTo"   placeholder="Until" name="untilDate" value="{{ old('untilDate') }}">
              </div>
            </div> -->

            <div class="form-group">
              <label class="col-sm-12 control-label" style="">Product Code</label>
              <div class="col-sm-12" style="">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="CODE" id="intcode" onchange="getAutoCode()" name="first_code" required value="{{ old('first_code') }}">
                  <span class="input-group-addon" style="background:#fff;border-left: 0px;">
                    -
                  </span>
                  <span class="input-group-addon" style="padding:0px 6px;">
                    <input type="text"  name="codeotm" id="intcodeotm" style="height:32px;border: #fff;background:#eee;" value="{{ old('codeotm') }}" required readonly>
                  </span>
                 </div>
                 <input type="hidden" class="form-control"   name="prod_code" id="fullcode" value="{{ old('prod_code') }}" required>
                  @if ($errors->has('prod_code'))
                  <div style="color:red;">
                    {{ $errors->first('prod_code') }}
                  </div>
                  @endif
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-12 control-label" style="">Product Name</label>
              <div class="col-sm-12" style="">
                <input type="text" class="form-control" placeholder="Product Name" name="prod_name" value="{{ old('prod_name') }}">
                @if ($errors->has('prod_name'))
                <div style="color:red;">
                  {{ $errors->first('prod_name') }}
                </div>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-12 control-label" style="">Product Title</label>
              <div class="col-sm-12" style="">
                <input type="text" class="form-control" placeholder="Product Title" id="title" name="prod_title" value="{{ old('prod_title') }}" required>
                @if ($errors->has('prod_title'))
                <div style="color:red;">
                  {{ $errors->first('prod_title') }}
                </div>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-12 control-label" style="">Product Url</label>
              <div class="col-sm-12" style="">
                <input type="text" class="form-control" placeholder="Product Url" id="url" name="prod_url" value="{{ old('prod_url') }}" request readonly >
                @if ($errors->has('prod_url'))
                <div style="color:red;">
                  {{ $errors->first('prod_url') }}
                </div>
                @endif
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-12 control-label" style="">Brand</label>
              <div class="col-sm-12" style="">
                <select class="js-example-data-array" name="prod_brand_id" class="form-control">
                  <option value="" selected disabled>Select One</option>
                  @foreach($brand as $brands)
                  <option value="{{$brands->brand_id}}" data-tokens="">{{$brands->brand_id}} - {{$brands->brand_name}}</option>
                  @endforeach
                </select>
                @if ($errors->has('prod_brand_id'))
                <div style="color:red;">
                  {{ $errors->first('prod_brand_id') }}
                </div>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-12 control-label"style="" >Product Category</label>
              <div class="col-sm-12">
                <div class="col-sm-12 col-kateg" style="max-height:400px;overflow:auto;border:1px solid #D2D6DE;">
                  @foreach($categparent as $parent)
                  <div class="col-sm-12" style="padding-left:0%;">
                    <input type="checkbox" class="" name="prod_category[]" id="{{$parent->kateg_id}}" value="{{$parent->kateg_id}}">
                    <label class="control-label">{{$parent->kateg_name}} </label>
                  </div>
                  @foreach($categparent1 as $parent1)
                  @if($parent->kateg_id == $parent1->kateg_parent)
                  <div class="col-sm-12" style="padding-left:5%;">
                    <input type="checkbox" class="" name="prod_category[]" id="{{$parent1->kateg_id}}" value="{{$parent1->kateg_id}}">
                    <label class="control-label">{{$parent1->kateg_name}} </label>
                  </div>
                  @foreach($categparent2 as $parent2)
                  @if($parent1->kateg_id == $parent2->kateg_parent)
                  <div class="col-sm-12" style="padding-left:10%;">
                    <input type="checkbox" class="" name="prod_category[]"="{{$parent1->kateg_id}}" value="{{$parent2->kateg_id}}">
                    <label class="control-label">{{$parent2->kateg_name}} </label>
                  </div>
                  @endif
                  @endforeach
                  @endif

                  @endforeach
                  @endforeach
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-12 text-left" style="">Weight</label>
              <div class="col-sm-12" style="">
                <div class="input-group">
                  <input type="number" class="form-control" placeholder="Weight" name="prod_weight" value="{{ old('prod_weight') }}"  ><span class="input-group-addon">gram</span>
                  @if ($errors->has('prod_weight'))
                  <div style="color:red;">
                    {{ $errors->first('prod_weight') }}
                  </div>
                  @endif
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-12 text-left" style="">Dimension</label>
              <div class="col-sm-12" style="">
                <table id="dimensionTable" class="table table-hover table-bordered" style="margin-bottom: 0;">
                  <tbody>
                    <tr style="background-color: #eee">
                      <th>Length</th>
                      <th>Width</th>
                      <th>Height</th>
                    </tr>
                  </tbody>
                  <tbody id="dimensionVal">
                    <tr>
                      <td>
                        <input id="lengthVal" type="number" class="form-control" placeholder="Length" value="{{ old('prod_lenght') }}"  name="prod_lenght">
                        @if ($errors->has('prod_lenght'))
                        <div style="color:red;">
                          {{ $errors->first('prod_lenght') }}
                        </div>
                        @endif
                      </td>
                      <td>
                        <input id="widthVal" type="number" class="form-control" placeholder="Width"  value="{{ old('prod_width') }}" name="prod_width">
                        @if ($errors->has('prod_width'))
                        <div style="color:red;">
                          {{ $errors->first('prod_width') }}
                        </div>
                        @endif
                      </td>
                      <td>
                        <input id="heightVal" type="number" class="form-control" placeholder="Height" value="{{ old('prod_height') }}" name="prod_height">
                        @if ($errors->has('prod_height'))
                        <div style="color:red;">
                          {{ $errors->first('prod_height') }}
                        </div>
                        @endif
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-12 text-left" style="">Volume</label>
              <div class="col-sm-12" style="">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="volume" readonly  id="volumeVal" name="prod_volume" value="{{ old('prod_volume') }}">
                  @if ($errors->has('prod_volume'))
                  <div style="color:red;">
                    {{ $errors->first('prod_volume') }}
                  </div>
                  @endif
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-12 text-left">Price</label>
              <div class="col-sm-12" id="price" style="">
                <input type="number" class="form-control" name="prod_price" required placeholder="Price" value="{{ old('prod_price') }}">
                @if ($errors->has('prod_price'))
                <div style="color:red;">
                  {{ $errors->first('prod_price') }}
                </div>
                @endif
              </div>
            </div>

            <div class="form-group">
              <label for="middle-name" class="control-label col-md-12 col-sm-12 col-xs-12">Front Image</label>
              <div class="col-md-12 col-sm-12 col-xs-12">
                  <img class="img-responsive" id="viewimg" src="" alt="" style="margin-bottom:10px;">
                  <input type="file" class="filestyle pull-right btn-file " name="front_image" id="img" data-buttonName="btn-default btn-gray">
                  <!-- <input type="hidden" class="form-control" placeholder="" name="front_image"> -->
              </div>
            </div>
          </div>
         </div>

          <div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label class="col-sm-12 control-label">Product Image</label>
					<div class="col-sm-12">
						<div class="table-responsive">
							<table class="table table-bordered" >
								<tr></tr>
								<tbody id="dynamic_field">
									<tr><tr>
									</tbody>
								</table>
							</div>
							<div id="addimage">
								<button type="button" name="add" id="add" class="btn btn-default btn-gray"><i class="glyphicon glyphicon-plus"></i> Add</button>
							</div>
						</div>
					</div>
			</div>

			<div class="col-sm-12">
				<div class="form-group">
					<label class="col-sm-12 text-left">Variation</label>
					<div class="col-sm-12" id="price" style="">
						<input type="radio" onclick="aFunction()"   name="prod_var_status" id="varyes" value="1" required /> Yes
						<input type="radio" onclick="bFunction()"  name="prod_var_status" id="varno" value="0" required /> No
					</div>
				</div>

				<div class="form-group" id="groupvarian" style="display:none">
					<label class="col-sm-12 control-label" style="margin-top:20px;">Manage Variation</label>
					<div class="col-sm-12">
						<div class="table-responsive">
							<table class="table table-bordered" >
								<tbody>
									<tr>
										<th>Size</th>
										<th>Color</th>
										<th>Color (Hex)</th>
										<th>Action</th>
									</tr>
								</tbody>
								<tbody id="dynamic_field_varian">
									<tr> </tr>
								</tbody>
							</table>
						 </div>
						</div>

						<div class="col-sm-12">
							<button type="button" name="add" id="addvarian" class="btn btn-default btn-gray">
								<i class="fa fa-plus"></i> Variation
							</button>
						</div>
				</div>
			</div>

            <div class="col-sm-12">
              <div class="form-group">
                <div class="col-sm-12">
                  <label class="control-label">Product Description</label>
                  @if ($errors->has('prod_desc'))
                  <div style="color:red;">
                    {{ $errors->first('prod_desc') }}
                  </div>
                  @endif
                  <!-- <input type="text" class="form-control texteditor" name="prod_desc" value="{{ old('prod_desc') }}" > -->
				   <textarea  class="form-control mytextarea" name="prod_desc">{{ old('prod_desc') }}</textarea>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <div class="col-sm-12">
                    <label class="control-label">Product Details</label>
                    @if ($errors->has('prod_detail'))
                    <div style="color:red;">
                      {{ $errors->first('prod_detail') }}
                    </div>
                    @endif
                    <!-- <input type="text" class="form-control texteditordetail" name="prod_detail" value="{{ old('prod_detail') }}"> -->
					<textarea  class="form-control mytextarea" name="prod_detail">{{ old('prod_detail') }}</textarea>
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-12">
                  <label class="control-label">Product Spek</label>
                  @if ($errors->has('prod_spek'))
                  <div style="color:red;">
                    {{ $errors->first('prod_spek') }}
                  </div>
                  @endif
                  <!-- <input type="text" class="form-control texteditorspek" name="prod_spek" value="{{ old('prod_spek') }}"> -->
				  	<textarea  class="form-control mytextarea" name="prod_spek">{{ old('prod_spek') }}</textarea>
                </div>
              </div>
            </div>
          </div>

          <div class="row col-left">
            <div class="col-md-12">
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:right;">
                  <div class="btn-group">
                        <a href="{{url('vendor/product')}}" class="btn  btn-default" type="button"  data-placement="top" data-toggle="tooltip" data-original-title="Back"><i class="fa fa-share"></i> Back</a>
                        <button class="btn pull-right" style="background-color: #B2203D; color: white;" type="submit" data-original-title=""><i class="fa fa-save"></i> Save</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
    </div>
  </div>
</div>


<script >
	tinymce.init({
		selector: '.mytextarea'
	});
</script>
<script>
     $(document).ready(function(){
         var intcode = $('#intcode').val();
         if (intcode == '' )
           {
           }else{
                 getAutoCode();
           }
    });
</script>
<script>
    function getAutoCode(){
    var intcode =$('#intcode').val();
    var token ="{{csrf_token()}}";
    var dataString='_token='+token+ '&intcode='+intcode;

    $.ajax({
        type:"GET",
        url:"{{url('vendor/ajax/generatecode')}}",
        data:dataString,
        success: function(data){
            $('#intcodeotm').val(data);
            $('#fullcode').val(intcode +'-'+ data);
        }
    });
    }
</script>

<script type="text/javascript">

function aFunction() {

    var x = document.getElementById('groupvarian');

        x.style.display = 'block';
    var y = document.getElementById('groupstock');
        y.style.display='none';

}
function bFunction() {

    var x = document.getElementById('groupvarian');

        x.style.display = 'none';
    var y = document.getElementById('groupstock');
        y.style.display='block';

}
</script>
<script>
    //  $(document).ready(function(){
          var i=0;
          $('#addvarian').click(function(){
              j=++i;
              //<td width="40%"><input type="text" class="form-control" name="varianname[]" id="varname'+ j +'"></td>
              // <td><input type="hidden" class="form-control" name="qty[]" id="varqty'+ j +'"></td>
               $('#dynamic_field_varian').append('<tr id="row'+i+'"> <td><input type="text" class="form-control" name="size[]" id="varsize'+ j +'"></td><td><input type="text" class="form-control" id="varcolor'+ j +'" name="color[]" ></td><td><input type="color" class="form-control" name="color_hex[]" id="varhex'+ j +'" style="padding:0px;" ></td><td width="5%"><button type="button" name="remove" id="'+i+'" class="btn btn-sm btn-danger btn_remove">Remove</button></td></tr>');

          });
          $(document).on('click', '.btn_remove', function(){
               var button_id = $(this).attr("id");
               $('#row'+button_id+'').remove();
          });

    //  });
</script>
<script>
    function readURL2(input) {
     if (input.files && input.files[0]) {
         var reader = new FileReader();

         reader.onload = function (e) {
             $("#view"+input.id).attr('src', e.target.result);
         }

         reader.readAsDataURL(input.files[0]);
     }
    }

    $("#img").change(function(){
     readURL(this);
    });

</script>
<script>
   $(document).ready(function(){
        var i=0;
        $('#add').click(function(){
          j=++i;
             $('#dynamic_field').append('<tr id="row'+i+'">  <td><img src="" id="viewimgpen'+ j +'" width="100" height="80"/></td><td width="70%"><input type="file" readonly name="image[]"class="form-control name_list" id="imgpen'+ j +'" required/></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-sm btn-danger btn_remove">Remove</button></td></tr>');
             $("#imgpen"+j).change(function(){
                  readURL2(this);
             });
        });
        $(document).on('click', '.btn_remove', function(){
             var button_id = $(this).attr("id");
             $('#row'+button_id+'').remove();
        });



   });
 </script>
<script>
    $("#img").change(function(){
       readURL(this);
    });

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
