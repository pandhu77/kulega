@extends('backend/app')
@section('content')
<style>
.tab-content {
    margin-top: 50px;
}
.nav-pills {
    background-color: #2A3F54;
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

  .nav-pills li a{
    color: #ddd;
    font-weight: 400;
    letter-spacing: 1px;
  }

  a:focus, a:hover {
    color: #ddd;
    text-decoration: underline;
}
</style>
<title>System | Customer Service</title>
<div class="page-title">
  <div class="title_left">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h3>Customer Service  <small>show all customer</small></h3>
  </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12">
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
        <h2>Contact<small>User Mail</small></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <div class="col-sm-6 mail_list_column">
            <button id="button-composer" onclick="getcomposer()" class="btn btn-sm btn-success btn-block" type="button">COMPOSE</button>
            <div class="over2" style="max-height:900px;overflow:auto;border:1px solid #fff;">
              <ul class="nav nav-pills" style="text-align: center;">
                <li class="active"><a href="#level1" data-toggle="tab"> Customer Contact</a></li>
                <li><a href="#level2" data-toggle="tab">Subscribers Contact</a></li>
              </ul>
              <div class="tab-content"style="margin-top:30px;">
                <!-- First tab -->
                <div class="tab-pane active" id="level1">

                    <table id="datatable" class="table table-striped table-bordered">
                         <thead>
                           <tr>
                             <th>Customer ID</th>
                             <th>Customer Name</th>
                             <th>Customer Email</th>
                             <th width="50px;"> <input type="checkbox" name="status" value="" id="checkall" onclick="changeall()"> All</th>
                           </tr>
                         </thead>

                         <tbody>
                           @foreach($member as $data)
                             <tr>
                               <td data-label="ID">#{{$data->member_id}}</td>
                               <td data-label="Name">{{$data->member_fullname}}</td>
                               <td data-label="Email">{{$data->member_email}}</td>
                               <td data-label="Email">
                                 @if($data->member_service == 1)
                                 <input type="checkbox" class="cekbok" checked name="status" value="{{$data->member_service}}" id="checkid{{$data->member_id}}" onclick="changecheck({{$data->member_id}})">
                                 @else
                                 <input type="checkbox" class="cekbok" name="status" value="{{$data->member_service}}" id="checkid{{$data->member_id}}" onclick="changecheck({{$data->member_id}})">
                                 @endif
                               </td>
                             </tr>
                           @endforeach
                       </tbody>
                     </table>
                </div>
                <div class="tab-pane" id="level2">
                  <table id="datatable" class="table table-striped table-bordered">
                       <thead>
                         <tr>
                           <th>ID</th>
                           <th>Email</th>
                           <th width="50px;"> <input type="checkbox" name="substatus" value="" id="subcheckall" onclick="subchangeall()"> All</th>
                         </tr>
                       </thead>

                       <tbody>
                         @foreach($sub as $subs)
                           <tr>
                             <td data-label="ID">#{{$subs->id}}</td>
                             <td data-label="Email">{{$subs->email}}</td>
                             <td data-label="Email">
                               @if($subs->service == 1)
                               <input type="checkbox" class="subcekbok" checked name="substatus" value="{{$subs->service}}" id="subcheckid{{$subs->id}}" onclick="subchangecheck({{$subs->id}})">
                               @else
                               <input type="checkbox" class="subcekbok" name="substatus" value="{{$subs->service}}" id="subcheckid{{$subs->id}}" onclick="subchangecheck({{$subs->id}})">
                               @endif
                             </td>
                           </tr>
                         @endforeach
                     </tbody>
                   </table>
                </div>
              </div>
            </div>
          </div>
          <!-- /MAIL LIST -->

          <!-- CONTENT MAIL -->
          <div class="col-sm-6 mail_view">
            <div class="inbox-body">
              <div class="mail_heading row">

                <div class="col-md-12">
                  @if(Session::has('success-broadcast'))
                    <div class="alert alert-success alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      {{ Session::get('success-broadcast') }}
                    </div>
                    @endif

                    @if(Session::has('errors-broadcast'))
                      <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ Session::get('errors-broadcast') }}
                      </div>
                      @endif

                  <form class="form-horizontal" action="{{action('Backend\CustomerServiceController@store')}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-group" style="Display:none;" id="newemail">
                      <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Email</label>
                      <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                        <input type="email" class="form-control" name="newemail"placeholder="Email" style="">
                      </div>
                    </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Subject</label>
                        <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                          <input type="text" class="form-control" name="subject"placeholder="Subject">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Content / Message</label>
                        <div class="col-sm-10"style="padding-left:0px;padding-right:0px;">
                          <input type="text" class="form-control texteditor" name="content" value="">
                        </div>
                      </div>


                </div>
                <div class="col-md-12" style="text-align:right;">
                  <div class="btn-group">
                    <button class="btn btn-sm btn-primary" type="submit" data-original-title="Reply"><i class="fa fa-reply"></i> Reply</button>
                    <a href="{{url('backend')}}" class="btn btn-sm btn-default" type="button"  data-placement="top" data-toggle="tooltip" data-original-title="Back"><i class="fa fa-share"></i> Back</a>
                  </div>
                  </div>
                </form>
                </div>
              </div>
            </div>

          </div>
          <!-- /CONTENT MAIL -->
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
//get user biasa
function subchangecheck(idsub){
  var token = "{{ csrf_token() }}";
  var id = idsub;
  var status = $('#subcheckid'+idsub).val();
  var dataString = '_token=' + token + '&id=' + id + '&substatus=' + status;

  $.ajax({
    type: "POST",
    url: "{{url('ajax/changecheck/sub')}}",
    data: dataString,
    success: function (data) {

    }
  });
}
</script>


<script>
function subchangeall(){
  $('.subcekbok').click();
  var token = "{{ csrf_token() }}";
  var status=1;
  var dataString ='_token' + token +'&substatus' + status;

  $.ajax({
    type:"POST",
    url:"{{url('ajax/changeall/sub')}}",
    data:dataString,
    success: function(data){

    }
  });
}
</script>

<script type="text/javascript">
//get user biasa
function changecheck(idsub){
  var token = "{{ csrf_token() }}";
  var id = idsub;
  var status = $('#checkid'+idsub).val();
  var dataString = '_token=' + token + '&id=' + id + '&status=' + status;

  $.ajax({
    type: "POST",
    url: "{{url('ajax/changecheck')}}",
    data: dataString,
    success: function (data) {

    }
  });
}
</script>


<script>
function changeall(){
  $('.cekbok').click();
  var token = "{{ csrf_token() }}";
  var status=1;
  var dataString ='_token' + token +'&status' + status;

  $.ajax({
    type:"POST",
    url:"{{url('ajax/changeall')}}",
    data:dataString,
    success: function(data){

    }
  });
}
</script>
@endsection
