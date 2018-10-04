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
            <h2>Create Product</h2>

            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />

            <form action="{{action('Backend\ProductsController@store')}}" method="post" enctype="multipart/form-data" id="eventForm" data-parsley-validate class="form-horizontal form-label-left">
              <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
                <div class="row" style="padding-bottom:50px;">
                  <div class="col-md-6 col-left" >
                    <div class="form-group">
                      <label class="col-sm-3 control-label" style="">Public</label>
                      <div class="col-sm-9" style="">
                        <input type="checkbox" name="prod_enable" checked> Enable
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label" style="">Order</label>
                      <div class="col-sm-9" style="">
                        <input type="number" class="form-control" name="prod_order" value="99">
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
                        <input type="text" class="form-control" placeholder="Product Code" name="prod_code" value="{{ old('prod_code') }}">
                        @if ($errors->has('prod_code'))
                        <div style="color:red;">
                          {{ $errors->first('prod_code') }}
                        </div>
                        @endif
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label" style="">Product Name *</label>
                      <div class="col-sm-9" style="">
                        <input type="text" class="form-control" placeholder="Product Name" id="title" name="prod_title" value="{{ old('prod_title') }}">
                        @if ($errors->has('prod_title'))
                        <div style="color:red;">
                          {{ $errors->first('prod_title') }}
                        </div>
                        @endif
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label" style="">Product Url *</label>
                      <div class="col-sm-9" style="">
                        <input type="text" class="form-control" placeholder="Product Url" id="url" name="prod_url" value="{{ old('prod_url') }}" request readonly >
                        @if ($errors->has('prod_url'))
                        <div style="color:red;">
                          {{ $errors->first('prod_url') }}
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
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal" style="margin-top:5px;">
                            <i class="glyphicon glyphicon-plus"></i> Category
                        </button>
                      </div>
                    </div>

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
                                <!-- <th>Qty</th> -->
                                <th>Action</th>
                              </tr>
                            </tbody>
                            <tbody id="dynamic_field_varian">
                              <tr>
                                <td>
                                  <input type="text" class="form-control" name="size[]">
                                </td>
                                <td>
                                  <input type="text" class="form-control" name="color[]">
                                </td>
                                <td>
                                  <input type="color" class="form-control" name="color_hex[]" style="padding:0px;">
                                </td>
                                <td>
                                  <input type="number" class="form-control" name="stock[]" min="0" value="0">
                                </td>
                                <td width="5%">
                                  <!-- <button type="button" name="remove" id="0" class="btn btn-sm btn-danger btn_remove">Delete</button> -->
                                </td>
                              </tr>
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

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 text-left" style="">Discount</label>
                        <div class="col-sm-9" style="">
                          <div class="input-group">
                            <input type="number" class="form-control" placeholder="Discount" name="prod_disc" value="0">
                            @if ($errors->has('prod_desc'))
                            <div style="color:red;">
                              {{ $errors->first('prod_desc') }}
                            </div>
                            @endif
                          </div>
                        </div>
                      </div>

                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 text-left" style="">Weight *</label>
                      <div class="col-sm-9" style="">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Weight" name="prod_weight" value="1"><span class="input-group-addon">gram</span>
                          @if ($errors->has('prod_weight'))
                          <div style="color:red;">
                            {{ $errors->first('prod_weight') }}
                          </div>
                          @endif
                        </div>
                      </div>
                    </div>


                    <div class="form-group">
                      <label class="col-sm-3 text-left">Price *</label>
                      <div class="col-sm-6" id="price" style="">
                        <input type="text" class="form-control" name="prod_price" placeholder="Price" value="{{ old('prod_price') }}">
                        @if ($errors->has('prod_price'))
                        <div style="color:red;">
                          {{ $errors->first('prod_price') }}
                        </div>
                        @endif
                      </div>
                    </div>


              <div class="form-group">
                <label class="col-sm-3 control-label">Product Image *</label>
                <div class="col-sm-9">
                  <div class="table-responsive">
                    <table class="table table-bordered" >
                      <tr> </tr>
                      <tbody id="dynamic_field">
                        <tr id="row1">
                            <td>
                                <img src="" id="viewimgpen1" width="100" />
                                <input type="hidden" readonly name="image[1]"class="form-control name_list" id="imgpen1"/>
                            </td>
                            <td width="5%">
                                <a href="{{asset('assets/filemanager/dialog.php?type=1&field_id=imgpen')}}1" class="btn iframe-btn btn btn-sm btn-primary" title="Open"><i class="fa fa-camera"></i> Image</a>
                            </td>
                            <td width="5%" style="text-align:center;">
                                <input type="radio" name="primary_image" value="1" checked/> Primary
                            </td>
                            <td width="5%">
                                <button type="button" name="remove" id="1" class="btn btn-sm btn-danger btn_remove">Delete</button>
                            </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div id="addimage">
                    <button type="button" name="add" id="add" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Add</button>
                  </div>
                </div>
              </div>
              <!-- <div class="form-group">
                <label class="col-sm-3 text-left">Variation</label>
                <div class="col-sm-9" id="price" style="">
                  <input type="radio" onclick="aFunction()"   name="prod_var_status" id="varyes" value="1"  /> Yes
                  <input type="radio" onclick="bFunction()"  name="prod_var_status" id="varno" value="0"  checked/> No
                </div>
              </div> -->

            </div>
        </div>
        <div class="row">
          <div class="col-md-12 col-left">
            <div class="form-group">
                <label class="control-label">Product Description *</label>
                @if ($errors->has('prod_desc'))
                <div style="color:red;">
                    {{ $errors->first('prod_desc') }}
                </div>
                @endif
                <input type="text" class="form-control texteditor" name="prod_desc" value="{{ old('prod_desc') }}">
            </div>
          </div>
          <
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

<script type="text/javascript">

</script>

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

@endsection
