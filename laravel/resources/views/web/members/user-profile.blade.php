@extends('web.master')
@section('title','Sonia')
@section('content')

@push('css')
<style media="screen">
    #addressmodal .form-control{
        margin-bottom: 10px;
        border-radius: 0px;
    }
</style>
@endpush

<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            <div class="col-sm-9">

                <!-- <img src="images/icons/avatar.jpg" class="alignleft img-circle img-thumbnail notopmargin nobottommargin" alt="Avatar" style="max-width: 84px;"> -->

                <div class="heading-block noborder">
                    <h3>{{ $user->member_fullname }}</h3>
                    <span>Your Profile Bio</span>
                </div>

                <div class="clear"></div>

                <div class="row clearfix">

                    <div class="col-md-12" style="max-width:100%;overflow-x:auto;">

                        <div class="tabs tabs-alt clearfix" id="tabs-profile">

                            <ul class="tab-nav clearfix">
                                <li><a href="#tab-profile"><i class="icon-rss2"></i> Profile</a></li>
                                <li><a href="#tab-password"><i class="icon-pencil2"></i> Password</a></li>
                                <li><a href="#tab-orders"><i class="icon-reply"></i> Orders</a></li>
                                <li><a href="#tab-address"><i class="icon-globe"></i> Address List</a></li>
                            </ul>

                            <div class="tab-container">

                                <style media="screen">
                                    #tab-profile td{
                                        border:none;
                                    }

                                    #tab-profile .title{
                                        width:200px;
                                    }

                                    #tab-profile .separation{
                                        width:2px;
                                    }
                                </style>

                                <div class="tab-content clearfix" id="tab-profile">
                                    <form action="{{ url('user/profile/update') }}" method="post">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <table class="table">
                                            <tr>
                                                <td class="title">Account Name</td>
                                                <td class="separation">:</td>
                                                <td class="input-name">{{ $user->member_fullname }}</td>
                                            </tr>
                                            <!-- <tr>
                                                <td class="title">Email</td>
                                                <td class="separation">:</td>
                                                <td class="input-email">{{ $user->member_email }}</td>
                                            </tr> -->
                                            <tr>
                                                <td class="title">Account Phone</td>
                                                <td class="separation">:</td>
                                                <td class="input-phone">{{ $user->member_phone }}</td>
                                            </tr>
                                            <tr>
                                                <td class="title">Account Address</td>
                                                <td class="separation">:</td>
                                                <td class="input-address">{{ $user->member_address }}</td>
                                            </tr>
                                        </table>
                                        <!-- <button type="button" class="btn btn-info" id="btn-edit" onclick="getinput()">Edit</button> -->
                                    </form>
                                </div>

                                <div class="tab-content clearfix" id="tab-password">
                                    <form action="{{ url('user/password/update') }}" method="post">
                                        <div class="form-group">
                                            <label>New Password</label>
                                            <input type="password" name="password" class="form-control" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <label>Confirm New Password</label>
                                            <input type="password" name="password_confirm" class="form-control" placeholder="Confirm Password">
                                        </div>
                                        <button type="button" class="btn btn-info" onclick="getpassword()" id="btn-change">Submit</button>
                                    </form>
                                </div>

                                <div class="tab-content clearfix" id="tab-orders">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Order Date</th>
                                                <th>Status Payment</th>
                                                <th>Total</th>
                                                <th> </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                            <tr>
                                                <td>#{{ $order->order_id }}</td>
                                                <td><?= date('d M Y',strtotime($order->order_date)) ?></td>
                                                <td>
                                                    <?php
                                                        if ($order->payment_status == 0) {
                                                            echo '<span class="label label-primary">Waiting</span>';
                                                        } elseif($order->payment_status == 1) {
                                                            echo '<span class="label label-warning">Waiting Confirm</span>';
                                                        } elseif($order->payment_status == 2) {
                                                            echo '<span class="label label-success">Completed</span>';
                                                        } elseif($order->payment_status == 3) {
                                                            echo '<span class="label label-danger">Cancelled</span>';
                                                        }
                                                    ?>
                                                </td>
                                                <td><?= number_format($order->order_total,0,',','.') ?></td>
                                                <td>
                                                    <a href="javascript:void(0)" class="btn btn-warning" onclick="getdetail({{ $order->order_id }})">View</a>
                                                    @if($order->payment_status == 0)
                                                        @if($order->payment_service == 2)
                                                            <a href="{{ url('confirm-payment/'.$order->order_id) }}" class="btn btn-info">Payment</a>
                                                        @else
                                                            <a href="{{ url('user/order/payment-confirmation/'.$order->order_id) }}" class="btn btn-info">Payment</a>
                                                        @endif
                                                        <a href="{{ url('user/order/cancel/'.$order->order_id) }}" class="btn btn-danger">Cancel</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-content clearfix" id="tab-address">

                                    <a href="javascript:void(0)" class="btn btn-info" style="margin-bottom:30px;" onclick="addaddress()">Add Address</a>

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Country</th>
                                                <th>Title</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Address</th>
                                                <th> </th>
                                            </tr>
                                        </thead>
                                        <tbody id="body-address">
                                            @if(count($address) > 0)
                                                @foreach($address as $addr)
                                                    <tr>
                                                        <td>{{ $addr->country }}</td>
                                                        <td>{{ $addr->title }}</td>
                                                        <td>{{ $addr->first_name }}</td>
                                                        <td>{{ $addr->last_name }}</td>
                                                        <td>{{ $addr->address }}</td>
                                                        <td>
                                                            <!-- <a href="javascript:void(0)" class="btn btn-warning" onclick="editaddr({{ $addr->id }})">Edit</a> -->
                                                            <a href="javascript:void(0)" class="btn btn-danger" onclick="deladdr({{ $addr->id }})">Delete</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>Empty</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div id="myModal" class="modal fade" role="dialog" style="z-index:99999999;">
              <div class="modal-dialog modal-lg" style="margin-top:100px;">

                <!-- Modal content-->
                <div class="modal-content" style="border-radius:0px;">
                  <div class="modal-header" style="border-bottom:none;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="headerorder">Modal Header</h4>
                  </div>
                  <div class="modal-body" id="contentorder">
                    <p>Some text in the modal.</p>
                  </div>
                  <!-- <div class="modal-footer" style="border-top:none;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div> -->
                </div>

              </div>
            </div>

            <div id="addressmodal" class="modal fade" role="dialog" style="z-index:99999999;">
              <div class="modal-dialog modal-sm" style="margin-top:100px;">

                <!-- Modal content-->
                <div class="modal-content" style="border-radius:0px;">
                  <div class="modal-header" style="border-bottom:none;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add New Address</h4>
                  </div>
                  <div class="modal-body">
                    <input type="text" class="form-control" name="title" placeholder="Title" required>
                    <input type="text" class="form-control" name="first_name" placeholder="First Name" required>
                    <input type="text" class="form-control" name="last_name" placeholder="Last Name" required>
                    <textarea name="address" rows="4" class="form-control" placeholder="Address" required></textarea>
                    <select class="form-control" name="country" onchange="checkcountry()">
                        <option value="" selected="" disabled="">Select Country</option>
                    </select>

                    <div id="indofield">
                        <select class="form-control" name="province" onchange="shippingcity(1)">
                            <option value="" selected="" disabled="">Select Province</option>
                        </select>
                        <select class="form-control" name="city" onchange="shippingdistrict(1)">
                            <option value="" selected="" disabled="">Select City</option>
                        </select>
                        <select class="form-control" name="district">
                            <option value="" selected="" disabled="">Select District</option>
                        </select>
                    </div>

                    <input type="text" class="form-control" name="poscode" placeholder="Poscode" required>
                    <input type="text" class="form-control" name="phone" placeholder="Phone" required>
                  </div>
                  <div class="modal-footer" style="border-top:none;">
                    <button type="button" class="btn btn-default" onclick="insertnewaddress()" id="addnewaddress" style="border-radius:0px;background-color:#1ABC9C;border-color:#1ABC9C;" >Add New</button>
                  </div>
                </div>

              </div>
            </div>

            <div id="editaddressmodal" class="modal fade" role="dialog" style="z-index:99999999;">
              <div class="modal-dialog modal-sm" style="margin-top:100px;">

                <!-- Modal content-->
                <div class="modal-content" style="border-radius:0px;">
                  <div class="modal-header" style="border-bottom:none;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit New Address</h4>
                  </div>
                  <div class="modal-body" id="content-editaddr">
                    Loading...
                  </div>
                  <div class="modal-footer" style="border-top:none;">
                    <button type="button" class="btn btn-default" onclick="editaddr()" id="editaddress">Edit Now</button>
                  </div>
                </div>

              </div>
            </div>


            <div class="line visible-xs-block"></div>

            <div class="col-sm-3 clearfix">

                <div class="list-group">
                    <a href="{{ url('user/profile') }}" class="list-group-item clearfix">Profile <i class="icon-user pull-right"></i></a>
                    <!-- <a href="#" class="list-group-item clearfix">Servers <i class="icon-laptop2 pull-right"></i></a>
                    <a href="#" class="list-group-item clearfix">Messages <i class="icon-envelope2 pull-right"></i></a>
                    <a href="#" class="list-group-item clearfix">Billing <i class="icon-credit-cards pull-right"></i></a>
                    <a href="#" class="list-group-item clearfix">Settings <i class="icon-cog pull-right"></i></a> -->
                    <a href="{{ url('user/logout') }}" class="list-group-item clearfix">Logout <i class="icon-line2-logout pull-right"></i></a>
                </div>

                <!-- <div class="fancy-title topmargin title-border">
                    <h4>About Me</h4>
                </div> -->

                <!-- <div class="feature-box fbox-plain fbox-dark fbox-small">
                    <div class="fbox-icon">
                        <i class="icon-email" style="font-size:25px;"></i>
                    </div>
                    <h3>Email</h3>
                    <p class="notopmargin">{{ $user->member_email }}</p>
                </div>

                <div class="feature-box fbox-plain fbox-dark fbox-small">
                    <div class="fbox-icon">
                        <i class="icon-phone" style="font-size:25px;"></i>
                    </div>
                    <h3>Phone</h3>
                    <p class="notopmargin">{{ $user->member_phone }}</p>
                </div>

                <div class="feature-box fbox-plain fbox-dark fbox-small">
                    <div class="fbox-icon">
                        <i class="icon-globe" style="font-size:25px;"></i>
                    </div>
                    <h3>Address</h3>
                    <p class="notopmargin">{{ $user->member_address }}</p>
                </div> -->

            </div>


        </div>

    </div>

</section><!-- #content end -->

@push('js')
<script type="text/javascript">
    function getinput(){
        $('.input-name').html('<input type="text" class="form-control" name="member_fullname" value="{{ $user->member_fullname }}" placeholder="Name" required>');
        // $('.input-email').html('<input type="text" class="form-control" name="member_email" value="{{ $user->member_email }}" placeholder="Email" required>');
        $('.input-phone').html('<input type="text" class="form-control" name="member_phone" value="{{ $user->member_phone }}" placeholder="Phone" required>');
        $('.input-address').html('<input type="text" class="form-control" name="member_address" value="{{ $user->member_address }}" placeholder="Address" required>');
        $('#btn-edit').attr('onclick','postsubmit()');
        $('#btn-edit').html('Update');
    }
</script>

<script type="text/javascript">
    function postsubmit(){
        $('#tab-profile').find('form').submit();
    }
</script>

<script type="text/javascript">
    function getpassword(){
        var password            = $('[name=password]').val();
        var password_confirm    = $('[name=password_confirm]').val();

        if (password == '') {
            alert('Please Fill Password Form');
        }else {
            if (password != password_confirm) {
                alert('Password and Password Confirm not same');
            }else {
                $('#tab-password').find('form').submit();
            }
        }
    }
</script>

<script type="text/javascript">
    function getdetail(order_id){

        $('#myModal').modal('show');

        var datapost = {
            "_token"    : "{{ csrf_token() }}",
            "order_id"  : order_id
        }

        $.ajax({
            type    : "POST",
            url     : "{{ url('user/order/detail') }}",
            data    : datapost,
            success : function(data){
                $('#headerorder').html('Order #'+order_id);
                $('#contentorder').html(data);
            }
        })
    }
</script>

<script type="text/javascript">
    function addaddress(){
        $('#addressmodal').modal('show');
        shippingcountry();
        shippingprovince();
    }

    function checkcountry(){
        var country = $('[name=country]').val();
        var country_name = $('[name=country]  option:selected').attr('country');
        if (country == 0) {
            $('#indofield').html(   '<select class="form-control" name="province" onchange="shippingcity(1)">'+
                                        '<option value="" selected="" disabled="">Select Province</option>'+
                                    '</select>'+
                                    '<select class="form-control" name="city" onchange="shippingdistrict(1)">'+
                                        '<option value="" selected="" disabled="">Select City</option>'+
                                    '</select>'+
                                    '<select class="form-control" name="district">'+
                                        '<option value="" selected="" disabled="">Select District</option>'+
                                    '</select>');
            shippingprovince();
        } else {
            $('#indofield').html(   '<select class="form-control hidden" name="province">'+
                                        '<option value="'+country_name+'" selected="" province="'+country_name+'">Select Province</option>'+
                                    '</select>'+
                                    '<select class="form-control hidden" name="city">'+
                                        '<option value="'+country_name+'" selected="" city="'+country_name+'">Select City</option>'+
                                    '</select>'+
                                    '<select class="form-control hidden" name="district">'+
                                        '<option value="'+country_name+'" selected="" district="'+country_name+'">Select District</option>'+
                                    '</select>');
        }
    }
</script>


<script type="text/javascript">
function shippingcountry(){
    var datapost = {
        "_token" : "{{ csrf_token() }}"
    }

    $.ajax({
        type : "POST",
        url : "{{ url('shipping/country') }}",
        data : datapost,
        beforeSend : function(){
            $('[name=country]').html('<option value="">Loading</option>');
        },
        success : function(data){
            $('[name=country]').html(data);
        }
    })
}

function shippingprovince(){
    var datapost = {
        "_token" : "{{ csrf_token() }}"
    }

    $.ajax({
        type : "POST",
        url : "{{ url('shipping/province') }}",
        data : datapost,
        beforeSend : function(){
            $('[name=province]').html('<option value="">Loading</option>');
            $('[name=city]').html('<option value="">Loading</option>');
            $('[name=district]').html('<option value="">Loading</option>');
        },
        success : function(data){
            $('[name=province]').html(data);
            $('[name=city]').html('<option value="">Select City</option>');
            $('[name=district]').html('<option value="">Select Disctrict</option>');
        }
    })
}

function shippingcity(trigger){
    var province = $('[name=province]').val();
    var datapost = {
        "_token"    : "{{ csrf_token() }}",
        "province"  : province,
        "trigger"   : trigger
    }

    $.ajax({
        type : "POST",
        url : "{{ url('shipping/city') }}",
        data : datapost,
        beforeSend : function(){
            $('[name=city]').html('<option value="">Loading</option>');
            $('[name=district]').html('<option value="">Loading</option>');
        },
        success : function(data){
            $('[name=city]').html(data);
            $('[name=district]').html('<option value="">Select District</option>');
        }
    })
}

function shippingdistrict(trigger){
    var city = $('[name=city]').val();
    var datapost = {
        "_token"    : "{{ csrf_token() }}",
        "city"      : city,
        "trigger"   : trigger
    }

    $.ajax({
        type : "POST",
        url : "{{ url('shipping/district') }}",
        data : datapost,
        beforeSend : function(){
            $('[name=district]').html('<option value="">Loading</option>');
        },
        success : function(data){
            $('[name=district]').html(data);
        }
    })
}
</script>

<script type="text/javascript">
function insertnewaddress(){
    var title       = $('[name=title]').val();
    var first_name  = $('[name=first_name]').val();
    var last_name   = $('[name=last_name]').val();
    var address     = $('[name=address]').val();
    var country     = $('[name=country]  option:selected').attr('country');
    var country_id  = $('[name=country]  option:selected').val();
    var province    = $('[name=province]  option:selected').attr('province');
    var city        = $('[name=city]  option:selected').attr('city');
    var district    = $('[name=district]  option:selected').attr('district');
    var district_id = $('[name=district]  option:selected').val();
    var poscode     = $('[name=poscode]').val();
    var phone       = $('[name=phone]').val();

    var valid_province    = $('[name=province]  option:selected').val();
    var valid_city        = $('[name=city]  option:selected').val();
    var valid_district    = $('[name=district]  option:selected').val();

    if (title == "" || first_name == "" || last_name == "" || address == "" || valid_province == "" || valid_city == "" || valid_district == "" || poscode == "" || phone == "") {
        // alert('Please select all shipping form');
        swal("Warning !", "Please fill all form", "warning");
    } else {

        var datapost = {
            "_token"    : "{{ csrf_token() }}",
            "title"     : title,
            "first_name": first_name,
            "last_name" : last_name,
            "address"   : address,
            "country_id": country_id,
            "country"   : country,
            "province"  : province,
            "city"      : city,
            "district"  : district,
            "district_id": district_id,
            "poscode"   : poscode,
            "phone"     : phone
        }

        $.ajax({
            type    : "POST",
            url     : "{{ url('user/ajax/insertaddress') }}",
            data    : datapost,
            beforeSend: function(){
                $('#addnewaddress').attr('onclick','false');
            },
            success: function(data){
                swal("Success !", "Success insert new address", "success");
                $('#body-address').html(data);
                $('#addnewaddress').attr('onclick','insertnewaddress()');
                $('#addressmodal').modal('hide');
            }
        })

    }
}
</script>

<script type="text/javascript">
    function deladdr(id){
        // $('#editaddressmodal').modal('show');
        var datapost = {
            "_token"    : "{{ csrf_token() }}",
            "addrid"    : id
        }

        $.ajax({
            type : "POST",
            url : "{{ url('user/ajax/deleteaddress') }}",
            data : datapost,
            beforeSend : function(){

            },
            success : function(data){
                swal("Success !", "Success delete address", "success");
                $('#body-address').html(data);
            }
        })
    }
</script>
@endpush

@endsection
