@extends('web.app')
@section('content')

<?php $website = DB::table('cms_config')->first(); ?>
<title>Profile | {{ $website->site_name }}</title>

<!-- Content
============================================= -->
<?php $getsetting = DB::table('t_theme_setting')->where('active',1)->first(); ?>

<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            <div class="row clearfix">

                @include('themes.'.$getsetting->name.'.module.user-profile')

            </div>

        </div>

    </div>

</section>

@stop
