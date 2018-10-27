@extends('web.master')
@section('title','www.kulega.com')
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
                    <span>Donation of Goods</span>
                </div>
                <div class="clear"></div>
                <div class="row clearfix">
                    <div class="col-md-12" style="max-width:100%;overflow-x:auto;">
                        <div class="tabs tabs-alt clearfix" id="tabs-profile">
                            <ul class="tab-nav clearfix">
                                <li><a href="#tab-addnew"><i class="fa fa-cubes"></i> Form Donation </a></li>
                                <li><a href="#tab-history"><i class="fa fa-calendar"></i> History</a></li>
                            </ul>
                            <div class="tab-container">
                                <style media="screen">
                                    #tab-addnew td{
                                        border:none;
                                    }
                                    #tab-addnew .title{
                                        width:200px;
                                    }
                                    #tab-addnew .separation{
                                        width:2px;
                                    }
                                </style>
                                <div class="tab-content clearfix" id="tab-addnew">
                                    @if(count($errors->all()) > 0)
                                    <div class="alert alert-danger">
                                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                      @foreach($errors->all() as $error)
                                      <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <?php echo $error."</br>";?>
                                      @endforeach
                                    </div>
                                    @endif

                                    @if(Session::has('success'))
                                      <div class="alert alert-success alert-dismissible fade in">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <h4 style="margin: 0px;">  <i class="icon fa fa-check"></i> Success!</h4>
                                        {{ Session::get('success') }}
                                      </div>
                                    @endif
                                    <form action="{{ url('user/donatebarang') }}" method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label>Name *</label>
                                            <input type="text" id="title" name="name" value="{{ old('name') }}" required="required" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Category *</label>
                                            <select class="form-control" data-live-search="true" name="parent" required>
                                                <option value="" selected disabled>--- Select category ---</option>
                                               @foreach($kateg as $kategs)
                                                  <option value="{{$kategs->id}}" data-tokens="">{{$kategs->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Image *</label>
                                            <input type="file" id="image" name="image" required="required" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Description *</label>
                                            <textarea rows="5" class="form-control" name="desc">{{ old('desc') }}</textarea>
                                        </div>

                                        <button type="reset" class="btn" id="btn-change">Reset</button>
                                        <button type="submit" class="btn btn-info" id="btn-change">Send Data</button>
                                    </form>
                                </div>
                                <div class="tab-content clearfix" id="tab-history">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th style="width: 150px;">Date</th>
                                                <th style="width: 150px;">Name Donation</th>
                                                <th style="text-align: center;">Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($historys as $history)
                                            <tr>
                                                <td><?= date('d M Y',strtotime($history->date)) ?></td>
                                                <td style="font-weight: bold;"><?php echo $history->name; ?></td>
                                                <td><?php echo $history->desc; ?></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="line visible-xs-block"></div>
            <div class="col-sm-3 clearfix">
                <div class="list-group">
                    <a href="{{ url('user/profile') }}" class="list-group-item clearfix">Profile <i class="icon-user pull-right"></i></a>

                    <a href="{{ url('user/campaignbuy') }}" class="list-group-item clearfix">Campaign Buyyer <i class="fa fa-paper-plane-o pull-right" aria-hidden="true"></i></a>

                    <a href="{{ url('user/donatebarang') }}" class="list-group-item clearfix">Donate <i class="fa fa-cubes pull-right" aria-hidden="true"></i></a>

                    <a href="{{ url('user/logout') }}" class="list-group-item clearfix">Logout <i class="icon-line2-logout pull-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section><!-- #content end -->

@push('js')
@endpush

@endsection