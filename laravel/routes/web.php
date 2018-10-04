<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// WEB START ===================================================================

Auth::routes();

// HOME
Route::get('/','Web\HomeController@index');

Route::get('thankyou/{id}','Web\HomeController@thankyou');

// PRODUCT
Route::get('products','Web\ProductController@index');
Route::post('ajax/getproduct','Web\ProductController@getproduct');
Route::get('products/{url}','Web\ProductController@detail');

// ABOUT
Route::get('about','Web\AboutController@index');

// GALLERY
Route::get('gallery','Web\GalleryController@index');

// MODULE setting
Route::post('module/get-gallery','Web\ModuleSettingController@getgallery');

// BLOG
Route::get('blog','Web\BlogController@index');
Route::get('blog/{url}','Web\BlogController@detail');

// CONTACT
Route::get('contact','Web\ContactController@contactform');
Route::post('contact','Web\ContactController@contactpost');

// MEMBER
Route::get('user/login','Web\UserController@login');
Route::post('user/login','Web\UserController@dologin');
Route::post('user/register','Web\UserController@doregister');
Route::get('user/activation/{code}','Web\UserController@activation');

// PAGES
Route::get('page/{url}','Web\PagesController@getpage');

// CHECKOUT
Route::get('/checkout/finish/{id}','Web\CheckoutController@checkoutfinish');

// CHECK ORDER
Route::post('ajax/check/order','Web\CheckOrderController@getorder');

// MIDTRANS
Route::get('/snap', 'Midtrans\SnapController@snap');
Route::get('/snaptoken', 'Midtrans\SnapController@token');
Route::post('/snapfinish', 'Midtrans\SnapController@finish');

// CART
Route::post('ajax/addcart','Web\CartController@addcart');
Route::post('ajax/updaterow','Web\CartController@updaterow');
Route::post('ajax/removerow','Web\CartController@removerow');

// VOUCHER
Route::post('ajax/voucher','Web\CartController@checkvoucher');
Route::post('voucher/remove','Web\CartController@removevoucher');

Route::group(['middleware' => 'member'], function () {

    // CONFIRM PAYMENT
    Route::get('confirm-payment/{id}', 'Web\PaymentController@index');

    // ORDER PAYMENT
    Route::get('user/order/payment-confirmation/{id}', 'UserOrderController@paymentconfir');
    Route::post('user/order/payment-confirmation', 'UserOrderController@postpaymentconfir');

    // USER
    Route::get('user/profile','Web\UserController@profile');
    Route::post('user/profile/update','Web\UserController@profileupdate');
    Route::post('user/password/update','Web\UserController@passupdate');
    Route::post('user/order/detail','Web\UserController@orderdetail');
    Route::get('user/order/cancel/{id}','Web\UserController@ordercancel');
    Route::get('user/order/payment/{id}','Web\UserController@orderpayment');

    Route::get('user/logout','Web\UserController@dologout');

    // ADD ADDRESS
    Route::post('user/ajax/insertaddress','Web\UserController@insertaddress');
    Route::post('user/ajax/editaddress','Web\UserController@editaddress');
    Route::post('user/ajax/deleteaddress','Web\UserController@deleteaddress');

    // USER ORDER
    Route::get('user/order', 'UserOrderController@getorder');
    Route::get('user/order/detail/{id}', 'UserOrderController@orderdetail');

    // CART
    Route::get('cart','Web\CartController@index');
    Route::post('cart/getaddr','Web\CartController@getaddr');
    Route::post('shipping/gotocheckout','Web\CartController@gotocheckout');

    // CHECKOUT
    Route::get('checkout','Web\CheckoutController@index');
    Route::post('checkout','Web\CheckoutController@store');

    // SHIPPING
    Route::post('shipping/country','Web\ShippingController@shippingcountry');
    Route::post('shipping/province','Web\ShippingController@shippingprovince');
    Route::post('shipping/city','Web\ShippingController@shippingcity');
    Route::post('shipping/district','Web\ShippingController@shippingdistrict');
    Route::post('shipping/courier','Web\ShippingController@shippingcourier');
    Route::post('shipping/cost','Web\ShippingController@shippingcost');

});

// WEB END =====================================================================

// ADMIN START==================================================================
Route::group(['middleware' => 'admin'], function () {

    // THEMES
    Route::get('backend/themes-setting','Backend\ThemeController@setting');
    Route::get('backend/themes-setting/active/{id}','Backend\ThemeController@active');
    Route::post('backend/themes-setting/uninstall/{id}','Backend\ThemeController@uninstall');

    // MODULE
    Route::resource('backend/themes-module','Backend\ModuleController');

    // PAGES
    Route::resource('backend/themes-pages','Backend\PagesController');
    Route::get('backend/themespages/addmodule/{rowid}','Backend\PagesController@addmodule');
    Route::post('backend/themespages/getsubmodule','Backend\PagesController@getsubmod');

    Route::post('backend/menu/updaterow','Backend\MenuFrontendController@updtrow');

    Route::resource('backend/banner','Backend\CmsBannerController');
    Route::resource('backend/gallery','Backend\CmsGalleryController');
    Route::resource('backend/contact','Backend\CmsContactController');
    Route::resource('backend/subscribers','Backend\SubscribersController');
    Route::resource('backend/shipping','Backend\ShippingController');

    Route::get('/backend/module-opt/{module}','Backend\ModuleOptionController@index');
    Route::post('/backend/module-opt/{module}','Backend\ModuleOptionController@update');

    // ADD CATEGORY IN PRODUCT
    Route::post('backend/addcategory-inproduct','Backend\ProductsController@addcategory');

    // JURNAL CONFIG
    Route::get('backend/jurnal-intro','Backend\JurnalController@intro');
    Route::get('backend/jurnal-access','Backend\JurnalController@access');
    Route::post('backend/jurnal-access','Backend\JurnalController@updatetoken');

    // STOCK
    Route::get('backend/product-best-seller','Backend\InventoryStockController@bestseller');
    Route::get('backend/product-low-stock','Backend\InventoryStockController@lowstock');
    Route::get('backend/product-sold-out','Backend\InventoryStockController@soldout');
});
// ADMIN END====================================================================

Route::post('subscriberstore', 'HomeController@subscriberstore');
Route::get('brand','HomeController@getBrand');

/*
Midtrans
*/
Route::get('/vtweb', 'Midtrans\VtwebController@vtweb');
Route::get('/payment/finish', 'CheckoutController@finish');
Route::get('/payment/unfinish', 'CheckoutController@unfinish');
Route::get('/payment/make-payment/{id}', 'CheckoutController@makepayment');
Route::get('/payment/error', 'CheckoutController@error');
Route::post('/notification/handling', 'Midtrans\VtwebController@notification');

//
// Route::get('/vtdirect', 'Midtrans\VtwebController@vtdirect');
// Route::post('/vtdirect', 'Midtrans\VtwebController@checkout_process');
//
// Route::get('/vt_transaction', 'Midtrans\VtwebController@transaction');
// Route::post('/vt_transaction', 'Midtrans\VtwebController@transaction_process');

/*
Socialite Page
*/

Route::get ( '/redirect/{service}', 'SocialAuthController@redirect' );
Route::get ( '/callback/{service}', 'SocialAuthController@callback' );
/*
frontend product
*/

Route::get('brand/{url}','ProductController@getproductbrand');
Route::get('brand/{url}/{categurl}','ProductController@getproductbrandcateg');

Route::get('ajax/gettotal','ProductController@ajaxgettotal');
Route::get('product-detail/{url}','ProductController@getproductdetail');


/*
frontend product Ajax
*/
Route::post('ajax/sortProduct','AjaxProductController@sortProduct');
Route::get('ajax/getvariancolor','AjaxProductController@getvariancolor');
// Route::get('ajax/ScrollingProduct/{key}','AjaxProductController@ScrollingProduct');

/*
frontend Cart
*/
Route::get('shopping-cart','AddcartController@getCart');
Route::post('/updtqty','AddcartController@updtqty');
Route::post('postcartvar','AddcartController@postCartVarian');
Route::post('postcartprod','AddcartController@postCartProduct');

Route::get('delete-cart/{cartid}','AddcartController@delcart');
Route::get('product/delete-cart/{cartid}','AddcartController@delcart');
Route::get('user/delete-cart/{cartid}','AddcartController@delcart');
/*
frontend Cart Ajax
*/
Route::post('ajax/getqty','AddcartController@ajaxupdateqty');
Route::post('ajax/ajaxgetmodal', 'AjaxController@getmodal');

/*
frontend Page
*/



/*
frontend Blog
*/
// Route::get('blog','BlogController@getblog');
// Route::get('blog/{kateg}/{url}','BlogController@getblogdetail');
// Route::get('blog/{urlkateg}','BlogController@getblogCategory');
// Route::get('blog/tags/list/{url}','BlogController@getblogTags');

/*
frontend Checkout
*/
Route::post('ajax/shipaddr', 'AjaxShipController@shipchange');
Route::post('ajax/pickaddr', 'AjaxShipController@pickchange');
Route::get('ajax/checkPickup', 'AjaxShipController@checkPickup');


Route::post('ajax/shippingprovince2/{id}','AjaxShipController@shippingprovince');
Route::post('ajax/shippingcity2/{id}','AjaxShipController@shippingcity');
Route::post('ajax/shippingsubdistrict2/{id}','AjaxShipController@shippingsubdistrict');

Route::get('ajax/checkout/gettotal','AjaxCheckoutController@gettotal');
Route::get('ajax/checkout/getVoucher','AjaxCheckoutController@getvoucher');
Route::get('ajax/checkout/getmethodCart','AjaxCheckoutController@getmethodcart');
Route::get('ajax/checkout/getmethodBank','AjaxCheckoutController@getmethodBank');
Route::get('ajax/checkout/forgetdata','AjaxCheckoutController@forgetdata');
Route::get('ajax/cart/getBonus','AjaxCheckoutController@getBonus');

/*
Member Wishlist
*/
Route::get('wishlist/{id}', 'UserWishlistController@storewishlist');
Route::get('user/wishlist', 'UserWishlistController@wishlist');
Route::get('user/wishlist/{id}', 'UserWishlistController@destroy');
/*
Member Page
*/
Route::post('user/forgot-password', 'UserController@forgotPassword');
Route::get('user/reset-password/{code}', 'UserController@resetPassword');
Route::post('user/new-password/{code}', 'UserController@newPassword');

Route::get('user/change-password', 'UserController@changepassword');
Route::post('user/change-password', 'UserController@dochangepassword');
Route::post('user/updateprofile', 'UserController@doupdateprofile');
Route::get('user/editshipping/{id}', 'UserController@getaddress');
Route::post('user/updateshipping', 'UserController@doUpdateShipping');
Route::get('user/my-shipping', 'UserController@getShipping');
Route::get('user/my-shipping/delete/{id}', 'UserController@deleteShipping');
Route::get('user/addshipping', 'UserController@getFormAddress');
Route::post('user/addshipping', 'UserController@doAddShipping');
Route::get('user/rewards', 'UserRewardController@getrewards');
/*
member Order
*/
Route::get('user/order', 'UserOrderController@getorder');
Route::get('user/order/detail/{id}', 'UserOrderController@orderdetail');
// Route::get('user/order/payment-confirmation/{id}', 'UserOrderController@paymentconfir');
// Route::post('user/order/payment-confirmation/{id}', 'UserOrderController@postpaymentconfir');

/*
Vendor
*/
Route::get('vendor/login', 'VendorController@login');
Route::post('vendor/login', 'VendorController@dologin');
Route::get('vendor/profile', 'VendorController@profile');
Route::get('vendor/logout', 'VendorController@dologout');
Route::post('vendor/updateprofile', 'VendorController@doupdateprofile');
Route::get('vendor/change-password', 'VendorController@changepassword');
Route::post('vendor/change-password', 'VendorController@dochangepassword');

Route::post('vendor/forgot-password', 'VendorController@forgotPassword');
Route::get('vendor/reset-password/{code}', 'VendorController@resetPassword');
Route::post('vendor/new-password/{code}', 'VendorController@newPassword');

/*
Vendor product
*/
Route::resource('vendor/product','VendorProductsController');
Route::get('vendor/product-image/delete/{imgid}','VendorProductsController@deleteprodutimage');
Route::get('vendor/product-varian/delete/{varid}','VendorProductsController@deleteprodutvarian');
Route::get('vendor/ajax/generatecode','VendorProductsController@generateCode');
/*
Backend Login
*/

Route::get('backend/login','Auth\LoginController@showLoginForm');
Route::post('backend/login', 'Auth\LoginController@login');
Route::get('backend/logout', 'Auth\LoginController@logout');

/*
Backend dashboard
*/
Route::get('backend', function () {
    return Redirect('backend/dashboard');
});

Route::get('backend/dashboard','Backend\DashboardController@index');

/*
Banckend product Category
*/
Route::resource('backend/product-category','Backend\ProductCategoryController');

/*
Banckend Brand
*/
Route::resource('backend/brand','Backend\BrandController');

/*
Banckend product
*/
Route::resource('backend/product','Backend\ProductsController');
Route::get('backend/product-image/delete/{imgid}','Backend\ProductsController@deleteprodutimage');
Route::get('backend/product-varian/delete/{varid}','Backend\ProductsController@deleteprodutvarian');

/*
Banckend product ajax
*/
Route::get('backend/ajax/generatecode','Backend\ProductsController@generateCode');
/*
Banckend product Stock
*/
Route::get('backend/product-stock/show/{id}','Backend\ProductStockController@edit');
Route::get('backend/ajax/change-stock','Backend\ProductStockController@updatestockvarian');
Route::post('backend/product-stock/update','Backend\ProductStockController@updatestockprod');
/*
/*
Banckend Order
*/
Route::get('backend/recent-order/new', 'Backend\OrderController@getordernew');
Route::get('backend/recent-order/canceled', 'Backend\OrderController@getordercancel');
Route::get('backend/recent-order/processing', 'Backend\OrderController@getorderprocessing');
Route::get('backend/recent-order/ready', 'Backend\OrderController@getorderready');
Route::get('backend/recent-order/in-delivery', 'Backend\OrderController@getorderdelivery');
Route::get('backend/recent-order/completed', 'Backend\OrderController@getordercompleted');

Route::get('backend/recent-order/waiting-payment', 'Backend\OrderController@getwaiting');
Route::get('backend/recent-order/confirm-payment', 'Backend\OrderController@getconfirm');
Route::get('backend/recent-order/accepted-payment', 'Backend\OrderController@getaccepted');
Route::get('backend/recent-order/failed-payment', 'Backend\OrderController@getfailed');
Route::get('backend/recent-order/waiting', 'Backend\OrderController@getwaiting');
Route::resource('backend/recent-order','Backend\OrderController');
Route::get('backend/recent-order/show/{id}','Backend\OrderController@show');

Route::get('backend/report-order','Backend\OrderController@report');
Route::post('backend/report-order/print','Backend\OrderController@reportprint');

Route::get('backend/history-order','Backend\OrderController@history');
Route::post('backend/history-order/{id}','Backend\OrderController@historydel');
Route::get('backend/history-order/show/{id}','Backend\OrderController@historyshow');
Route::get('backend/order/confirm-payment/{id}','Backend\OrderController@paymentconfir');
Route::get('backend/order/cancel-payment/{id}','Backend\OrderController@paymentcancel');
// Route::resource('backend/history-order','Backend\OrderController');



/*
Banckend Cusmtomer List
*/
Route::get('backend/customer-list','Backend\MemberController@index');
Route::get('backend/customer-list/edit/{id}','Backend\MemberController@edit');
Route::post('backend/customer-list/update','Backend\MemberController@update');
Route::get('backend/customer-list/{id}','Backend\MemberController@destroy');

/*
Banckend Cusmtomer Group
*/
Route::get('backend/customer-group','Backend\CustomerGroupController@index');
Route::get('backend/customer-group/edit/{id}','Backend\CustomerGroupController@edit');
Route::post('backend/customer-group/update','Backend\CustomerGroupController@update');
Route::get('backend/customer-group/{id}','Backend\CustomerGroupController@destroy');
Route::post('ajax/getmemberlevel','Backend\CustomerGroupController@ajaxmemberlevel');

/*
Banckend Cusmtomer Service
*/
Route::get('backend/customer-service','Backend\CustomerServiceController@index');
Route::post('ajax/changecheck','Backend\CustomerServiceController@changecheck');
Route::post('ajax/changeall','Backend\CustomerServiceController@changeall');
Route::post('ajax/changecheck/sub','Backend\CustomerServiceController@subchangecheck');
Route::post('ajax/changeall/sub','Backend\CustomerServiceController@subchangeall');
Route::post('backend/customer-service/store','Backend\CustomerServiceController@store');

/*
Banckend Cms slider / Preferences
*/
Route::resource('backend/slider','Backend\CmsSliderController');
/*
Banckend Cms Page / Preferences
*/

Route::get('backend/page','Backend\CmsPageController@index');
Route::get('backend/page/create','Backend\CmsPageController@create');
Route::get('backend/page/edit/{id}','Backend\CmsPageController@edit');
Route::post('backend/page/update','Backend\CmsPageController@update');
Route::post('backend/page/store','Backend\CmsPageController@store');
Route::get('backend/page/delete/{id}','Backend\CmsPageController@destroy');
Route::resource('backend/page-category','Backend\CmsPageCategoryController');

/*
Banckend Cms Blog
*/
Route::resource('backend/content','Backend\CmsBlogController');
Route::resource('backend/content-category','Backend\BlogCategoryController');

/*
Banckend Cms config
*/

Route::get('backend/site-config','Backend\CmsConfigController@edit');
Route::post('backend/site-config/updatecontact','Backend\CmsConfigController@updatecontact');
Route::post('backend/site-config/updatesite','Backend\CmsConfigController@updatesite');
/*
Backend Inventoryin
*/

Route::get('backend/inventory/in','Backend\InventoryinController@index');
Route::get('backend/inventory/in/create','Backend\InventoryinController@create');
Route::post('backend/inventory/in/store','Backend\InventoryinController@store');
Route::post('backend/inventory/in/product','Backend\InventoryinController@newproduct');
Route::post('backend/inventory/in/addtocart','Backend\InventoryinController@addtocart');
Route::get('backend/inventory/in/edit/{id}','Backend\InventoryinController@edit');
Route::post('backend/inventory/in/deletecart','Backend\InventoryinController@deletecart');
Route::post('backend/inventory/in/update','Backend\InventoryinController@update');
Route::get('backend/inventory/in/{id}', 'Backend\InventoryinController@destroy');
Route::get('backend/inventory/report/in', 'Backend\InventoryReportController@inventoryin');
Route::get('backend/inventory/report/out', 'Backend\InventoryReportController@inventoryout');
Route::post('backend/inventory/in/productstore','Backend\InventoryinController@NewProductstore');





Route::get('backend/ajax/getvariansize', 'Backend\InventoryinController@getvariansize');
Route::get('backend/ajax/getvariancolor', 'Backend\InventoryinController@getvariancolor');
Route::post('backend/ajax/publicstock', 'Backend\InventoryinController@publicstock');


/*
Backend Inventoryout
*/

Route::get('backend/inventory/out','Backend\InventoryoutController@index');
Route::get('backend/inventory/out/create','Backend\InventoryoutController@create');
Route::post('backend/inventory/out/store','Backend\InventoryoutController@store');
Route::post('backend/inventory/out/product','Backend\InventoryoutController@newproduct');
Route::post('backend/inventory/out/addtocart','Backend\InventoryoutController@addtocart');
Route::get('backend/inventory/out/edit/{id}','Backend\InventoryoutController@edit');
Route::post('backend/inventory/out/deletecart','Backend\InventoryoutController@deletecart');
Route::post('backend/inventory/out/update','Backend\InventoryoutController@update');
Route::get('backend/inventory/out/{id}', 'Backend\InventoryoutController@destroy');

Route::get('backend/ajax/out/getvariansize', 'Backend\InventoryoutController@getvariansize');
Route::get('backend/ajax/out/getvariancolor', 'Backend\InventoryoutController@getvariancolor');
Route::get('backend/ajax/out/getprodstock', 'Backend\InventoryoutController@getprodstock');


/*
Backend Inventory stock
*/

Route::get('backend/inventory/stock','Backend\InventoryStockController@index');
Route::get('backend/inventory/stock/{id}', 'Backend\InventoryStockController@destroy');


/*
Banckend Discount
*/
Route::resource('backend/discount','Backend\DiscountController');

/*
Banckend Discount
*/
Route::resource('backend/voucher','Backend\VoucherController');
Route::get('backend/voucher-log','Backend\VoucherController@voucherlog');

/*
Banckend Bonus
*/
Route::get('backend/setting/bonus','Backend\BonusController@settingbonus');
Route::post('backend/setting/bonus-post','Backend\BonusController@settingpost');
Route::resource('backend/bonus','Backend\BonusController');

/*
Banckend Discount Level
*/
Route::resource('backend/discount-level','Backend\DiscountLevelController');
/*
Banckend Frontend Menu
*/
Route::resource('backend/frontend-menu','Backend\MenuFrontendController');
/*
/*
Banckend Backend Menu
*/
Route::resource('backend/backend-menu','Backend\MenuBackendController');
/*
|--------------------------------------------------------------------------
| Banckend  | Vendor Page
|--------------------------------------------------------------------------
*/
Route::resource('backend/vendor', 'Backend\VendorController');

/*
|--------------------------------------------------------------------------
| Banckend  | Users Page
|--------------------------------------------------------------------------
*/
Route::resource('backend/users', 'Backend\UsersController');
Route::get('backend/change-password', 'Backend\UsersController@changepassword');
Route::post('backend/change-password','Backend\UsersController@storechangepassword');
Route::get('backend/myprofile','Backend\UsersController@getprofile');
Route::post('backend/myprofile','Backend\UsersController@updateprofile');
/*
Banckend Backend Menu
*/

Route::get('backend/user-access/auth/{access_id}','Backend\AuthController@auth');
Route::post('backend/user-access/auth','Backend\AuthController@authUpdate');

Route::resource('backend/user-access','Backend\UserAccessController');
/*
Banckend Bank
*/
Route::resource('backend/bank','Backend\BankController');

/*
Social media
*/
Route::resource('backend/social-media','Backend\SocialMediaController');
/*
Banckend Pickup Point
*/
Route::get('backend/pickup-point/delete/{id}', 'Backend\PickupController@deletePoint');

Route::resource('backend/pickup-point','Backend\PickupController');




//*********************Web ajax Shipping************************************//
Route::post('ajax/shippingprovince','AjaxController@shippingprovince');
Route::post('ajax/shippingcity','AjaxController@shippingcity');
Route::post('ajax/shippingcost','AjaxController@shippingcost');
Route::post('ajax/shippingsubdistrict', 'AjaxController@shippingsubdistrict');
Route::post('ajax/shippingongkir','AjaxController@shippingongkir');


//*********************Web ajax Billing************************************//
Route::post('ajax/bilingprovince','AjaxBilingController@bilingprovince');
Route::post('ajax/bilingcity','AjaxBilingController@bilingcity');
Route::post('ajax/bilingsubdistrict', 'AjaxBilingController@bilingsubdistrict');


//********************* Jurnal.id ************************************//
/*    // Product
    Route::post('jurnal/product/adddata','Web\JurnalController@productAddData');
    Route::post('jurnal/products/adddata','Web\JurnalController@productAddDataMany');
    Route::post('jurnal/product/upddata','Web\JurnalController@productUpdData');
    Route::post('jurnal/product/search','Web\JurnalController@productSearch');

    // Categories
    Route::post('jurnal/categories/adddata','Web\JurnalController@categoriesAddData');

    // Customer
    Route::post('jurnal/customer/adddata','Web\JurnalController@customerAddData');

    // Sales Invoice
    Route::post('jurnal/sales_inv/adddata','Web\JurnalController@salinvAddData');*/
