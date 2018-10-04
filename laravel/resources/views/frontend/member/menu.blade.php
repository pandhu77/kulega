@extends('app')
@section('content')
<style>
	.accordion-menu {
    margin: 1rem 0rem;
    padding: 0;
    list-style: none;
    background-color: #f4f5f4;
    -webkit-box-shadow: none;
    box-shadow: none;
    border-radius: 0;
}

.accordion-menu .item a {
    display:block;
    padding: .83em .95em;
    height: auto!important;
    line-height: 2;
}

.accordion-menu .item {
	font-weight: bold;
    position: relative;
    font-size: 1.125rem;
    display: block;
    border-top: 0;
    border-left: 0 solid rgba(0,0,0,0);
    border-right: 0;
    border-top: 0 solid rgba(0,0,0,0);
    -webkit-tap-highlight-color: rgba(0,0,0,0);
    -moz-user-select: -moz-none;
    -khtml-user-select: none;
    -webkit-user-select: none;
    vertical-align: middle;
    text-decoration: none;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    -ms-box-sizing: border-box;
    box-sizing: border-box;
    -webkit-transition: opacity .2s ease,background .2s ease,-webkit-box-shadow .2s ease;
    transition: opacity .2s ease,background .2s ease,box-shadow .2s ease;
}
.accordion-menu .item a {
    color: inherit;
    text-decoration: none;
}
.submenu .icon {
    display: block;
    position: absolute;
    right: 5px;
    top: 1em;
    color: rgba(0,0,0,.25);
}
.submenu.item + ul .active.item:not(.current_page_ancestor )  {
    background-color: #B2203D;
    color: #f1f1f1;
}
.submenu.item + ul .active.item:not(.current_page_ancestor ):hover  {
    background-color: #ea6ba7;
    color: #f1f1f1;
}

.accordion-menu .item:before {
    position: absolute;
    content: '';
    top: 0;
    left: 0;
    width: 100%;
    height: 1px;
    background-image: -webkit-linear-gradient(left,rgba(0,0,0,.03) 0,rgba(0,0,0,.1) 1.5em,rgba(0,0,0,.03) 100%);
    background-image: -webkit-gradient(linear,left top,right top,from(rgba(0,0,0,.03)),color-stop(1.5em,rgba(0,0,0,.1)),to(rgba(,0,0,.03)));
    background-image: linear-gradient(to right,rgba(0,0,0,.03) 0,rgba(0,0,0,.1) 1.5em,rgba(0,0,0,.03) 100%);
}

.accordion-menu > .item.active {
    border-radius: 0;
    -webkit-box-shadow: .2em 0 0 #b3296b inset;
    box-shadow: .2em 0 0 #b3296b inset;
}

.accordion-menu .item:hover {
    cursor: pointer;
    background-color: rgba(0,0,0,.05);
}

.submenu.item + ul {
    padding: 0;
    display: none;

}

.submenu.item + ul .item {
    background-color: rgba(0,0,0,.1);
}

.submenu.item + ul .item:hover {
    background-color: rgba(0,0,0,.15);
}
hr{
	 border-bottom: 1px solid #ddd;
	 border-top: none;
}


.btn-primary:focus, .btn-primary.focus {
		color: #fff;
		background-color: #999;
		border-color: #999;
}
.btn-primary:hover {
		color: #333;
		background-color: #fff;
		border-color: #333;
}
.btn-warning {
		color: #fff;
		background-color: #B2203D;
		border-color: #B2203D;
}
.btn-warning:focus, .btn-warning.focus {
		color: #B2203D;
		background-color: #fff;
		border-color: #B2203D;
}
.btn-warning:active, .btn-warning.active, .open > .dropdown-toggle.btn-warning {
    color: #B2203D;
    background-color: #fff;
    border-color: #B2203D;
}
.btn-warning:hover {
		color: #B2203D;
		background-color: #fff;
		border-color: #B2203D;

}
.btn-warning:active:hover, .btn-warning.active:hover, .open > .dropdown-toggle.btn-warning:hover, .btn-warning:active:focus, .btn-warning.active:focus, .open > .dropdown-toggle.btn-warning:focus, .btn-warning:active.focus, .btn-warning.active.focus, .open > .dropdown-toggle.btn-warning.focus {
    color: #B2203D;
    background-color: #fff;
    border-color: #B2203D;
}
.confirmation {
		float: right;
		border: 0;
		margin-top: 20px;
		padding: 5px 15px;
		background-color: #B2203D;
		color: #fff;
		font-size: 16px;
		border-radius: 0px;
}

.btn-default{
	background-color: #fff;
	color: #333;
	border:1px solid #999;
}
.btn-default:hover, .btn-default:focus{
	background-color: #fff;
	color: #333;
	border:1px solid #999;
}


.back {
		border: 0;
		margin-top: 20px;
		padding: 4px 15px;
		background-color: #333;
		color: #fff;
		font-size: 16px;
		border-radius: 0px;
		border:1px solid #333;
}
.back:hover, .back:focus{
	background-color: #fff;
	color: #333;
	border:1px solid #333;
}
.remove-item {
		border: 0;
		margin-top: 20px;
		padding: 4px 15px;
		background-color: #fff;
		color: #333;
		font-size: 16px;
		border-radius: 0px;
		border:1px solid #999;
}
.remove-item:hover, .remove-item:focus{
		background-color: #fff;
		color: #333;
		border:1px solid #999;
}


.confirmation:hover, .confirmation:focus{
	background-color: #fff;
	color: #B2203D;
	border:1px solid #B2203D;
}
.btn-group > .btn, .btn-group-vertical > .btn {
		position: relative;
		/*float: left;*/
}
.btn-group-sm>.btn, .btn-sm {
		position: relative;
		/*float: left;*/
}
.btn-group .btn+.btn, .btn-group .btn+.btn-group, .btn-group .btn-group+.btn, .btn-group .btn-group+.btn-group {
		margin-left: -1px;
		border-top-left-radius: 0;
		border-bottom-left-radius: 0;
}


.panel-contact {
    border-radius: 8px;
    border-color: rgba(241,241,241,0.5);
}

@media screen and (min-width: 1000px) {
	.box-left{
		width: 22%;
	}
	.box-right{
		width: 78%;

	}
	.box-left{
	  background-color: rgba(241,241,241,0.5);
	  border-radius: 8px;
	  padding-top: 15px;
	  padding-bottom: 15px;
		padding: 5px;
	}
	.pagination{
		float: right;
	}
	.pagination > li > a, .pagination > li > span {
    color: #333;
    background-color: #e7e7e7;
    border: 1px solid #e7e7e7;
	}
	.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
    color: #fff;
    background-color: #B2203D;
    border-color: #B2203D;
	}
	.pagination > .disabled > span, .pagination > .disabled > span:hover, .pagination > .disabled > span:focus, .pagination > .disabled > a, .pagination > .disabled > a:hover, .pagination > .disabled > a:focus {
    background-color: #ddd;
    border-color: #ddd;
	}
	.pagination > li > a:hover, .pagination > li > span:hover, .pagination > li > a:focus, .pagination > li > span:focus {
    z-index: 2;
    color: #B2203D;
    background-color: #ddd;
    border-color: #ddd;
	}
	.table{
		margin-bottom: 0px;
	}
}

</style>
		<div class="container">
			 <?php $url = request()->segment(1)."/".request()->segment(2);?>

				<div class="col-md-3 hidden-sm hidden-md hidden-lg" style="z-index: 999;margin-bottom: 20px;">
					<!--MOBILE START-->

					<div style="width:100%; text-align: center;background-color:#333;padding-top: 10px;padding-bottom: 10px;">
						<a class="hidden-lg hidden-md hidden-sm collapsed" data-toggle="collapse" data-target="#submenu" style="font-size: 12pt; text-decoration: none;text-align: center;color: #fff"><span> MENU <i class="fa fa-caret-down" aria-hidden="true"></i></span></a>
					</div>

					<ul id="submenu" style="padding-left: 0px;padding-right: 0px;" class="collapse navbar-collapse collapse side-nav-bar accordion-menu">

							<li id="item-2" class="item  <?php if($url=='user/profile'){ echo 'active'; }?> "><a href="{{url('user/profile')}}">My Account</a></li>
							<li id="item-1" class="item  <?php if($url=='user/order'){ echo 'active'; }?>"><a href="{{url('user/order')}}">Order</a></li>
							<!-- <li id="item-4" class="item"><a href="#">Transfer Confirmation</a></li> -->
							<li id="item-2" class="item <?php if($url=='user/wishlist'){ echo 'active'; }?>"><a href="{{url('user/wishlist')}}">Wishlist</a></li>
							<li id="item-3" class="item <?php if($url=='user/my-shipping'){ echo 'active'; }?>"><a href="{{url('user/my-shipping')}}">My Shipping</a></li>
							<li id="item-4" class="item <?php if($url=='user/rewards'){ echo 'active'; }?>"><a href="{{url('user/rewards')}}">Rewards</a></li>
							<li id="item-4" class="item <?php if($url=='user/change-password'){ echo 'active'; }?>"><a href="{{url('user/change-password')}}">Change Password</a></li>
					</ul>
				</div>

				<div class="col-md-3 box-left hidden-xs" >
						<?php
						$memberid=Session::get('memberid');
						$row=DB::table('ms_members')->where('member_id','=',$memberid)->first();
						$level=DB::table('ms_disc_level')->where('disc_level_id','=',$row->member_level)->first();
						?>
						<?php if($row->member_image == null){?>
								<img class="img-responsive" id="viewimg" src="{{ asset('assets/img/ava.png') }}" alt="">
							<?php }else{?>
								<img class="img-responsive" id="viewimg" src="{{ asset('assets/img-member/'.$memberid.'/'.$row->member_image) }}" alt="">
							<?php }?>

								<h3 style="text-align:center;"><?php echo $row->member_fullname;?></h3>
								<ul class="list-unstyled user_data">
								@if(count($level) >0)
								<li class="m-top-xs" style="margin-bottom: 10px;">
									@if($level->level_name=='Silver')
									<img src="{{asset('assets/icon/silver.png')}}"style="width:25px;">
									<b style="color:#C0C0C0">{{$level->level_name}}</b>
									@elseif($level->level_name=='Gold')
									<img src="{{asset('assets/icon/gold.png')}}"style="width:25px;">
									<b style="color:#ea9b1e">{{$level->level_name}}</b>
									@endif
								</li>
								@endif

								<li class="m-top-xs" >
									<img src="{{asset('assets/icon/points.png')}}"style="width:25px;">
									<span style="color:#f4bf00"> {{$row->member_points}} Points </span>
								</li>
							</ul>
							<br>

							<ul id="menu-simple-menu" class="side-nav-bar accordion-menu ">
								<li id="item-2" class="item  <?php if($url=='user/profile'){ echo 'active'; }?> "><a href="{{url('user/profile')}}">My Account</a></li>
								<li id="item-1" class="item  <?php if($url=='user/order'){ echo 'active'; }?>"><a href="{{url('user/order')}}">Order</a></li>
								<!-- <li id="item-4" class="item"><a href="#">Transfer Confirmation</a></li> -->
								<li id="item-2" class="item <?php if($url=='user/wishlist'){ echo 'active'; }?>"><a href="{{url('user/wishlist')}}">Wishlist</a></li>
								<li id="item-3" class="item <?php if($url=='user/my-shipping'){ echo 'active'; }?>"><a href="{{url('user/my-shipping')}}">My Shipping</a></li>
								<li id="item-4" class="item <?php if($url=='user/rewards'){ echo 'active'; }?>"><a href="{{url('user/rewards')}}">Rewards</a></li>
								<li id="item-4" class="item <?php if($url=='user/change-password'){ echo 'active'; }?>"><a href="{{url('user/change-password')}}">Change Password</a></li>
							</ul>
					</div>
		@yield('isi')
		</div>

<script>
(function( $ ){

	$.fn.bounceClasses = function( _class, replace, callback ){
		var $target = $(this);
		if( !$target.hasClass( _class ) ){
			var tmp = _class;
			_class = replace;
			replace = tmp;
		}

		$target
			.removeClass( _class )
			.addClass( replace );

		//Run a callback
		if( callback !== undefined ){
			callback( $(this), replace, _class );
		}
	};


    $.fn.XtndAccordion = function(){
    	//get all submenu elements
        var that = this;
        	$accordion = this.find( '.submenu' );

        //Object MenuStatus
        var menuStatus = {
        		"store" : function( $icon, currentClass, toggleClass ){
    	        			$menu = $icon.parent( '.submenu' );
    	                	if( typeof( Storage ) !== undefined ){
    	                		if( currentClass == 'minus' ){
    	                			localStorage.setItem( $menu.attr( 'id'), 'closed');
    	                		} else {
    	                			localStorage.setItem( $menu.attr( 'id'), 'closed');
    	                		}
    	                	}
        				},
        		"check" : function(){
        						var $menuLink = $accordion;
        						if( typeof( Storage ) !== undefined ){
        							$menuLink.each( function( counter, element ){
    	    							if( localStorage.getItem( $( element ).attr( 'id' ) ) !== null ){
    	    								var menuStatus = localStorage.getItem( $( element ).attr( 'id' ) );
    	    								if( menuStatus === 'close' ){
    	    									$( element ).children( '.icon' ).trigger( 'click' );
    	    								}
    	    							}
    	    						});
        						}
        					}
        };

        $.fn.closeSiblings = function ( callback ){
        	$that = $( this );

        	//Add not-close class to current menu, for query destinction
        	$that
        		.addClass( 'not-close')
        		.parents( 'ul' )
        		.addClass( 'not-close');

        	//Choose the othe menus
        	$otherMenus = $( that ).find( '.submenu + ul:not(.not-close)' );

        	//Close every menu is open
        	$otherMenus.each( function( counter, menu ){
        		var $menu = $( menu );
        			// $icon = $menu.prev( '.submenu' ).children( '.icon');

        		//if menu is open ( :visible ), close it
        		if( $menu.is( ':visible') ){
        			$icon.bounceClasses( 'add', 'minus', menuStatus.store );
        			$menu.slideToggle( 300 );
        		}

        		//if there is a callback run it
        		if( functionExists( callback ) ){
        			callback( $that, $menu, $icon);
        		}

        	});

        	//Remove temporary class
        	$that
	    		.removeClass( 'not-close')
	    		.parents( 'ul' )
	    		.removeClass( 'not-close');

    	};


        //if there are submenu elements, attach the event listener
        if( $accordion && $accordion.length > 0){
            $accordion.children( '.icon' ).on( 'click', ToggleSubMenu );
            $accordion.children( '.submenu > a' ).on( 'click', ToggleSubMenu );
        }

        function ToggleSubMenu( evt ){
            var $submenu = $(this).parent( '.submenu' ).next( 'ul'),
            	$target = $( this );

            if( $( this )[0].nodeName === 'A' ){
                // $target = $( this ).parent( '.submenu' ).child( '.icon' );
            }
            $target.bounceClasses( 'add', 'minus', menuStatus.store );

            $submenu.closeSiblings();
            $submenu.slideToggle( 300 );
        }

        function functionExists( functionName){
        	return ( functionName !== undefined ) && ( typeof( functionName ) === "function" );
        }

        menuStatus.check();
    };
})( jQuery );

;( function( $ ){
  //Run functions with the need of jquery support
	$( document ).ready(
			function(){
				$( '.accordion-menu' ).XtndAccordion();
			}
	);
})(jQuery);
</script>
@endsection
