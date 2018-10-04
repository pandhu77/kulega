@extends('backend/app')
@section('content')
<title>System | Member </title>
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Product: {{$row->prod_title}}</h3>
    </div>

  </div>
  <div class="clearfix"></div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
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
          <h2>Product Code: #{{$row->prod_code}} - {{$row->prod_title}} <small></small></h2>

          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
            <div class="profile_img">
              <div id="crop-avatar">
                <!-- Current avatar -->
                @if($row->front_image== null)
                <img class="img-responsive" id="viewimg" src="{{ asset('assets/img/ava.png') }}" alt="">
                @else
                <img class="img-responsive avatar-view" src="{{asset($row->front_image)}}" alt="Avatar" title="Change the avatar">
                @endif

              </div>
            </div>
            <h3>{{$row->prod_name}}</h3>
            <!-- start skills -->
            <h4>Product Status</h4>
            <ul class="list-unstyled user_data">
              <li>
                    @if($row->prod_enable ==1)<span class="label label-primary">Enable</span> @else <span class="label label-warning">Disable</span> @endif
              </li>

            </ul>

            <!-- end of skills -->

          </div>
          <div class="col-md-9 col-sm-9 col-xs-12">

            <div class="profile_title">
              <div class="col-md-12">
                <h2>Stock Product Management</h2>
              </div>

            </div>

              <div class="col-md-12 col-sm-12 col-xs-12" style="padding-top:20px; padding-left:0px;padding-right:0px;">
                    @if(Session::has('success'))
                      <div class="alert alert-success alert-dismissable">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          {{ Session::get('success') }}
                      </div>
                    @endif
                    @if(Session::has('get-errol'))
                      <div class="alert alert-danger alert-dismissable">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          {{ Session::get('get-errol') }}
                      </div>
                    @endif
                    <form action="{{action('Backend\ProductStockController@updatestockprod')}}" method="post" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                      <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
                      <input type="hidden"  name="prod_id" required="required" value="{{$row->prod_id}}" class="form-control col-md-7 col-xs-12" readonly>
                      <?php if($row->prod_var_status==0){ ?>
                      <div class="form-group" id="groupstock" style=" margin-top:15px;">
                          <label class="col-sm-3 text-left">Product Stock</label>
                          <div class="col-sm-9" id="price" style="">
                            <input type="number" class="form-control" name="prod_stock" value="{{$row->prod_stock}}" placeholder="Product Stock">
                          </div>
                      </div>
                      <?php }?>
                      <?php if($row->prod_var_status==1){ ?>
                      <div class="form-group" id="groupvarian" style="">
                        <label class="col-sm-12 control-label" style="margin-top:20px;">Variation</label>
                        <div class="col-sm-12">
                          <div class="table-responsive">
                                <table class="table table-bordered" >
                                  <tbody>
                                  <tr>
                                    <!-- <th>Name</th> -->
                                    <th>Size</th>
                                    <th>Color</th>
                                    <th>Color (Hex)</th>
                                    <th>Qty</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                  </tr>
                                </tbody>
                                @if($tmpvarian !==null)
                                  <tbody>
                                    <?php $a=300;?>
                                    @foreach($tmpvarian as $varian)

                                      <tr id="row">

                                         <td>
                                            <input type="hidden"  class="form-control" name="varianidedit[]" value="{{$varian->varian_id}}" id="varid<?php echo $a;?>">
                                            <input type="text" class="form-control" name="sizeedit[]" id="varsize<?php echo $a;?>" value="{{$varian->varian_size}}">
                                         </td>
                                         <td><input type="text" class="form-control" id="varcolor<?php echo $a;?>" name="coloredit[]"value="{{$varian->varian_color}}" ></td>
                                         <td><input type="color" class="form-control" name="color_hexedit[]" id="varhex<?php echo $a;?>" style="padding:0px;" value="{{$varian->varian_color_hex}}" ></td>
                                         <td>
                                            <input type="number" onchange="updateproduct({{$varian->varian_id}})" class="form-control" name="qtyedit[]" id="varqty{{$varian->varian_id}}"value="{{$varian->varian_stock}}">
                                            <div id="tampilalert{{$varian->varian_id}}"></div>
                                         </td>
                                         <td width="5%">@if($varian->varian_stock >0)<span class="label label-primary">Available</span> @else <span class="label label-warning">Empty</span> @endif</td>
                                         <td>
                                            <a href="#" onclick="updateproduct({{$varian->varian_id}})" name="update" id="<?php echo $a;?>" class="btn btn-sm btn-success btn_remove">Update</a>
                                          </td>
                                       </tr>
                                       <?php $a++;?>

                                     @endforeach
                                  </tbody>
                                  @endif
                                </table>
                             </div>
                        </div>
                    </div>
                    <?php }?>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 " style="text-align:right;">
                              <div class="ln_solid"></div>
                          <a href="{{url('backend/product')}}" class="btn btn-default">Back</a>
                          <?php if($row->prod_var_status==0){ ?>
                             <button type="submit" class="btn btn-success">Update Stock</button>
                        <?php }?>
                        </div>
                      </div>
                    </form>
                </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
     function updateproduct(varid){

      var qty= $('#varqty'+varid).val();
      var token ="{{csrf_token()}}";
      var dataString='_token='+ token +'&varid='+varid+'&qty='+qty;

      $.ajax({
          type:"GET",
          // dataType:'json',
          url:"{{url('backend/ajax/change-stock')}}",
          data:dataString,
           success:function(data){
            //  if(data.status == 0){

               $("#tampilalert"+varid).html(data);

            //  }
          }
      });

    }
</script>
@endsection
