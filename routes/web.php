<?php

use App\Http\Controllers\CleaningServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SubscriberEmailController;

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

// Route::get('/', function () {
//     //broadcast(new DemoEvent('karthik'));
//     return view('welcome');
// });

Route::get('/clear', 'App\Http\Controllers\admin\LoginController@clear')->name('clear');
Route::get('/set-language', function (\Illuminate\Http\Request $request) {
    if ($request->has('lang')) {
        
        session(['locale' => $request->get('lang')]);
        App::setLocale($request->get('lang'));
    }
   
    return response()->json(['status' => 1]);
})->name('set.language');
Route::get('/reset_password_auth', 'App\Http\Controllers\AjaxContoller@reset_password');
Route::get('/reset_password_auth/{id}', 'App\Http\Controllers\AjaxContoller@reset_password');
Route::post('/submit_reset_request', 'App\Http\Controllers\AjaxContoller@submit_reset_request')->name('submit_reset_request');
Route::get('/submited_reset_request', 'App\Http\Controllers\AjaxContoller@submit_reseted_request')->name('submited_reset_request');
Route::get('/', 'App\Http\Controllers\front\HomeController@index')->name('home');
Route::get('/contactus', 'App\Http\Controllers\front\HomeController@contactus')->name('contactus');
Route::post('/follow-vendor','App\Http\Controllers\front\HomeController@followVendor')->name('followvendor');
Route::post('/sendmessage-vendor','App\Http\Controllers\front\HomeController@sendMessage')->name('sendmessagevendor');
Route::post('/report-vendor', 'App\Http\Controllers\front\HomeController@reportVendor')->name('reportvendor');
Route::get('/privacy-policy', 'App\Http\Controllers\front\HomeController@privacypolicy')->name('privacy-policy');
Route::get('/terms-and-condition', 'App\Http\Controllers\front\HomeController@termsandconditions')->name('terms-and-condition');

Route::get('/seller-policy', 'App\Http\Controllers\front\HomeController@sellerpolicy')->name('seller-policy');
Route::get('/handwi-payment-policy', 'App\Http\Controllers\front\HomeController@handwipaymentpolicy')->name('handwi-payment-policy');

Route::get('/about-us', 'App\Http\Controllers\front\HomeController@aboutus')->name('about-us');
Route::get('/contactus', 'App\Http\Controllers\front\HomeController@contactus')->name('contactus');
Route::post('/contactusstore', 'App\Http\Controllers\front\HomeController@contactusstore')->name('contactusstore');
Route::get('/faq', 'App\Http\Controllers\front\HomeController@faqs')->name('faq');
Route::post('/addtocart', 'App\Http\Controllers\front\CartController@addToCart')->name('addtocart');
// Route::post('/personalization', 'App\Http\Controllers\front\CartController@storePersonalization')->name('personalization');
// Route::post('/getpersonalization', 'App\Http\Controllers\front\CartController@getPersonalization')->name('getpersonalization');


Route::post('/personalization','App\Http\Controllers\front\CartController@storePersonalization')->name('personalization');
Route::post('/get-personalization','App\Http\Controllers\front\CartController@getPersonalization')->name('getpersonalization');
Route::post('/update-personalization','App\Http\Controllers\front\CartController@updatePersonalization')->name('updatepersonalization');
Route::post('/delete-personalization','App\Http\Controllers\front\CartController@deletePersonalization')->name('deletepersonalization');



Route::post('/subscribeemail', 'App\Http\Controllers\front\HomeController@subscribe')->name('subscribeemail');
Route::get('/getcart', 'App\Http\Controllers\front\CartController@getCart')->name('getcart');
Route::get('/cartpage', 'App\Http\Controllers\front\CartController@cartpage')->name('cart');
Route::get('/checkout', 'App\Http\Controllers\front\CheckoutController@index')->name('checkout');
Route::post('/placeorder', 'App\Http\Controllers\front\CheckoutController@placeOrder')->name('placeorder');
Route::get('/thankyou', 'App\Http\Controllers\front\CheckoutController@success')->name('thankyou');


Route::post('/cartupdatequantity', 'App\Http\Controllers\front\CartController@updateQuantity')->name('cartupdatequantity');
Route::post('/cartclear', 'App\Http\Controllers\front\CartController@clearCart')->name('cartclear');

Route::post('/addtowishlist', 'App\Http\Controllers\front\CartController@addwishlist')->name('addtowishlist');
Route::post('/removewishlist', 'App\Http\Controllers\front\CartController@deletewishlist')->name('removewishlist');
Route::post('/removecartitem', 'App\Http\Controllers\front\CartController@removeItem')->name('removecartitem');
Route::get('/category/{id}/products', 'App\Http\Controllers\front\ProductCategoryController@getProductsByCategory')->name('categoryproducts');
Route::get('/gifts', 'App\Http\Controllers\front\ProductCategoryController@giftCategories')->name('gifts');
Route::get('/productssearch', 'App\Http\Controllers\front\ProductCategoryController@searchProducts')->name('productssearch');
Route::get('/productsuggestions', 'App\Http\Controllers\front\ProductCategoryController@getProductSuggestions')->name('productsuggestions');
Route::get('/professionals', 'App\Http\Controllers\front\ProductCategoryController@handmadeCategories')->name('professionals');

Route::get('/workshops', 'App\Http\Controllers\front\ProductCategoryController@services')->name('workshops');
Route::get('/workshop/{id}', 'App\Http\Controllers\front\ProductCategoryController@workshopDetail')->name('workshopdetail');
Route::get('/workshopbooking/{id}', 'App\Http\Controllers\front\BookingWorkshopController@index')->name('workshopbooking');
Route::post('/worshopcheckoutpage', 'App\Http\Controllers\front\BookingWorkshopController@checkoutpage')->name('worshopcheckoutpage');

Route::get('/workshoppaymentsuccess', 'App\Http\Controllers\front\BookingWorkshopController@paymentSuccess')->name('workshoppaymentsuccess');


// Add this route to handle product details
Route::post('/add-reviews','App\Http\Controllers\front\ProductCategoryController@submitReview')->name('add-reviews');
Route::get('/product/{id}', 'App\Http\Controllers\front\ProductCategoryController@getProductDetails')->name('productdetails');
Route::get('/share/product/{id}/{variant_id}', 'App\Http\Controllers\front\ProductCategoryController@getProductDetails')->name('share.productdetails');
Route::get('/store/{id}', 'App\Http\Controllers\front\ProductCategoryController@storeDetails')->name('storedetails');

Route::post('/change-password','App\Http\Controllers\front\UserController@changePassword')->name('change-password');
Route::post('/update-profile','App\Http\Controllers\front\UserController@updateProfile')->name('update-profile');




// Route::get('/userdashboard/addresses/{id}/edit', 'App\Http\Controllers\front\UserController@edituseraddress')->name('addressesedit');
// Route::post('/userdashboard/addresses/{id}', 'App\Http\Controllers\front\UserController@updateuseraddress')->name('addressesupdate');


Route::get('/userdashboard/addresses/{id}/edit','App\Http\Controllers\front\UserController@edituseraddress')->name('addressesedit');
Route::post('/userdashboard/addresses/{id}','App\Http\Controllers\front\UserController@updateuseraddress')->name('addressesupdate');
Route::post('/userdashboard/addresses','App\Http\Controllers\front\UserController@storeuseraddress')->name('addressesstore');

Route::post('/userdashboard/addresses/{id}/make-default', 'App\Http\Controllers\front\UserController@makeDefaultAddress')->name('addressesmakeDefault');


Route::get('/login', 'App\Http\Controllers\front\UserController@showLoginForm')->name('login');
Route::get('/userdashboard', 'App\Http\Controllers\front\UserController@dashboard')->name('userdashboard');
Route::get("/order_details/{id}", 'App\Http\Controllers\front\UserController@orderDetails');
Route::get("/order_invoice/{id}", 'App\Http\Controllers\front\UserController@invoice');
Route::post('/login', 'App\Http\Controllers\front\UserController@login');
Route::get('/register', 'App\Http\Controllers\front\UserController@showRegisterForm')->name('register');
Route::post('/register', 'App\Http\Controllers\front\UserController@register');
Route::get('/logoutuser', 'App\Http\Controllers\front\UserController@logout')->name('logoutuser'); 



Route::get('/success', 'App\Http\Controllers\front\HomeController@success');
Route::get('/blogs', 'App\Http\Controllers\front\HomeController@blogs')->name('blogs');

Route::get('/blog-detail/{id}', 'App\Http\Controllers\front\HomeController@blog_detail')->name('blog-detail');

//Route::get('/blog-detail', 'App\Http\Controllers\front\HomeController@blog_detail')->name('blog-detail');

//Route::get('/register', 'App\Http\Controllers\front\HomeController@register');
Route::post('/save_vendor', 'App\Http\Controllers\front\HomeController@save_vendor');
Route::post("common/states/get_by_country", "App\Http\Controllers\admin\StatesController@get_by_country");
Route::post("common/cities/get_by_state", "App\Http\Controllers\admin\CitiesController@get_by_state");
Route::post('/getCountryToCity', 'App\Http\Controllers\front\HomeController@getCountryToCity')->name('getCountryToCity');
Route::get('/reset_password', 'App\Http\Controllers\front\HomeController@reset_password');
Route::get('/reset_password/{id}', 'App\Http\Controllers\front\HomeController@reset_password');
Route::post('/new_password', 'App\Http\Controllers\front\HomeController@new_password')->name('vendor.new_password');
Route::get("delete_request","App\Http\Controllers\DeleteRequestController@deleteRequest");
Route::post("delete_request_store","App\Http\Controllers\DeleteRequestController@deleteRequestStore");
Route::get("page/{id}","App\Http\Controllers\CmsController@page");
Route::post("/subscribe_email", "App\Http\Controllers\CmsController@subscribe_email")->name('subscribe_email');


//Auth::routes();

Route::get('/admin', 'App\Http\Controllers\admin\LoginController@login')->name('admin.login');
Route::post('admin/check_login', 'App\Http\Controllers\admin\LoginController@check_login')->name('admin.check_login');
Route::namespace('App\Http\Controllers\admin')->prefix('admin')->middleware('admin')->name('admin.')->group(function () {
    // Route::get('change-password', 'AdminController@changePassword')->name('change.password');
    // Route::post('change-password', 'AdminController@changePasswordSave')->name('change.password.save');
    Route::get('logout', 'LoginController@logout')->name('logout');
    Route::get('dashboard', 'DashboardController@dashboard')->name('dashboard');
    Route::get('home_section_list', 'HomeBannerSection@index')->name('home_section_list');
    Route::post('home_section_update', 'HomeBannerSection@updateOrder')->name('home_section_update');
    Route::post('home_section/change_status', 'HomeBannerSection@change_status')->name('home_section_change_status');
    Route::delete('home_section/delete/{id}', 'HomeBannerSection@destroy')->name('home_section_delete');


    Route::get('import_export', 'ProductImportExport@import_export')->name('import_export');
    Route::post('Excel/upload_file', 'ProductImportExport@upload_file')->name('upload_file');
    Route::get('start_import', 'ProductImportExport@start_import')->name('start_import');
    Route::post('Excel/upload_zip_file', 'ProductImportExport@upload_zip_file')->name('upload_zip_file');
    Route::post('Excel/startUnzipImage', 'ProductImportExport@startUnzipImage')->name('startUnzipImage');
    //uncommit me
    Route::post('Excel/export', 'ProductImportExport@export_product')->name('export_product');
    Route::get('Excel_export', 'ProductImportExport@export_product')->name('export_product_excel');

    //import product master
    Route::get('import_product_master', 'ProductMasterImport@importproductmaster');
    Route::get('download_masterproduct_format', 'ProductMasterImport@download_masterproduct_format')->name('product.download_masterproduct_format');
    Route::post('master_pd_upload_file', 'ProductMasterImport@master_pd_upload_file')->name('master_pd_upload_file');
    Route::get('start_master_import', 'ProductMasterImport@start_master_import')->name('start_master_import');






    Route::get('report/booking_workshops', 'ReportController@booking_workshop_report')->name('workshop_report');

    Route::get('report/customers', 'ReportController@users')->name('customer_report');
    Route::get('report/activities', 'ReportController@activities')->name('customer_activity_report');
    Route::get('report/maintenance_service', 'ReportController@contract_maintenance_report')->name('maintenance_service_report');
    Route::get('report/service_request', 'ReportController@service_request')->name('service_request_report');
    Route::get('report/vendors', 'ReportController@vendors')->name('vendor_report');
    Route::get('report/stores', 'ReportController@stores')->name('store_report');
    Route::get('report/orders', 'ReportController@orders')->name('order_report');
    Route::get('report/commission', 'ReportController@commission')->name('commission_report');
    Route::get('report/commission_service', 'ReportController@commission_services')->name('commission_service_report');
    //uncommit me
    Route::get('report/out_of_stock', 'ReportController@outofstock')->name('out_of_stock');
    Route::get('report/refund_request', 'ReportController@refund_request')->name('refund_request');
    Route::get('report/refund_request_services', 'ReportController@refund_request_services');
    Route::post('report/change_status_accepted', 'ReportController@change_status_accepted');
    Route::post('report/change_status_accepted_service', 'ReportController@change_status_accepted_service');


    Route::get("category", "Category@index");
    Route::get("category/create", "Category@create");
    Route::post("category/change_status", "Category@change_status");
    Route::get("category/edit/{id}", "Category@edit");
    Route::delete("category/delete/{id}", "Category@destroy");
    Route::post("save_category", "Category@store");
    Route::match(array('GET', 'POST'), 'category/sort', 'Category@sort');

    Route::get("maincategory", "MainCategory@index");
    Route::get("maincategory/create", "MainCategory@create");
    Route::post("maincategory/change_status", "MainCategory@change_status");
    Route::get("maincategory/edit/{id}", "MainCategory@edit");
    Route::delete("maincategory/delete/{id}", "MainCategory@destroy");
    Route::post("save_maincategory", "MainCategory@store");

    Route::post("get_categories_by_activity_id", "Category@get_categories_by_activity_id")->name('get_categories_by_activity_id');
    Route::post("get_service_categories_by_activity_id", "ServicesController@get_service_categories_by_activity_id")->name('get_service_categories_by_activity_id');
    

    Route::get("account_type", "AccountTypeController@index");
    Route::get("account_type/create", "AccountTypeController@create");
    Route::get("account_type/edit/{id}", "AccountTypeController@edit");
    Route::delete("account_type/delete/{id}", "AccountTypeController@destroy");
    Route::post("save_account_type", "AccountTypeController@store");
    Route::post("account_type/change_status", "AccountTypeController@change_status");
    Route::match(array('GET', 'POST'),"account_type/sort", "AccountTypeController@sort");
    
    Route::get("activity_type", "ActivityTypeController@index");
    Route::get("activity_type/create", "ActivityTypeController@create");
    Route::get("activity_type/edit/{id}", "ActivityTypeController@edit");
    Route::delete("activity_type/delete/{id}", "ActivityTypeController@destroy");
    Route::post("save_activity_type", "ActivityTypeController@store");
    Route::post("get_activities", "ActivityTypeController@get_activities")->name('get_activities');
    Route::post("activity_type/change_status", "ActivityTypeController@change_status");
    Route::match(array('GET', 'POST'),"activity_type/sort", "ActivityTypeController@sort");

    Route::get("cuisines", "CuisinesController@index");
    Route::get("cuisines/create", "CuisinesController@create");
    Route::get("cuisines/edit/{id}", "CuisinesController@edit");
    Route::delete("cuisines/delete/{id}", "CuisinesController@destroy");
    Route::post("save_cuisines", "CuisinesController@store");
    Route::post("get_cuisines", "CuisinesController@get_activities")->name('get_cuisines');
    Route::post("cuisines/change_status", "CuisinesController@change_status");
    Route::match(array('GET', 'POST'),"cuisines/sort", "CuisinesController@sort");

    
    Route::get("servicetype", "ServiceTypeController@index");
    Route::get("servicetype/create", "ServiceTypeController@create");
    Route::get("servicetype/edit/{id}", "ServiceTypeController@edit");
    Route::delete("servicetype/delete/{id}", "ServiceTypeController@destroy");
    Route::post("save_servicetype", "ServiceTypeController@store");
    Route::post("get_servicetype", "ServiceTypeController@get_activities")->name('get_servicetype');
    Route::post("servicetype/change_status", "ServiceTypeController@change_status");
    Route::match(array('GET', 'POST'),"servicetype/sort", "ServiceTypeController@sort");

    Route::get("service_category", "ServiceCategory@index");
    Route::get("service_category/create", "ServiceCategory@create");
    Route::post("service_category/change_status", "ServiceCategory@change_status");
    Route::get("service_category/edit/{id}", "ServiceCategory@edit");
    Route::delete("service_category/delete/{id}", "ServiceCategory@destroy");
    Route::post("save_service_category", "ServiceCategory@store");
    Route::match(array('GET', 'POST'), 'service_category/sort', 'ServiceCategory@sort');


    Route::get("product_features", "ProductFeatures@index");
    Route::get("product_feature/create", "ProductFeatures@create");
    Route::post("product_feature/change_status", "ProductFeatures@change_status");
    Route::get("product_feature/edit/{id}", "ProductFeatures@edit");
    Route::delete("product_feature/delete/{id}", "ProductFeatures@destroy");
    Route::post("save_product_feature", "ProductFeatures@store");
    Route::match(array('GET', 'POST'), 'product_feature/sort', 'ProductFeatures@sort');

    Route::get("event_features", "EventFeatures@index");
    Route::get("event_feature/create", "EventFeatures@create");
    Route::post("event_feature/change_status", "EventFeatures@change_status");
    Route::get("event_feature/edit/{id}", "EventFeatures@edit");
    Route::delete("event_feature/delete/{id}", "EventFeatures@destroy");
    Route::post("save_event_feature", "EventFeatures@store");
    Route::match(array('GET', 'POST'), 'event_feature/sort', 'EventFeatures@sort');


    Route::post("get_parants_activity", "ServiceCategory@get_parants_activity");

    Route::get("health_and_beauty_category", "HealthBeautyCategory@index");
    Route::get("health_and_beauty_category/create", "HealthBeautyCategory@create");
    Route::post("health_and_beauty_category/change_status", "HealthBeautyCategory@change_status");
    Route::get("health_and_beauty_category/edit/{id}", "HealthBeautyCategory@edit");
    Route::delete("health_and_beauty_category/delete/{id}", "HealthBeautyCategory@destroy");
    Route::post("save_health_and_beauty_category", "HealthBeautyCategory@store");

    Route::get("contract_maintenance", "ContractMaintenanceController@index");
    Route::get("contract_maintenance/create", "ContractMaintenanceController@create");
    Route::post("contract_maintenance/change_status", "ContractMaintenanceController@change_status");
    Route::get("contract_maintenance/edit/{id}/{name}", "ContractMaintenanceController@edit");
    Route::delete("contract_maintenance/delete/{id}", "ContractMaintenanceController@destroy");
    Route::post("save_contract_maintenance", "ContractMaintenanceController@store");

    // buidling typee
    Route::get("building_type", "BuildingTypeController@index");
    Route::get("building_type/create", "BuildingTypeController@create");
    Route::post("building_type/change_status", "BuildingTypeController@change_status");
    Route::get("building_type/edit/{id}", "BuildingTypeController@edit");
    Route::delete("building_type/delete/{id}", "BuildingTypeController@destroy");
    Route::post("save_building_type", "BuildingTypeController@store");

    Route::get("services", "ServicesController@index");
    Route::get("services/create", "ServicesController@create");
    Route::post("services/change_status", "ServicesController@change_status");
    Route::post('services/deletefeatureimage', "ServicesController@deleteImage")->name('featureimagedelete');

    Route::get("services/edit/{id}", "ServicesController@edit");
    Route::delete("services/delete/{id}", "ServicesController@destroy");
    Route::post("save_services", "ServicesController@store");
    Route::get("services_time_slote", "ServicesController@timeslote");
    Route::post("save_time_slote", "ServicesController@save_time_slote");
    Route::match(array('GET', 'POST'), 'services/sort', 'ServicesController@sort');

    //    Ajax Service Category for Daily,Weekly,Monthly Service Type
    //    Route::get('getCleaningServiceTime/{id?}', 'ServicesController@getCleaningService')->name('subcat');


    Route::get("brand", "Brand@index");
    Route::get("brand/create", "Brand@create");
    Route::post("brand/change_status", "Brand@change_status");
    Route::get("brand/edit/{id}", "Brand@edit");
    Route::delete("brand/delete/{id}", "Brand@destroy");
    Route::post("save_brand", "Brand@store");
    Route::match(array('GET', 'POST'), 'brand/sort', 'Brand@sort');

    Route::get("industry_type", "IndustryTypesController@index");
    Route::get("industry_type/create", "IndustryTypesController@create");
    Route::post("industry_type/change_status", "IndustryTypesController@change_status");
    Route::get("industry_type/edit/{id}", "IndustryTypesController@edit");
    Route::delete("industry_type/delete/{id}", "IndustryTypesController@destroy");
    Route::post("save_industry_type", "IndustryTypesController@store");
    Route::match(array('GET', 'POST'), 'industry_type/sort', 'IndustryTypesController@sort');



    Route::resource("store_type", "StoreTypeController");
    Route::post("store_type/change_status", "StoreTypeController@change_status");
    Route::get("store_type/edit/{id}", "StoreTypeController@edit");
    Route::delete("store_type/delete/{id}", "StoreTypeController@destroy");

    Route::resource("product_master", "ProductMaster");
    Route::post("product_master/change_status", "ProductMaster@change_status");
    Route::get("product_master/edit/{id}", "ProductMaster@edit");
    Route::delete("product_master/delete/{id}", "ProductMaster@destroy");


    Route::post("products/loadProductAttribute", "ProductController@loadProductAttribute");
    Route::post("products/loadProductVariations", "ProductController@loadProductVariations");
    Route::post("products/linkNewAttrForProduct", "ProductController@linkNewAttrForProduct");

    Route::get("products", "ProductController@index");
    Route::get("product/create", "ProductController@create");
    Route::post("product/add_product", "ProductController@add_product");
    Route::get("products/edit/{id}", "ProductController@create");
    Route::delete("products/delete/{id}", "ProductController@delete_product");
    Route::delete("products/delete_doc/{id}", "ProductController@delete_document");
    Route::post("products/change_status", "ProductController@change_status");

    Route::post("get_categories_brands", "ProductController@get_categories_brands")->name('get_categories_brands');


    Route::get("coupon_category", "CouponCategory@index");
    Route::get("coupon_category/create", "CouponCategory@create");
    Route::post("coupon_category/change_status", "CouponCategory@change_status");
    Route::get("coupon_category/edit/{id}", "CouponCategory@edit");
    Route::delete("coupon_category/delete/{id}", "CouponCategory@destroy");
    Route::post("save_coupon_category", "CouponCategory@store");
    Route::match(array('GET', 'POST'), 'coupon_category/sort', 'CouponCategory@sort');
    Route::get("coupon_category/get_category", "CouponCategory@get_category")->name('get_coupon_category');

    Route::get("coupon_brand", "CouponBrand@index");
    Route::get("coupon_brand/create", "CouponBrand@create");
    Route::post("coupon_brand/change_status", "CouponBrand@change_status");
    Route::get("coupon_brand/edit/{id}", "CouponBrand@edit");
    Route::delete("coupon_brand/delete/{id}", "CouponBrand@destroy");
    Route::post("save_coupon_brand", "CouponBrand@store");
    Route::match(array('GET', 'POST'), 'coupon_brand/sort', 'CouponBrand@sort');


    Route::get("transport", "TransportController@index");
    Route::get("transport/create", "TransportController@create");
    Route::post("transport/change_status", "TransportController@change_status");
    Route::get("transport/edit/{id}", "TransportController@edit");
    Route::delete("transport/delete/{id}", "TransportController@destroy");
    Route::post("save_transport", "TransportController@store");
    Route::match(array('GET', 'POST'), 'transport/sort', 'TransportController@sort');
    
    Route::get("coupons_voucher", "CouponVoucherController@index");
    Route::get("coupons_voucher/create", "CouponVoucherController@create");
    Route::get("coupons_voucher/edit/{id}", "CouponVoucherController@edit");
    Route::post("save_coupons_voucher", "CouponVoucherController@store");
    Route::delete("coupons_voucher/delete/{id}", "CouponVoucherController@destroy");
    Route::match(array('GET', 'POST'), 'coupons_voucher/sort', 'CouponVoucherController@sort');
    Route::delete("coupons_voucher/delete_image/{id}", "CouponVoucherController@delete_image");



    Route::get("products_requests", "ProductController@products_requests");
    Route::get("products/add_to_product/{id}", "ProductController@add_to_product");
    Route::delete("products/delete_prd_req_doc/{id}", "ProductController@delete_prd_req_doc");
    Route::post("product/req_to_prd", "ProductController@req_to_prd");

    Route::post("products/unlinkAttrFromProduct", "ProductController@unlinkAttrFromProduct");
    Route::post("products/removeProductImage", "ProductController@removeProductImage");

    Route::get('product/export', 'ProductController@export')->name('product.export');
    Route::post('product/import', 'ProductController@import')->name('product.import');
    Route::post('product/image_upload', 'ProductController@unzip_image')->name('product.image_upload');
    Route::get('product/download_format', 'ProductController@download_format')->name('product.download_format');


    Route::resource("product_request", "ProductRequestController");
    Route::delete("product_request/delete_re/{id}", "ProductRequestController@delete_re");
    Route::get("product_request/edit/{id}", "ProductRequestController@edit");
    Route::post("product_request/change_status", "ProductRequestController@change_status");


    Route::get("featured_products", "ProductController@featuredproducts");
    Route::get("product/featured_create", "ProductController@featuredcreate");
    Route::post("featuredstore", "ProductController@featuredstore");
    Route::post("save_featured_products", "ProductController@savefeatured");
    Route::delete("products/deletefeatured/{id}", "ProductController@deletefeatured");
    Route::get("products/editfeatured/{id}", "ProductController@editfeatured");
    Route::delete("delete_ftimage/{id}", "ProductController@delete_ftimage");

    Route::resource("coupons", "CouponsController");
    Route::delete("coupons/delete/{id}", "CouponsController@delete");
    Route::get("coupon_product_search", "CouponsController@couponproductsearch");
    Route::get("coupon_service_search", "CouponsController@couponservicesearch");
    Route::post("coupon_category_by_activity", "CouponsController@couponcategoryActivity");
    Route::post("service_by_vendor", "CouponsController@servicebyvendor");
    

    Route::resource("country", "CountryController");
    Route::resource("bank", "BankController");

    Route::resource("admin_user_designation", "AdminUserDesignation");

    Route::resource("admin_users", "AdminUserController");
    Route::post("admin_users/change_status", "AdminUserController@change_status");
    Route::post("admin_users/verify", "AdminUserController@verify");
    Route::get("admin_users/update_permission/{id}", "AdminUserController@update_permission");
    Route::post('update_user_permission', "AdminUserController@update_user_permission");

    //admin/vendors
    Route::resource("vendors", "VendorsController");
    Route::post("vendors/change_status", "VendorsController@change_status");
    Route::post("vendors/verify", "VendorsController@verify");
    Route::get("vendors/{id}/view/", "VendorsController@show");
    Route::get('vendor_report/{vendor_id}', 'VendorsController@VendorReports')->name('vendors.reports');
    Route::get('vendor_messages/{vendor_id}', 'VendorsController@VendorMessages')->name('vendors.messages');
    Route::get('vendor_videos/{vendor_id?}', 'VendorsController@vendorVideos')->name('vendors.videos');
    
    Route::post("vendors/approve", "VendorsController@approve");
    Route::post("vendors/store", "VendorsController@store");
    //add_wallet_balance
    Route::post("vendor/add_services", "VendorsController@add_services");
    Route::get("vendor/view_services", "VendorsController@view_services");
    Route::delete("vendor/delete_services", "VendorsController@delete_services");

    Route::post("vendor/removevendorMenuImage", "VendorsController@removevendorMenuImage");


    // Route::get('earnings/{id?}', 'EarningsController@payments')->name('chef.earnings');
    Route::get('earnings/{id?}', 'EarningsController@orders')->name('chef.earnings');
    
    Route::post('get_chef_earning_data', 'EarningsController@getEarningData')->name('get_chef_earning_data');
    Route::get('get_chef_ear','EarningsController@get_chef_ear')->name('get_chef_ear');
    Route::post('get_chef_wise_total_earnings','EarningsController@get_chef_wise_total_earnings')->name('get_chef_wise_total_earnings');
    Route::get('chef_earnings_xlsx_export','EarningsController@exportChefEarningsXLSXReport')->name('chef_earnings_export_xlsx');
    Route::get('chef_earnings_csv_export','EarningsController@exportChefEarningsCSVReport')->name('chef_earnings_export_csv');
    Route::get('chef_earnings_pdf_export','EarningsController@exportChefEarningsPDFReport')->name('chef_earnings_export_pdf');

    Route::get("vendor/locations/{id}", "VendorLocationController@index")->name('vendor_locations');
    Route::get("vendor/location/edit/{id}", "VendorLocationController@edit")->name('vendor_locations.edit');
    Route::get("vendor/location/create/{id}", "VendorLocationController@create")->name('vendor_locations.create');
    Route::post("vendor/location/save", "VendorLocationController@store")->name('vendor_locations.store');
    Route::delete("vendor/location/delete/{id}", "VendorLocationController@destroy")->name('vendor_locations.delete');


    Route::get('earning_requests', 'EarningController@requests')->name('earning_requests');
     Route::post('earning_data', 'EarningController@getData')->name('earning.get_data');
     Route::post('bank_details', 'EarningController@getBankDetails')->name('bank_details');
     Route::post('earning/change_status', 'EarningController@changeStatus')->name('earning.change_status');
     
     Route::get('service_earnings/{id?}', 'ServiceEarningsController@service_payments')->name('chef.service_payments');
     Route::post('get_service_earnings_data', 'ServiceEarningsController@getEarningData')->name('get_service_earning_data');
     Route::post('service_earning/change_status', 'ServiceEarningsController@changeStatus')->name('service_earning.change_status');
     

    Route::resource("customers", "CustomersController");
    Route::post("customers/change_status", "CustomersController@change_status");
    Route::post("customers/verify", "CustomersController@verify");

    //add_wallet_balance
    Route::post("customers/add_wallet_balance", "CustomersController@add_wallet_balance");



    Route::get('user/wallet_history/{id}','CustomersController@wallet_history');
    Route::post('user/wallet_top_up','CustomersController@wallet_top_up');
    Route::get('user/ref_history/{id}','CustomersController@ref_history');
    
    Route::resource("store_managers_type", "StoremanagersTypeController");

    // Route::resource("store_managers", "StoremanagersController");
    // Route::post("store_managers/change_status", "StoremanagersController@change_status");


    Route::get('product_attribute', 'AttributeController@index');
    Route::post('attribute_save', 'AttributeController@save');
    Route::post('attribute_value_save', 'AttributeController@save_atr_values');
    Route::get('attribute_edit/{id}', 'AttributeController@edit');
    Route::post("attribute/change_status", "AttributeController@change_status");
    
    Route::get('product_tags', 'TagsController@index');
    Route::post('tags_save', 'TagsController@save');
    Route::post('tags_value_save', 'TagsController@save_atr_values');
    Route::get('tags_edit/{id}', 'TagsController@edit');
    Route::post("tags/change_status", "TagsController@change_status");
    Route::delete("tags/delete/{id}", "TagsController@delete_tag");

    Route::delete("attribute/delete/{id}", "AttributeController@delete_attribute");
    Route::get("attribute_values/{id}", "AttributeController@attribute_values");
    Route::delete("attribute_values/delete/{id}", "AttributeController@delete_attribute_value");
    Route::get('attribute_values_edit/{id}', 'AttributeController@edit_attribute_value');



    Route::get("attribute_values/{id}", "AttributeController@attribute_values");
    Route::post('attribute_value_save', 'AttributeController@save_atr_values');
    Route::delete("attribute_values/delete/{id}", "AttributeController@delete_attribute_value");
    Route::get('attribute_values_edit/{id}', 'AttributeController@edit_attribute_value');

    Route::get("states", "StatesController@index");
    Route::get("states/create", "StatesController@create");
    Route::post("states/change_status", "StatesController@change_status");
    Route::get("states/edit/{id}", "StatesController@edit");
    Route::delete("states/delete/{id}", "StatesController@destroy");
    Route::post("save_states", "StatesController@store");
    Route::post("states/get_by_country", "StatesController@get_by_country");

    Route::get("cities", "CitiesController@index");
    Route::get("cities/create", "CitiesController@create");
    Route::post("cities/change_status", "CitiesController@change_status");
    Route::get("cities/edit/{id}", "CitiesController@edit");
    Route::delete("cities/delete/{id}", "CitiesController@destroy");
    Route::post("save_cities", "CitiesController@store");
    Route::post("cities/get_by_state", "CitiesController@get_by_state");
    Route::post("cities/get_by_country", "CitiesController@get_by_country");

    Route::get("areas", "AreaController@index");
    Route::get("areas/create", "AreaController@create");
    Route::post("areas/change_status", "AreaController@change_status");
    Route::get("areas/edit/{id}", "AreaController@edit");
    Route::delete("areas/delete/{id}", "AreaController@destroy");
    Route::post("save_areas", "AreaController@store");



    Route::get("store", "StoreController@index");
    Route::get("store/create", "StoreController@create");
    Route::post("store/change_status", "StoreController@change_status");
    Route::post("store/verify", "StoreController@verify");
    Route::get("store/edit/{id}", "StoreController@edit");
    Route::delete("store/delete/{id}", "StoreController@destroy");
    Route::delete("store/delete_image/{id}", "StoreController@delete_image");
    Route::post("save_store", "StoreController@store");
    Route::post("store/get_by_vendor", "StoreController@get_by_vendor");


    Route::get("bookings", "BookingController@index");
    Route::get("booking_details/{id}", "BookingController@details")->name('booking_details');
    Route::post("booking/change_status", "BookingController@change_status");
    Route::get("booking_edit/{id}", "BookingController@edit_order");

    Route::get("orders", "OrderController@index");
    Route::get("order_details/{id}", "OrderController@details");
    Route::get("get_delayed_orders", "OrderController@getDelayedOrders");
    
    Route::post("view_order", "OrderController@details")->name('view_order');
    Route::post("order/change_status", "OrderController@change_status");
    Route::get("order_edit/{id}", "OrderController@edit_order");
    Route::delete("promotion/delete/{id}", "PromotionBannerController@delete");
    Route::get("promotion", "PromotionBannerController@index");
    Route::get("promotion/edit/{id}", "PromotionBannerController@edit");
    Route::match(array('GET', 'POST'), 'promotion/create', 'PromotionBannerController@create');
    //Banner
    Route::get("banners", "BannerController@index");
    Route::match(array('GET', 'POST'), 'banner/create', 'BannerController@create');
    Route::get("banner/edit/{id}", "BannerController@edit");
    Route::post("banner/update", "BannerController@update");
    Route::delete("banner/delete/{id}", "BannerController@delete");
    Route::get("banner/get_store/{id}", "BannerController@getstore");
    Route::get("banner/get_product_by_store/{id}", "BannerController@getproductbystore");


    //web banner
    
    
    
    //Custom Banner
    Route::get("custom_banners", "CustomAppBanner@index");
    Route::match(array('GET', 'POST'), 'custom_banner/create', 'CustomAppBanner@create');
    Route::get("custom_banner/edit/{id}", "CustomAppBanner@edit");
    Route::post("custom_banner/update", "CustomAppBanner@update");
    Route::delete("custom_banner/delete/{id}", "CustomAppBanner@delete");


    Route::get('cms_pages', 'PagesController@index')->name('cms_pages');
    Route::get('page/create', 'PagesController@create')->name('cms_pages.add');
    Route::get('page/edit/{id}', 'PagesController@edit')->name('cms_pages.edit');
    Route::post('page/save', 'PagesController@save')->name('cms_pages.save');
    Route::delete('page/delete/{id}', 'PagesController@delete')->name('cms_pages.delete');
    Route::get('contact_details', 'PagesController@contact_details')->name('contact_details');
    Route::get('landing_page_details', 'PagesController@landing_page_details')->name('landing_page_details');
    Route::get('aboutus_page_details', 'PagesController@aboutus_page_details')->name('aboutus_page_details');
    Route::post("contact_us_setting_store", "PagesController@contact_us_setting_store")->name('contact_us_setting_store');
    Route::post("landing_page_setting_store", "PagesController@landing_page_setting_store")->name('landing_page_setting_store');
    Route::post("about_page_setting_store", "PagesController@about_page_setting_store")->name('about_page_setting_store');
    Route::get('settings', 'PagesController@settings');
    Route::post("setting_store", "PagesController@setting_store")->name('setting_store');
    Route::get("likes", "LikeController@index");
    //FAQ
    Route::get("faq", "FaqController@index");
    Route::match(array('GET', 'POST'), 'faq/create', 'FaqController@create');
    Route::get("faq/edit/{id}", "FaqController@edit");
    Route::post("faq/update", "FaqController@update");
    Route::delete("faq/delete/{id}", "FaqController@delete");

    Route::get("help", "HelpController@index");
    Route::match(array('GET', 'POST'), 'help/create', 'HelpController@create');
    Route::get("help/edit/{id}", "HelpController@edit");
    Route::post("help/update", "HelpController@update");
    Route::delete("help/delete/{id}", "HelpController@delete");

    Route::post('load_vendor', 'StoreController@load_vendor');

    Route::get('notifications', 'NotificationController@notifications')->name('notifications');
    Route::get('notifications/create', 'NotificationController@create')->name('notifications.add');
    Route::post('notifications/save', 'NotificationController@save')->name('notifications.save');
    Route::delete('notifications/delete/{id}', 'NotificationController@delete')->name('notifications.delete');


    Route::match(array('GET', 'POST'), 'change_password', 'UsersController@change_password');
    Route::match(array('GET', 'POST'), 'change_user_password', 'UsersController@change_user_password');

    Route::get("service_request", "ServiceRequestController@index");
    Route::get("service_details/{id}", "ServiceRequestController@details");
    Route::post("service/change_status", "ServiceRequestController@change_status");

    Route::get("contact_us", "ContactUsController@index");
    Route::delete("contact_us/delete/{id}", "ContactUsController@delete");
    Route::get('contact_details', 'PagesController@contact_details')->name('contact_details');
    Route::post("contact_us_setting_store", "PagesController@contact_us_setting_store")->name('contact_us_setting_store');

    Route::get("rating", "RatingController@index");
    Route::delete("rating/delete/{id}", "RatingController@delete");
    Route::post("reply_comment", "RatingController@reply_comment");
    Route::get("rating/view_reply/{id}", "RatingController@viewReply");
    Route::delete("rating/delete_reply/{id}", "RatingController@deleteReply");
    
    Route::get("testimonials","TestimonialsController@index")->name('testimonials');
    Route::get("testimonials/create","TestimonialsController@create");
    Route::post("testimonials/save","TestimonialsController@store");
    Route::get("testimonials/edit/{id}","TestimonialsController@create");
    Route::delete("testimonials/delete/{id}","TestimonialsController@destroy");
    Route::post("testimonials/change_status","TestimonialsController@change_status");


    Route::get("blogs","BlogsController@index")->name('blogs');
    Route::get("blogs/create","BlogsController@create");
    Route::post("blogs/save","BlogsController@store");
    Route::get("blogs/edit/{id}","BlogsController@create");
    Route::delete("blogs/delete/{id}","BlogsController@destroy");
    Route::post("blogs/change_status","BlogsController@change_status");

    Route::get("webbanners","HomebannerController@index")->name('blogs');
    Route::get("webbanners/create","HomebannerController@create");
    Route::post("webbanners/save","HomebannerController@store");
    Route::get("webbanners/edit/{id}","HomebannerController@create");
    Route::delete("webbanners/delete/{id}","HomebannerController@destroy");
    Route::post("webbanners/change_status","HomebannerController@change_status");


    Route::get("logos","LogosController@index")->name('logos');
    Route::get("logos/create","LogosController@create");
    Route::post("logos/save","LogosController@store");
    Route::get("logos/edit/{id}","LogosController@create");
    Route::delete("logos/delete/{id}","LogosController@destroy");
    Route::post("logos/change_status","LogosController@change_status");

    Route::get("subscriberemails","SubscriberEmailController@index")->name('subscriberemails');
    Route::get("contactusqueries","SubscriberEmailController@contactusqueries")->name('contactusqueries');

    Route::get("subscriberemailsexport","SubscriberEmailController@exportToExcel"); 
});

/***Vendors***/

Route::get('/portal', 'App\Http\Controllers\portal\LoginController@login')->name('portal.login');
Route::post('/portal/check-email', 'App\Http\Controllers\portal\LoginController@checkEmail')->name('portal.checkEmail');
Route::get('/portal/seller_register', 'App\Http\Controllers\portal\LoginController@seller_register')->name('portal.seller_register');
Route::post('/portal/seller_register_post', 'App\Http\Controllers\portal\LoginController@seller_register_post')->name('portal.seller_register_post');
Route::post('portal/check_login', 'App\Http\Controllers\portal\LoginController@check_login')->name('portal.check_login');
Route::get('/forgot-password', 'App\Http\Controllers\portal\LoginController@forgotpassword')->name('portal.forgot');
Route::post('portal/check_user', 'App\Http\Controllers\portal\LoginController@check_user')->name('portal.check_user');

Route::post('portal/check_user_code', 'App\Http\Controllers\portal\LoginController@check_user_code')->name('portal.check_user_code');
Route::get('portal/user_code', 'App\Http\Controllers\portal\LoginController@user_code')->name('portal.user_code');

Route::namespace('App\Http\Controllers\portal')->prefix('vendor_sign_up')->name('vendor_sign_up.')->group(function () {
    Route::resource("vendors", "VendorsController");
});

Route::get('thank-you', 'App\Http\Controllers\portal\LoginController@thankyou')->name('portal.thankyou');

Route::get("/portal/order_invoice/{id}/{vendor_id}", 'App\Http\Controllers\portal\OrderController@printInvoice');

Route::namespace('App\Http\Controllers\portal')->prefix('portal')->middleware('portal')->name('portal.')->group(function () {
   
    // Route::get('change-password', 'AdminController@changePassword')->name('change.password');
    // Route::post('change-password', 'AdminController@changePasswordSave')->name('change.password.save');
    Route::get('logout', 'LoginController@logout')->name('logout');
    Route::get('dashboard', 'DashboardController@dashboard')->name('dashboard');
    Route::get('setup-shop', 'LoginController@setup_shop')->name('setup.shop');
    Route::post('check_email', 'LoginController@check_email')->name('check.email');
    Route::post('setup-shop/save-step', 'LoginController@saveStep')->name('setup.save');
    Route::resource("vendors", "VendorsController");


    Route::get("bookings", "BookingController@index");
    Route::get("booking_details/{id}", "BookingController@details")->name('booking_details');
    Route::post("booking/change_status", "BookingController@change_status");
    Route::get("booking_edit/{id}", "BookingController@edit_order");
    

    
    // Route::post("states/get_by_country", "StatesController@get_by_country");
    // Route::post("cities/get_by_state", "CitiesController@get_by_state");
    // Route::post("cities/get_by_country", "CitiesController@get_by_country");

    /***Stores***/
    // Route::get("store", "StoreController@index");
    // Route::get("store/create", "StoreController@create");
    // Route::post("store/change_status", "StoreController@change_status");
    // Route::post("store/verify", "StoreController@verify");
    // Route::get("store/edit/{id}", "StoreController@edit");
    // Route::delete("store/delete/{id}", "StoreController@destroy");
    // Route::delete("store/delete_image/{id}", "StoreController@delete_image");
    // Route::post("save_store", "StoreController@store");
    // Route::post("store/get_by_vendor", "StoreController@get_by_vendor");

    Route::get("locations", "VendorLocationController@index")->name('vendor_locations');
    Route::get("location/edit/{id}", "VendorLocationController@edit")->name('vendor_locations.edit');
    Route::get("location/create", "VendorLocationController@create")->name('vendor_locations.create');
    Route::post("location/save", "VendorLocationController@store")->name('vendor_locations.store');
    Route::delete("location/delete/{id}", "VendorLocationController@destroy")->name('vendor_locations.delete');

    /***storeManager***/
    // Route::resource("store_managers", "StoremanagersController");
    // Route::post("store_managers/change_status", "StoremanagersController@change_status");

    // Route::get("privilege", "PrivilegeController@privilege");
    // Route::post("save_privilege", "PrivilegeController@save_privilege");

    // Route::resource("store_managers_type", "StoremanagersTypeController");

    //designation
    Route::resource("designation", "DesignationController");

    /***Products***/
    Route::post("products/loadProductAttribute", "ProductController@loadProductAttribute");
    Route::post("products/loadProductVariations", "ProductController@loadProductVariations");
    Route::post("products/linkNewAttrForProduct", "ProductController@linkNewAttrForProduct");

    Route::get("products", "ProductController@index");
    Route::get("product/create", "ProductController@create");
    Route::post("product/add_product", "ProductController@add_product");
    Route::get("products/edit/{id}", "ProductController@create");
    Route::delete("products/delete/{id}", "ProductController@delete_product");
    Route::delete("products/delete_doc/{id}", "ProductController@delete_document");
    Route::post("products/change_status", "ProductController@change_status");

    Route::resource("product_request", "ProductRequestController");
    Route::delete("product_request/delete_re/{id}", "ProductRequestController@delete_re");
    Route::get("product_request/edit/{id}", "ProductRequestController@edit");

    Route::get("workshops", "ServicesController@index")->name('vendor.workshops');
    Route::get("workshop/create", "ServicesController@create");
    Route::post("workshop/change_status", "ServicesController@change_status");
    Route::get("workshop/edit/{id}", "ServicesController@edit");
    Route::delete("workshop/delete/{id}", "ServicesController@destroy");
    Route::post("save_services", "ServicesController@store");

    Route::post("vendor/add_services", "VendorsController@add_services");
    Route::get("vendor/view_services", "VendorsController@view_services");
    Route::delete("vendor/delete_services", "VendorsController@delete_services");

    Route::get("products_requests", "ProductController@products_requests");
    Route::get("products/add_to_product/{id}", "ProductController@add_to_product");
    Route::delete("products/delete_prd_req_doc/{id}", "ProductController@delete_prd_req_doc");
    Route::post("product/req_to_prd", "ProductController@req_to_prd");

    Route::post("products/unlinkAttrFromProduct", "ProductController@unlinkAttrFromProduct");
    Route::post("products/removeProductImage", "ProductController@removeProductImage");

    Route::get('product/export', 'ProductController@export')->name('product.export');
    Route::post('product/import', 'ProductController@import')->name('product.import');
    Route::post('product/image_upload', 'ProductController@unzip_image')->name('product.image_upload');
    Route::get('product/download_format', 'ProductController@download_format')->name('product.download_format');

    Route::get("orders", "OrderController@index");
    Route::get("order_details/{id}", "OrderController@details")->name('order_details');
    Route::post("order/change_status", "OrderController@change_status");
    Route::get("order_edit/{id}", "OrderController@edit_order");

    

    Route::get('report/booking_workshops', 'ReportController@booking_workshop_report')->name('workshop_report');

    Route::get('report/customers', 'ReportController@customers')->name('customer_report');
    Route::get('report/orders', 'ReportController@orders')->name('order_report');

    Route::get('order_report', '\App\Http\Controllers\admin\ReportController@orders')->name('portal_order_report');

    Route::get('earnings', 'CommissionController@index')->name('earnings');
    Route::post('get_earning_data', 'CommissionController@getEarningData')->name('get_earning_data');
    Route::get('service_earnings', 'CommissionController@service_earnings');
    Route::post('earning/request', 'CommissionController@sendRequest')->name('earning.request');
    Route::post('earning/sendRequestService', 'CommissionController@sendRequestService')->name('earning.request_service');
    
    Route::get("service_request", "ServiceRequestController@index");
    Route::get("service_details/{id}/{item_id}", "ServiceRequestController@details");
    Route::post("service/change_status", "ServiceRequestController@change_status");
    Route::post("service/change_status_rejected", "ServiceRequestController@change_status_rejected");


    Route::get('report/service', '\App\Http\Controllers\portal\ReportController@service_request')->name('portal_order_report_service');


    /***VendorProfile***/
    Route::get('my_profile', 'VendorsController@MyProfile');
    Route::post('update_my_profile', 'VendorsController@store');
    Route::post("removevendorMenuImage", "VendorsController@removevendorMenuImage");
    
    
    Route::get('vendor_messages/{vendor_id}', 'VendorsController@VendorMessages');
    Route::get('vendor_reports/{vendor_id}', 'VendorsController@Vendorreports');
    Route::get('vendor_videos/{vendor_id?}', 'VendorsController@vendorVideos')->name('vendors.videos');
    Route::get("likes", "LikeController@index");
 
    Route::match(array('GET', 'POST'), 'change_password', 'UsersController@change_password');

    //uncommit me
    Route::get('import_export', 'ProductImportExport@import_export')->name('import_export');
    Route::post('Excel/export', 'ProductImportExport@export_product')->name('export_product');
    Route::get('Excel/export', 'ProductImportExport@export_product')->name('export_product_excel');
    Route::post('Excel/upload_file', 'ProductImportExport@upload_file')->name('upload_file');
    Route::get('start_import', 'ProductImportExport@start_import')->name('start_import');
    Route::post('Excel/upload_zip_file', 'ProductImportExport@upload_zip_file')->name('upload_zip_file');
    Route::post('Excel/startUnzipImage', 'ProductImportExport@startUnzipImage')->name('startUnzipImage');

    Route::get("rating", "RatingController@index");
    Route::delete("rating/delete/{id}", "RatingController@delete");
    Route::post("reply_comment", "RatingController@reply_comment");
    Route::get("rating/view_reply/{id}", "RatingController@viewReply");
    Route::delete("rating/delete_reply/{id}", "RatingController@deleteReply");
});
Route::get('/cleaning-services', [CleaningServiceController::class, 'index']);
Route::get('admin/cleaning-service/create', [CleaningServiceController::class, 'create']);
Route::post('admin/save/cleaning_service', [CleaningServiceController::class, 'store']);
Route::get('admin/cleaning-service/edit/{id}', [CleaningServiceController::class, 'edit']);
Route::delete('admin/cleaning-service/delete/{id}', [CleaningServiceController::class, 'destroy']);