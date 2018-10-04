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
                                    <td class="title">Name</td>
                                    <td class="separation">:</td>
                                    <td class="input-name">{{ $user->member_fullname }}</td>
                                </tr>
                                <!-- <tr>
                                    <td class="title">Email</td>
                                    <td class="separation">:</td>
                                    <td class="input-email">{{ $user->member_email }}</td>
                                </tr> -->
                                <tr>
                                    <td class="title">Phone</td>
                                    <td class="separation">:</td>
                                    <td class="input-phone">{{ $user->member_phone }}</td>
                                </tr>
                                <tr>
                                    <td class="title">Address</td>
                                    <td class="separation">:</td>
                                    <td class="input-address">{{ $user->member_address }}</td>
                                </tr>
                            </table>
                            <button type="button" class="btn btn-info" onclick="getinput()" id="btn-edit">Edit</button>
                        </form>
                    </div>

                    <script type="text/javascript">
                        function getinput(){
                            $('.input-name').html('<input type="text" class="form-control" name="member_fullname" value="{{ $user->member_fullname }}" placeholder="Name" required>');
                            $('.input-email').html('<input type="text" class="form-control" name="member_email" value="{{ $user->member_email }}" placeholder="Email" required>');
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
                                        <a href="javascript:void(0)" class="btn btn-warning" data-toggle="modal" data-target="#myModal" onclick="getdetail({{ $order->order_id }})">View</a>
                                        @if($order->payment_status == 0)
                                            <a href="{{ url('confirm-payment/'.$order->order_id) }}" class="btn btn-info">Payment</a>
                                            <a href="{{ url('user/order/cancel/'.$order->order_id) }}" class="btn btn-danger">Cancel</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <script type="text/javascript">
                        function getdetail(order_id){
                            var datapost = {
                                "_token"    : "{{ csrf_token() }}",
                                "order_id"  : order_id
                            }

                            $.ajax({
                                type    : "POST",
                                url     : "{{ url('user/order/detail') }}",
                                data    : datapost,
                                success : function(data){
                                    $('.modal-title').html('Order #'+order_id);
                                    $('.modal-body').html(data);
                                }
                            })
                        }
                    </script>

                </div>

            </div>

        </div>

    </div>

</div>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="margin-top:100px;">

    <!-- Modal content-->
    <div class="modal-content" style="border-radius:0px;">
      <div class="modal-header" style="border-bottom:none;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <!-- <div class="modal-footer" style="border-top:none;">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div> -->
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

    <div class="feature-box fbox-plain fbox-dark fbox-small">
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
    </div>

</div>
