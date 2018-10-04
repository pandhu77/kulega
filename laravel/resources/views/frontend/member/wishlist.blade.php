@extends('frontend/member/menu')
@section('isi')

<style>
    font-family: 'Lato', sans-serif;
    .tab-content {
        margin-top: 50px;
    }
    .nav-pills {
        background-color: #f4f5f4;
    }
    .nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus {
        color: #fff;
        background-color: #B2203D;
        border-radius: 0px;
    }
    .nav-pills > li {
        float: none !important;
        width: auto !important;
        /* margin: 0 auto; */
    }
    .nav > li {
        position: relative;
        display: inline-block !important;
        /* margin: 0 auto; */
    }
    .pager li > a, .pager li > span {
        display: inline-block;
        padding: 12px 45px;
        background-color: #B2203D;
        border: 1px solid #ddd;
        border-radius: 0px;
        color: white;
      }
      a{
        color: #666;
        font-weight: 400;
        letter-spacing: 1px;
      }
      @media screen and (max-width: 900px) {
      .tableresponsive {
          border: 0;
      }

      .tableresponsive thead,tfoot {
          display: none;
      }

      .tableresponsive tr {
          margin-bottom: 10px;
          display: block;
          border-bottom: none;
      }

      .tableresponsive td {
          display: block;
          text-align: right;
          font-size: 13px;
          border-bottom: 0px dotted #ccc;
      }

      .tableresponsive td:last-child {
          border-bottom: 0;
      }

      .tableresponsive td:before {
          content: attr(data-label);
          float: left;
          text-transform: uppercase;
          font-weight: bold;
      }

      }
    .invoice{
      border: 1px solid #ddd;
      padding: 10px;
    }
    .table-striped > tbody > tr:nth-of-type(odd) {
         background-color: #fff;
    }
</style>
<title>{{web_name()}} | Wishlist</title>
<div class="col-md-9 box-right">
<h2 style="margin-top:-10px;">Wish<span style="color:#B2203D">list</span>  </h2>
<hr>
      @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <!-- <h4>  <i class="icon fa fa-check"></i> Alert!</h4> -->
            {{ Session::get('success') }}
        </div>
     @endif
     @if(Session::has('delete'))
       <div class="alert alert-info alert-dismissable">
           <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
           <!-- <h4>  <i class="icon fa fa-check"></i> Alert!</h4> -->
           {{ Session::get('delete') }}
       </div>
    @endif
     @if(Session::get('error_get'))
       <div class="alert alert-danger col-md-12 col-sm-12">
         <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
         {{ Session::get('error_get') }}</div>
     @endif


  <div class="tab-content"style="margin-top:30px;">
      <!-- First tab -->
      <div class="tab-pane active" id="progress">
          <section class="content invoice" style="margin-bottom: 10px;">
           <div class="row">
            <div class="col-xs-12 table">
              <table class="table table-striped table tableresponsive">
                <thead>
                  <tr>
                    <th style="text-align:center;" width="15%"></th>
                    <th style="text-align:center;" width="70%">Products from <span style="color:#B2203D"> your wishlist</span></th>
                    <th style="text-align:center;"></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($wish as $product)
                  @foreach($categall as $categs)
                    <?php if(in_array($categs->kateg_id,explode(',',$product->prod_category))){?>
                  <tr>
                    <td data-label="">
                      <img src="{{asset($product->front_image)}}" width="100%">
                      <form id="{{ $product->wish_id }}" action="{{ url('user/wishlist/'.$product->wish_id)}}" method="get">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <button type="button" style="margin-top:15px;" title="Delete This Wishlist" data-toggle="tooltip" class="btn btn-default remove-item hidden-xs" data-toggle="tooltip" onclick="checkdelete({{$product->wish_id}})"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Remove</button>
                      </form>
                    </td>
                    <td data-label="" style="text-align:left;">
                      <div class="isi-card" style="">
                        <span style="font-size:10px;"><?php echo date("d F Y",strtotime( $product->wish_date));?></span><br>
                        {{$product->brand_name}}<br>
                          <p style="font-weight:bold;">{{$product->prod_name}}</p>

                          <?php $result=Helper::check_dicount_catalog($product->prod_id,$categs->kateg_id,$product->prod_brand_id,$product->prod_price);
                               $total= $result['total'];
                               $disc= $result['disc'];
                               $prodid= $result['prodid'];
                               $type= $result['disc_reward'];
                               if($type=='nominal'){
                                 if($disc >= 1000) {
                                       $nominal= $disc / 1000 .'k';
                                   }
                                   else {
                                       $nominal= $disc;
                                }
                              }
                           ?>
                         @if( $disc > 0 )
                            <p><del><span class="price_format">{{$product->prod_price}}</span></del> &nbsp; &nbsp;
                                 <span style="color:#B2203D"><b>
                                  @if($type =='nominal') {{$nominal}}
                                  @else  {{$disc}}%
                                  @endif
                                </b>OFF</span>
                            </p>
                         @else
                             <p><span class="price_format" style="font-weight: bold; color: #B2203D;">{{$product->prod_price}}</span>
                             </p>
                         @endif
                         </div>
                         @if($disc > 0)
                          <p><b> <span class="price_format" style="font-weight: bold; color: #B2203D;">{{$total}}</span></b></p>
                         @endif
                    </td>
                    <td data-label=""style="text-align:right;">
                      <form id="{{ $product->wish_id }}" action="{{ url('user/wishlist/'.$product->wish_id)}}" method="GET">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <a href="{{ url('product-detail/'.$product->prod_url)}}"  style="margin-bottom:15px"title="View This Show" data-toggle="tooltip" class="btn btn-sm btn-primary back " data-toggle="tooltip"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Show Now</a><br>
                          <button type="button" style="margin-top:15px;position:absolute;left:15px;margin-top:-48px;" title="Delete This Wishlist" data-toggle="tooltip" class="btn btn-default remove-item hidden-sm hidden-lg hidden-md" data-toggle="tooltip" onclick="checkdelete({{$product->wish_id}})"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Remove</button>
                      </form>
                   </td>
                  </tr>
                  <?php break; } ?>
                  @endforeach
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
          </section>
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
