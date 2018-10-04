@extends('backend/app')
@section('content')

  <title>System | Product  </title>
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Form Product</h3>
      </div>
      <div class="title_right">

      </div>
    </div>

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        @if($errors->all())
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                @foreach($errors->all() as $error)
                    <?php echo $error."</br>";?>
                @endforeach
            </div>
          @endif
          @if(Session::has('success-delete'))
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

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
            <h2>Edit Product</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <form action="{{url('backend/product/'.$row->prod_id)}}" method="post" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
              <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
              <input type="hidden" name="_method" value="PUT" >
                <div class="row" style="padding-bottom:50px;">
                  <div class="col-md-6 col-left" >

                    <div class="form-group">
                      <label class="col-sm-3 control-label" style="">Public</label>
                      <div class="col-sm-9" style="">
                          <input type="checkbox" name="prod_enable" <?php if($row->prod_enable==1){echo "checked";}?>> Enable
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label" style="">Order</label>
                      <div class="col-sm-9" style="">
                        <input type="number" class="form-control" name="prod_order" value="{{ $row->prod_order }}">
                        @if ($errors->has('prod_order'))
                        <div style="color:red;">
                          {{ $errors->first('prod_order') }}
                        </div>
                        @endif
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label" style="">Product Code *</label>
                      <div class="col-sm-9" style="">
                        <input type="text" class="form-control" placeholder="Product Code" name="prod_code" value="{{ $row->prod_code }}">
                        @if ($errors->has('prod_code'))
                        <div style="color:red;">
                          {{ $errors->first('prod_code') }}
                        </div>
                        @endif
                      </div>
                    </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label" style="">Product Name</label>
                        <div class="col-sm-9" style="">
                          <input type="text" class="form-control" placeholder="Product Name" id="title" name="prod_title" value="{{$row->prod_title}}">
                          @if ($errors->has('title'))
                          <div style="color:red;">
                            {{ $errors->first('title') }}
                          </div>
                          @endif
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-3 control-label" style="">Product Url</label>
                        <div class="col-sm-9" style="">
                          <input type="text" class="form-control" placeholder="Product Url" id="url" name="prod_url" value="{{$row->prod_url}}" request readonly >
                          @if ($errors->has('url'))
                          <div style="color:red;">
                            {{ $errors->first('url') }}
                          </div>
                          @endif
                        </div>
                      </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label"style="" >Product Category</label>
                    <div class="col-sm-9">
                    <div class="col-sm-12 col-kateg" style="max-height:300px;overflow:auto;border:1px solid #D2D6DE;" id="categoryresult">
                      @foreach($categparent as $parent)
                          <div class="col-sm-12" style="padding-left:0%;">
                            <input type="checkbox" class="" name="prod_category[]" id="{{$parent->kateg_id}}"  <?php if(in_array($parent->kateg_id,$expkateg)){echo "checked";}?> value="{{$parent->kateg_id}}">
                            <label class="control-label">{{$parent->kateg_name}} </label>
                          </div>
                          @foreach($categparent1 as $parent1)
                              @if($parent->kateg_id == $parent1->kateg_parent)
                                <div class="col-sm-12" style="padding-left:5%;">
                                  <input type="checkbox" class="" name="prod_category[]" id="{{$parent1->kateg_id}}" <?php if(in_array($parent1->kateg_id,$expkateg)){echo "checked";}?>  value="{{$parent1->kateg_id}}">
                                  <label class="control-label">{{$parent1->kateg_name}} </label>
                                </div>
                                  @foreach($categparent2 as $parent2)
                                      @if($parent1->kateg_id == $parent2->kateg_parent)
                                      <div class="col-sm-12" style="padding-left:10%;">
                                        <input type="checkbox" class="" name="prod_category[]"="{{$parent2->kateg_id}}" <?php if(in_array($parent2->kateg_id,$expkateg)){echo "checked";}?> value="{{$parent2->kateg_id}}">
                                        <label class="control-label">{{$parent2->kateg_name}} </label>
                                      </div>
                                      @endif
                                  @endforeach
                              @endif

                          @endforeach
                      @endforeach
                    </div>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal" style="margin-top:5px;">
                        <i class="glyphicon glyphicon-plus"></i> Category
                    </button>
                  </div>
                  </div>

                  <!-- <div class="form-group hidden">
                      <label class="col-sm-3 text-left">Variation</label>
                      <div class="col-sm-9" id="price" style="">
                        <input type="radio" onclick="aFunction()" <?php if($row->prod_var_status==1){echo "checked";}?>  name="prod_var_status" id="varyes" value="1" /> Yes
                        <input type="radio" onclick="bFunction()" <?php if($row->prod_var_status==0){echo "checked";}?> name="prod_var_status" id="varno" value="0" /> No
                        </div>
                  </div> -->

                  <div class="form-group" id="groupvarian">
                    <label class="col-sm-12 control-label" style="margin-top:20px;">Manage Variation</label>
                    <div class="col-sm-12">
                      <div class="table-responsive">
                            <table class="table table-bordered" >
                              <tbody>
                              <tr>
                                <!-- <th>Name</th> -->
                                <th>Size</th>
                                <th>Color</th>
                                <th>Color (Hex)</th>
                                <th>Stock</th>
                                <th>Action</th>
                              </tr>
                            </tbody>
                            @if($tmpvarian !==null)
                              <tbody>
                                <?php $a=300;?>
                                @foreach($tmpvarian as $varian)

                                  <tr id="row">

                                     <td>
                                        <input type="hidden" class="form-control" name="varianidedit[]" value="{{$varian->varian_id}}" id="varid<?php echo $a;?>">
                                        <input type="text" class="form-control" name="sizeedit[]" id="varsize<?php echo $a;?>" value="{{$varian->varian_size}}">
                                     </td>
                                     <td><input type="text" class="form-control" id="varcolor<?php echo $a;?>" name="coloredit[]"value="{{$varian->varian_color}}" ></td>
                                     <td><input type="color" class="form-control" name="color_hexedit[]" id="varhex<?php echo $a;?>" style="padding:0px;" value="{{$varian->varian_color_hex}}" ></td>
                                     <td><input type="number" class="form-control" name="stockedit[]" id="varqty<?php echo $a;?>"value="{{$varian->varian_stock}}" min="0"></td>
                                     <td width="5%"><button type="button" onclick="if(confirm('Are you sure?')) location.href='{{ URL::to('backend/product-varian/delete/' . $varian->varian_id)}}'" name="remove" id="<?php echo $a;?>" class="btn btn-sm btn-danger btn_remove">Delete</button></td>
                                   </tr>
                                   <?php $a++;?>
                                 @endforeach
                              </tbody>
                              @endif
                              <tbody id="dynamic_field_varian">
                                <tr>
                                <tr>
                              </tbody>
                            </table>
                    </div>

                    </div>
                    <div class="col-sm-12">
                        <button type="button" name="add" id="addvarian" class="btn btn-success">
                          <i class="fa fa-plus"></i> Variation
                        </button>
                    </div>
                    </div>

            </div>

            <div class="col-md-6">

                <div class="form-group <?php if($row->prod_var_status==1){echo "hidden";}?>">
                  <label for="inputEmail3" class="col-sm-3 text-left" style="">Stock *</label>
                  <div class="col-sm-9" style="">
                    <div class="input-group">
                      <input type="number" class="form-control" placeholder="Weight" name="prod_stock" value="{{ $row->prod_stock }}">
                      @if ($errors->has('prod_stock'))
                      <div style="color:red;">
                        {{ $errors->first('prod_stock') }}
                      </div>
                      @endif
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 text-left" style="">Discount</label>
                  <div class="col-sm-9" style="">
                    <div class="input-group">
                      <input type="number" class="form-control" placeholder="Discount" name="prod_disc" value="{{ $row->prod_disc }}">
                      @if ($errors->has('prod_desc'))
                      <div style="color:red;">
                        {{ $errors->first('prod_desc') }}
                      </div>
                      @endif
                    </div>
                  </div>
                </div>

              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 text-left" style="">Weight</label>
                  <div class="col-sm-9" style="">
                      <div class="input-group">
                          <input type="text" class="form-control" value="{{$row->prod_weight}}" placeholder="Weight" name="prod_weight"><span class="input-group-addon">gram</span>
                      </div>
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-sm-3 text-left">Price</label>
                  <div class="col-sm-9" id="price" style="">
                    <input type="number" class="form-control" name="prod_price"  placeholder="Price" value="{{$row->prod_price}}">

                  </div>
              </div>


              <div class="form-group">
                  <label class="col-sm-3 control-label">Product Image</label>
                    <div class="col-sm-9">
                        <div class="table-responsive">

                          @if($tmpimage !==null)
                              <table class="table table-bordered" >
                                <tr>
                                </tr>
                                <tbody id="dynamic_field">
                                  <?php $a= 200;?>
                                  @foreach($tmpimage as $image)

                                  <tr id="row">
                                    <td>
                                      <input type="hidden"  name="imageidedit[]" id="imgid{{ $image->image_id }}" value="{{$image->image_id}}" class="form-control name_list"/>
                                      <img src="{{asset($image->image_small)}}" id="viewimgpen{{ $image->image_id }}" width="100" />
                                      <input type="hidden" value="{{asset($image->image_small)}}" readonly name="imageedit[]"class="form-control name_list" id="imgpen{{ $image->image_id }}"/>
                                    </td>
                                    <td width="5%">
                                        <a href="{{asset('assets/filemanager/dialog.php?type=1&field_id=imgpen')}}{{ $image->image_id }}" class="btn iframe-btn btn btn-sm btn-primary" title="Open">
                                            <i class="fa fa-camera"></i> Image
                                        </a>
                                    </td>
                                    <td width="5%" style="text-align:center;">
                                        <input type="radio" name="primary_image" value="{{ $image->image_id }}" <?php if($image->image_small == $row->front_image){echo "checked";} ?>/> Primary
                                    </td>
                                    <td width="5%">
                                        <button type="button" name="remove" id="{{ $image->image_id }}" onclick="if(confirm('Are you sure?')) location.href='{{ URL::to('backend/product-image/delete/' . $image->image_id) }}'" class="btn btn-sm btn-danger btn_remove">Delete</button>
                                    </td>
                                  <tr>
                                  <?php $a++;?>
                                  @endforeach
                                </tbody>
                              </table>

                              @endif
                              <table class="table table-bordered" >
                                <tr>

                                </tr>
                                <tbody id="dynamic_field">
                                  <tr>
                                  <tr>
                                </tbody>
                              </table>
                      </div>
                      <div id="addimage">
                        <button type="button" name="add" id="add" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Add</button>
                      </div>
                </div>
              </div>

          </div>

        </div>
        <div class="row">
          <div class="col-md-12 col-left">
            <div class="form-group">
                <label class="control-label">Product Description</label>
                @if ($errors->has('prod_desc'))
                <div style="color:red;">
                    {{ $errors->first('prod_desc') }}
                </div>
                @endif
                <input type="text" class="form-control texteditor" name="prod_desc" value="{{$row->prod_desc}}">
            </div>
          </div>

        </div>
        <div class="row col-left">
          <div class="col-md-12">
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:right;">
                <a href="{{url('backend/product')}}" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-success">Submit</button>
              </div>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
 </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="border-bottom:transparent;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Category</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
              <label class="col-sm-3 control-label">Category Name *</label>
              <div class="col-sm-9">
                  <input type="text" class="form-control" name="kateg_name" value="" id="title2">
              </div>
          </div>
          <br>
          <div class="form-group">
              <label class="col-sm-3 control-label">Category URL *</label>
              <div class="col-sm-9">
                  <input type="text" class="form-control" name="kateg_url" value="" readonly id="url2">
              </div>
          </div>
      </div>
      <div class="clearfix"></div>
      <div class="modal-footer" style="border-top:transparent;">
         <button type="button" class="btn btn-default hidden" data-dismiss="modal" id="modalclose">Close</button>
        <button type="button" class="btn btn-default" onclick="savecategory()">Submit</button>
      </div>
    </div>

  </div>
</div>


<!-- <script>
     $(document).ready(function(){
         var intcode = $('#intcode').val();
         if (intcode == '' )
           {
           }else{
                 getAutoCode();
           }
    });
</script> -->

<script type="text/javascript">
    function savecategory(){
        var kateg_name  = $('[name=kateg_name]').val();
        var kateg_url   = $('[name=kateg_url]').val();
        var datapost = {
            "_token"    : "{{ csrf_token() }}",
            "kateg_name": kateg_name,
            "kateg_url" : kateg_url
        }

        if (kateg_name == '' || kateg_url == '') {
            alert('Please fill all category form');
        }else {
            $.ajax({
                type    : "POST",
                url     : "{{ url('backend/addcategory-inproduct') }}",
                data    : datapost,
                dataType: "json",
                success:function(data){
                    if (data[0] == 1) {
                        alert('Category already exist');
                    } else {
                        alert('Success add category');
                        $("#categoryresult").html(data[1]);
                        $('#modalclose').click();
                    }
                }
            });
        }
    }
</script>

<script>
    function getAutoCode(){
    var intcode =$('#intcode').val();
    var token ="{{csrf_token()}}";
    var dataString='_token='+token+ '&intcode='+intcode;

    $.ajax({
        type:"GET",
        url:"{{url('backend/ajax/generatecode')}}",
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

    $('#stock_view').addClass('hidden');
    var x = document.getElementById('groupvarian');

        x.style.display = 'block';
    var y = document.getElementById('groupstock');
        y.style.display='none';

}
function bFunction() {

    $('#stock_view').removeClass('hidden');
    var x = document.getElementById('groupvarian');

        x.style.display = 'none';
    var y = document.getElementById('groupstock');
        y.style.display='block';

}
</script>

@endsection
