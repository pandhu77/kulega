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
<title>System | Customer Group</title>
<div class="page-title">
  <div class="title_left">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h3>Customer Group  <small>show all Group</small></h3>
  </div>
  </div>
  <!-- <div class="title_right">
    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for...">
        <span class="input-group-btn">
          <button class="btn btn-default" type="button">Go!</button>
        </span>
      </div>
    </div>
  </div> -->
</div>
<div class="clearfix"></div>
  <div class="col-md-12 col-sm-12 col-xs-12">
    <ul class="nav nav-pills" style="text-align: center;">
      <li class="active"><a href="#levelnull" data-toggle="tab">Common Customer Group </a></li>
      @foreach($level as $levels)
        <li class=""><a href="#level{{$levels->disc_level_id}}" data-toggle="tab">{{$levels->level_name}} Customer Group</a></li>
        <!-- <li><a href="#history" data-toggle="tab">Order List History </a></li>
        <li><a href="#canceled" data-toggle="tab">Order List Canceled </a></li> -->
      @endforeach
    </ul>

<div class="tab-content"style="margin-top:30px;">
  <!-- First tab -->
  <div class="tab-pane active" id="levelnull">
    <div class="x_panel">
      <div class="x_title">
        <h2>Common Customer Group List</h2>
        <!-- <div class="text-right" style="margin-bottom:20px;">
                    <a href="{{ url('backend/customer-list/create') }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add New</a>
                </div> -->
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
              <th>Customer ID</th>
              <th>Customer Name</th>
              <th>Customer Email</th>
              <th>Customer Phone</th>
              <!-- <th>Change Group</th> -->
              <th width="">Action</th>

            </tr>
          </thead>

          <tbody>
            @foreach($member as $data)
              @if($data->member_level==null || $data->member_level=='0')
              <tr>

                <td data-label="Customer ID">#{{$data->member_id}}</td>
                <td data-label="Customer">{{$data->member_fullname}}</td>
                <td data-label="Email">{{$data->member_email}}</td>
                <td data-label="Phone">{{$data->member_phone}}</td>
                <td data-label="Change Group">
                  <select class="form-control" data-live-search="true" name="member_level" id="memberlevel{{$data->member_id}}" onchange="getmemberlevel({{$data->member_id}})" required>
                        <option value="null"selected="selected">Command</option>
                     @foreach($level as $levels)
                        <option value="{{$levels->disc_level_id}}"  data-tokens="">{{$levels->level_name}}</option>
                      @endforeach
                  </select>

                </td>

                <!-- <td data-label="Action"class="btn-group">
                <form id="{{ $data->member_id }}" action="{{ url('backend/customer-list/'.$data->member_id)}}" method="get">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="_method" value="DELETE">
                  <a href="{{ url('backend/customer-list/edit/'.$data->member_id)}}" title="View This Member" data-toggle="tooltip" class="btn btn-sm btn-primary" data-toggle="tooltip"><span class="fa fa-edit" aria-hidden="true"></span></a>
                  <button type="button"  title="Delete This Member" data-toggle="tooltip" class="btn btn-danger btn-sm" data-toggle="tooltip" onclick="checkdelete({{$data->member_id}})"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>


                </form>
                </td> -->
              </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

@foreach($level as $levels)
  <!-- First tab -->
  <div class="tab-pane" id="level{{$levels->disc_level_id}}">
    <div class="x_panel">
      <div class="x_title">
        <h2>{{$levels->level_name}} Group List</h2>
        <!-- <div class="text-right" style="margin-bottom:20px;">
                    <a href="{{ url('backend/customer-list/create') }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add New</a>
                </div> -->
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
        <table id="datatable{{$levels->disc_level_id}}" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Customer ID</th>
              <th>Customer Name</th>
              <th>Customer Email</th>
              <th>Customer Phone</th>
              <th>Action</th>

              <!-- <th width="50px;">Action</th> -->

            </tr>
          </thead>

          <tbody>
            @foreach($member as $data)
              @if($data->member_level==$levels->disc_level_id)
              <tr>

                <td data-label="Customer ID">#{{$data->member_id}}</td>
                <td data-label="Customer">{{$data->member_fullname}}</td>
                <td data-label="Email">{{$data->member_email}}</td>
                <td data-label="Phone">{{$data->member_phone}}</td>
                <td data-label="Change Group">
                  <select class="form-control" data-live-search="true" name="member_level" id="memberlevel{{$data->member_id}}" onchange="getmemberlevel({{$data->member_id}})" required>
                        <option value="null">Command</option>
                     @foreach($level as $level2)
                        <option value="{{$level2->disc_level_id}}" <?php if($data->member_level==$level2->disc_level_id){echo 'selected="selected"';}?> data-tokens="">{{$level2->level_name}}</option>
                      @endforeach
                  </select>

                </td>

                <!-- <td data-label="Action"class="btn-group">
                <form id="{{ $data->member_id }}" action="{{ url('backend/customer-list/'.$data->member_id)}}" method="get">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="_method" value="DELETE">
                  <a href="{{ url('backend/customer-list/edit/'.$data->member_id)}}" title="View This Member" data-toggle="tooltip" class="btn btn-sm btn-primary" data-toggle="tooltip"><span class="fa fa-edit" aria-hidden="true"></span></a>
                  <button type="button"  title="Delete This Member" data-toggle="tooltip" class="btn btn-danger btn-sm" data-toggle="tooltip" onclick="checkdelete({{$data->member_id}})"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>


                </form>
                </td> -->
              </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @endforeach
  <!-- <div class="tab-pane col-sm-12" id="2">
  </div> -->
</div>
  </div>

  <script>
      function getmemberlevel(id){
        if (confirm('Are you sure ?')) {
          var level=$('#memberlevel'+id).val();
          var memberid=id;
          var token = "{{csrf_token()}}";
          var dataString= '_token='+token+ '&level='+level+'&memberid='+memberid;

          $.ajax({
              type: "POST",
              url: "{{ url('ajax/getmemberlevel') }}",
              data: dataString,
              success: function(data) {
                  // $('#level'+id).click();
                  location.reload();

              }
          });
        }else{
          $('#memberlevel'+id).val( $('#memberlevel'+id).find("option[selected]").val() );
        }
      }
  </script>
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
