@extends('backend/app')
@section('content')
<title>System | Product </title>
<div class="page-title">

  <div class="col-sm-12 title_left">
    <h3>Product Stock Management <small>show all product</small></h3>

  </div>
</div>
<div class="clearfix"></div>
  <div class="col-md-12 col-sm-12 col-xs-12">
    <ul class="nav nav-pills" style="text-align: center;">
      <li class="active"><a href="#ampty" data-toggle="tab">STOCK EMPTY</a></li>
      <li class=""><a href="#available" data-toggle="tab">STOCK AVAILABLE</a></li>
    </ul>
    <div class="tab-content"style="margin-top:30px;">
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
      <!-- First tab -->
      <div class="tab-pane active" id="ampty">
            <div class="x_panel">
              <div class="x_title">
                <h2>Product list</h2>
                <div class="text-right" style="margin-bottom:20px;">
                            <a href="{{ url('backend/product/create') }}" class="btn btn-default"><span class="fa fa-plus" aria-hidden="true" style="color:#fff;"></span> Add New</a>
                        </div>
                <div class="clearfix"></div>

              </div>
              <div class="x_content">
                <table id="datatable" class="table table-striped projects">
                  <thead>
                    <tr>
                      <th>#ID</th>
                      <th width="5%">Image</th>
                      <th>Product</th>
                      <th>Enable</th>
                      <th>Action</th>
                    </tr>
                  </thead>

                  <tbody>
                    @foreach($prod as $data)
                      <tr>
                        <td data-label="#">{{$data->prod_id}}</td>
                        <td data-label="Image"><img src="{{asset($data->front_image)}}"class="img-responsive"></td>
                        <td data-label="Product ">
                          Code: {{$data->prod_code}} - {{$data->prod_name}}<br>
                        </td>
                        <td data-label="Enable">@if($data->prod_enable ==1)<span class="label label-primary">Enable</span> @else <span class="label label-warning">Disable</span> @endif</td>
                        <td data-label="Action" class="btn-group">
                          <a href="{{ url('backend/product-stock/show/'.$data->prod_id)}}" title="View This Product" data-toggle="tooltip" class="btn btn-sm btn-primary" data-toggle="tooltip"><span class="fa fa-edit" aria-hidden="true"></span></a>
                        </form>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
          </div>
        </div>
        <!-- two tab -->
        <div class="tab-pane" id="available">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Product list</h2>
                  <div class="text-right" style="margin-bottom:20px;">
                              <a href="{{ url('backend/product/create') }}" class="btn btn-primary"><span class="fa fa-plus" aria-hidden="true" style="color:#fff;"></span> Add New</a>
                          </div>
                  <div class="clearfix"></div>

                </div>
                <div class="x_content">
                  <table id="datatable" class="table table-striped projects">
                    <thead>
                      <tr>
                        <th>#ID</th>
                        <th width="5%">Image</th>
                        <th>Product</th>
                        <th>Enable</th>
                        <th>Action</th>
                      </tr>
                    </thead>

                    <tbody>
                      @foreach($prod as $data)
                        <tr>
                          <td data-label="#">{{$data->prod_id}}</td>
                          <td data-label="Image"><img src="{{asset($data->front_image)}}"class="img-responsive"></td>
                          <td data-label="Product ">
                            Code: {{$data->prod_code}} - {{$data->prod_name}}<br>
                          </td>
                          <td data-label="Enable">@if($data->prod_enable ==1)<span class="label label-primary">Enable</span> @else <span class="label label-warning">Disable</span> @endif</td>
                          <td data-label="Action" class="btn-group">
                            <a href="{{ url('backend/product/'.$data->prod_id.'/edit')}}" title="View This Product" data-toggle="tooltip" class="btn btn-sm btn-primary" data-toggle="tooltip"><span class="fa fa-edit" aria-hidden="true"></span></a>
                          </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
          </div>
      </div>
  </div>
  @endsection
