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

/*
Route::get('/', function () {
    return view('welcome');
});
*/


Route::group(  ['middleware' => ['web', 'guest'], 'prefix' => 'sitecontrol', 'namespace' => 'sitecontrol']   , function () {

    Route::get('/', [
        'uses' => 'auth\LoginController@getLogin',
        'as' => 'get.login'
    ]);


    Route::match(['get', 'post'], '/login', [
        'uses' => 'auth\LoginController@postLogin',
        'as' => 'post.login',
        'middleware' => 'verifypost:sitecontrol/'
    ]);

    Route::match(['get', 'post'], '/forgotpassword', [
        'uses' => 'auth\LoginController@postForgotPassword',
        'as' => 'post.forgotpassword',

    ]);

});

Route::group(['middleware' => ['web']], function () {

    Route::get('/jcassets/static/{folder}/{file}', 'MediaServerController@secure_assets')->where(['file' => '.*', 'folder' => '.*']);


    Route::get('/logout', [
        'uses' => 'sitecontrol\LoginController@getLogout',
        'as' => 'get.logout',
    ]);
});




Route::group(['prefix' => 'sitecontrol', 'namespace' => 'sitecontrol', 'middleware' => ['web', 'auth']], function () {
		
		Route::group(array( 'prefix' => 'managemyaccount', 'namespace' => 'managemyaccount' ), function () {
	
			Route::get('/controls/view/', [
				'uses'  => 'Controls@view',
				'as'    => 'managemyaccount.view'
			]);
	

			Route::get('/controls/edit/{edit_id?}', [
				'uses'  => 'Controls@edit',
				'as'    => 'managemyaccount.edit'
			]);
	
			Route::post('/controls/save', [
				'uses'  => 'Controls@save',
				'as'    => 'managemyaccount.save',
				'middleware' => 'verifypost:managemyaccount/controls/view'
			]);
	
		});	

});
	

if ( false )
{
	Route::group(['middleware' => ['web', 'auth', 'verifyrolepermissions']], function () {
	
		Route::group(array( 'prefix' => 'managedashboard', 'namespace' => 'managedashboard' ), function () {
	
			Route::get('/controls/view/', [
				'uses'  => 'Controls@view',
				'as'    => 'managedashboard.view'
			]);
			
			
			
			Route::match(['get', 'post'], '/controls/ajax_create_dashboard_graph/{block?}/{is_ajax?}', [
				'uses'  => 'Controls@ajax_create_dashboard_graph',
				'as'    => 'managedashboard.ajax_create_dashboard_graph',
				'middleware' => 'verifypost:managedashboard/controls/ajax_create_dashboard_graph'
			]);
			
		});
		
		
		
		 Route::group(array( 'prefix' => 'managebulkproductsdelete', 'namespace' => 'managebulkproductsdelete' ), function () {
	
			Route::match(['get'], '/controls/view/{vendor_ID?}', [
				'uses'  => 'Controls@view',
				'as'    => 'managebulkproductsdelete.view'
			]);
	
			
			Route::match(['get', 'post'], '/controls/options', [
				'uses'  => 'Controls@options',
				'as'    => 'managebulkproductsdelete.options',
				'middleware' => 'verifypost:managebulkproductsdelete/controls/view'
			]);
			
			Route::match(['get', 'post'], '/controls/ajax_associate_product_with_vendor/{get_product_details?}', [
				'uses'  => 'Controls@ajax_associate_product_with_vendor',
				'as'    => 'managebulkproductsdelete.ajax_associate_product_with_vendor',
			]);
			
			
	
		});
		
		
		
		Route::group(array( 'prefix' => 'managebulkmapping', 'namespace' => 'managebulkmapping' ), function () {
	
			Route::match(['get'], '/controls/view/{vendor_ID?}', [
				'uses'  => 'Controls@view',
				'as'    => 'managebulkmapping.view'
			]);
			
			Route::get('/controls/add/', [
				'uses'  => 'Controls@add',
				'as'    => 'managebulkmapping.add'
			]);
	
			Route::get('/controls/edit/{edit_id}', [
				'uses'  => 'Controls@edit',
				'as'    => 'managebulkmapping.edit'
			]);
	
			Route::match(['get', 'post'], '/controls/save', [
				'uses'  => 'Controls@save',
				'as'    => 'managebulkmapping.save',
				'middleware' => 'verifypost:managebulkmapping/controls/view'
			]);
			
			Route::match(['get', 'post'], '/controls/options', [
				'uses'  => 'Controls@options',
				'as'    => 'managebulkmapping.options',
				'middleware' => 'verifypost:managebulkmapping/controls/view'
			]);
			
			Route::get('/controls/get_detail_data/{product_id?}', [
				'uses'  => 'Controls@get_detail_data',
				'as'    => 'managebulkmapping.get_detail_data'
			]);
			
			
			Route::match(['get', 'post'], '/controls/ajax_associate_product_with_vendor/{get_product_details?}', [
				'uses'  => 'Controls@ajax_associate_product_with_vendor',
				'as'    => 'managebulkmapping.ajax_associate_product_with_vendor',
			]);
			
			
	
		});
		
		
		
		Route::group(array( 'prefix' => 'managerolespermissions', 'namespace' => 'managerolespermissions' ), function () {
	
			Route::get('/controls/view/', [
				'uses'  => 'Controls@view',
				'as'    => 'managerolespermissions.view'
			]);
			
			Route::get('/controls/add/', [
				'uses'  => 'Controls@add',
				'as'    => 'managerolespermissions.add'
			]);
	
			Route::get('/controls/edit/{edit_id}', [
				'uses'  => 'Controls@edit',
				'as'    => 'managerolespermissions.edit'
			]);
	
			Route::match(['get', 'post'], '/controls/save', [
				'uses'  => 'Controls@save',
				'as'    => 'managerolespermissions.save',
				'middleware' => 'verifypost:managerolespermissions/controls/view'
			]);
			
			Route::match(['get', 'post'], '/controls/options', [
				'uses'  => 'Controls@options',
				'as'    => 'managerolespermissions.options',
				'middleware' => 'verifypost:managerolespermissions/controls/view'
			]);
	
	
		});
		
		
		Route::group(array( 'prefix' => 'managesellercenterstatus', 'namespace' => 'managesellercenterstatus' ), function () {
	
			Route::get('/controls/view/', [
				'uses'  => 'Controls@view',
				'as'    => 'managesellercenterstatus.view'
			]);
	
			Route::get('/controls/edit/', [
				'uses'  => 'Controls@edit',
				'as'    => 'managesellercenterstatus.edit'
			]);
	
			Route::get('/controls/edit/{edit_id}', [
				'uses'  => 'Controls@edit',
				'as'    => 'managesellercenterstatus.edit'
			]);
	
			Route::post('/controls/save', [
				'uses'  => 'Controls@save',
				'as'    => 'managesellercenterstatus.save',
				'middleware' => 'verifypost:managesellercenterstatus/controls/view'
			]);
	
	
		});
		
		
		Route::group(array( 'prefix' => 'managerolesidentifier', 'namespace' => 'managerolesidentifier' ), function () {
	
			Route::get('/controls/view/', [
				'uses'  => 'Controls@view',
				'as'    => 'managerolesidentifier.view'
			]);
	
			Route::get('/controls/edit/', [
				'uses'  => 'Controls@edit',
				'as'    => 'managerolesidentifier.edit'
			]);
	
			Route::get('/controls/edit/{edit_id}', [
				'uses'  => 'Controls@edit',
				'as'    => 'managerolesidentifier.edit'
			]);
	
			Route::post('/controls/save', [
				'uses'  => 'Controls@save',
				'as'    => 'managerolesidentifier.save',
				'middleware' => 'verifypost:managerolesidentifier/controls/view'
			]);
	
	
		});
		
		
			
	
		Route::group(array( 'prefix' => 'managemyaccount', 'namespace' => 'managemyaccount' ), function () {
	
			Route::get('/controls/view/', [
				'uses'  => 'Controls@view',
				'as'    => 'managemyaccount.view'
			]);
	
			Route::get('/controls/edit/{edit_id}/{_parent_directory?}', [
				'uses'  => 'Controls@edit',
				'as'    => 'managemyaccount.edit'
			]);
	
			Route::post('/controls/save', [
				'uses'  => 'Controls@save',
				'as'    => 'managemyaccount.save',
				'middleware' => 'verifypost:managemyaccount/controls/view'
			]);
	
		});
	
	
		
		
		
		
		Route::group(array( 'prefix' => 'manageconfigurationsettings', 'namespace' => 'manageconfigurationsettings' ), function () {
	
			Route::get('/controls/view/', [
				'uses'  => 'Controls@view',
				'as'    => 'manageconfigurationsettings.view'
			]);
	
			Route::get('/controls/edit/', [
				'uses'  => 'Controls@edit',
				'as'    => 'manageconfigurationsettings.edit'
			]);
	
			Route::get('/controls/edit/{edit_id}', [
				'uses'  => 'Controls@edit',
				'as'    => 'manageconfigurationsettings.edit'
			]);
	
			Route::post('/controls/save', [
				'uses'  => 'Controls@save',
				'as'    => 'manageconfigurationsettings.save',
				'middleware' => 'verifypost:manageconfigurationsettings/controls/view'
			]);
	
	
		});
	
	
		Route::group(array( 'prefix' => 'manageusers', 'namespace' => 'manageusers' ), function () {
	
			Route::get('/controls/view/', [
				'uses'  => 'Controls@view',
				'as'    => 'manageusers.view'
			]);
	
			Route::get('/controls/add/', [
				'uses'  => 'Controls@add',
				'as'    => 'manageusers.add'
			]);
	
			Route::get('/controls/edit/{edit_id}', [
				'uses'  => 'Controls@edit',
				'as'    => 'manageusers.edit'
			]);
	
			Route::match(['get', 'post'], '/controls/save', [
				'uses'  => 'Controls@save',
				'as'    => 'manageusers.save',
				'middleware' => 'verifypost:manageusers/controls/view'
			]);
	
			Route::match(['get', 'post'], '/controls/options', [
				'uses'  => 'Controls@options',
				'as'    => 'manageusers.options',
				'middleware' => 'verifypost:manageusers/controls/view'
			]);
	
		});
		
		
		Route::group( array( 'prefix' => 'managewarehouse', 'namespace' => 'managewarehouse' ), function() {
	
			Route::get('/controls/view/', [
				'uses'  => 'Controls@view',
				'as'    => 'managewarehouse.view'
			]);
	
			Route::match(['get','post'], '/controls/add/', [
				'uses'  => 'Controls@add',
				'as'    => 'managewarehouse.add'
			]);
	
	
			Route::match(['get', 'post'], '/controls/save', [
				'uses'  => 'Controls@save',
				'as'    => 'managewarehouse.save',
				'middleware' => 'verifypost:managewarehouse/controls/view'
			]);
	
			Route::get('/controls/edit/{edit_id}', [
				'uses'  => 'Controls@edit',
				'as'    => 'managewarehouse.edit'
			]);
	
			Route::match(['get', 'post'], '/controls/options', [
				'uses'  => 'Controls@options',
				'as'    => 'managewarehouse.options',
				'middleware' => 'verifypost:managewarehouse/controls/view'
			]);
			
		} );
		
		
		Route::group( array( 'prefix' => 'managewarehouselocation', 'namespace' => 'managewarehouselocation' ), function() {
	
			Route::get('/controls/view/', [
				'uses'  => 'Controls@view',
				'as'    => 'managewarehouselocation.view'
			]);
	
			Route::match(['get','post'], '/controls/add/', [
				'uses'  => 'Controls@add',
				'as'    => 'managewarehouselocation.add'
			]);
	
	
			Route::match(['get', 'post'], '/controls/save', [
				'uses'  => 'Controls@save',
				'as'    => 'managewarehouselocation.save',
				'middleware' => 'verifypost:managewarehouselocation/controls/view'
			]);
	
			Route::get('/controls/edit/{edit_id}', [
				'uses'  => 'Controls@edit',
				'as'    => 'managewarehouselocation.edit'
			]);
	
			Route::match(['get', 'post'], '/controls/options', [
				'uses'  => 'Controls@options',
				'as'    => 'managewarehouselocation.options',
				'middleware' => 'verifypost:managewarehouselocation/controls/view'
			]);
			
		} );
		
		
		
		
		Route::group( array( 'prefix' => 'managewarehouselocationinventory', 'namespace' => 'managewarehouselocationinventory' ), function() {
	
			Route::get('/controls/view/', [
				'uses'  => 'Controls@view',
				'as'    => 'managewarehouselocationinventory.view'
			]);
	
			Route::match(['get','post'], '/controls/add/', [
				'uses'  => 'Controls@add',
				'as'    => 'managewarehouselocationinventory.add'
			]);
	
	
			Route::match(['get', 'post'], '/controls/save', [
				'uses'  => 'Controls@save',
				'as'    => 'managewarehouselocationinventory.save',
				'middleware' => 'verifypost:managewarehouselocationinventory/controls/view'
			]);
	
			Route::get('/controls/edit/{edit_id}', [
				'uses'  => 'Controls@edit',
				'as'    => 'managewarehouselocationinventory.edit'
			]);
	
			Route::match(['get', 'post'], '/controls/options', [
				'uses'  => 'Controls@options',
				'as'    => 'managewarehouselocationinventory.options',
				'middleware' => 'verifypost:managewarehouselocationinventory/controls/view'
			]);
			
			Route::get('/controls/get_detail_data/{warehouse_id}/{where_clause?}', [
				'uses'  => 'Controls@get_detail_data',
				'as'    => 'managewarehouselocationinventory.get_detail_data'
			]);
			
		} );
		
		
		
		Route::group( array( 'prefix' => 'managerequestconsignmentpickup', 'namespace' => 'managerequestconsignmentpickup' ), function() {
	
			Route::get('/controls/view/', [
				'uses'  => 'Controls@view',
				'as'    => 'managerequestconsignmentpickup.view'
			]);
	
			Route::match(['get','post'], '/controls/add/', [
				'uses'  => 'Controls@add',
				'as'    => 'managerequestconsignmentpickup.add'
			]);
	
	
			Route::match(['get', 'post'], '/controls/save', [
				'uses'  => 'Controls@save',
				'as'    => 'managerequestconsignmentpickup.save',
				'middleware' => 'verifypost:managerequestconsignmentpickup/controls/view'
			]);
	
			Route::match(['get', 'post'], '/controls/post_createpurchaseorder', [
				'uses'  => 'Controls@post_createpurchaseorder',
				'as'    => 'managerequestconsignmentpickup.post_createpurchaseorder',
				'middleware' => 'verifypost:managerequestconsignmentpickup/controls/view'
			]);
	
	
			Route::get('/controls/edit/{edit_id}', [
				'uses'  => 'Controls@edit',
				'as'    => 'managerequestconsignmentpickup.edit'
			]);
	
			Route::match(['get', 'post'], '/controls/options', [
				'uses'  => 'Controls@options',
				'as'    => 'managerequestconsignmentpickup.options',
				'middleware' => 'verifypost:managerequestconsignmentpickup/controls/view'
			]);
			
		});
		
		
		Route::group( array( 'prefix' => 'managepurchaseorders', 'namespace' => 'managepurchaseorders' ), function() {
	
			
			#$ip = NULL, $purpose = "location", $deep_detect = TRUE
			Route::match(['get','post'], '/controls/ip_info/{ip?}/{purpose?}/{deep_detect?}', [
				'uses'  => 'Controls@ip_info',
				'as'    => 'managepurchaseorders.ip_info'
			]);
			
			
			Route::match(['get','post'], '/controls/view/{is_ajax?}', [
				'uses'  => 'Controls@view',
				'as'    => 'managepurchaseorders.view'
			]);
	
			Route::match(['get','post'], '/controls/add/', [
				'uses'  => 'Controls@add',
				'as'    => 'managepurchaseorders.add'
			]);
	
	
			Route::match(['get', 'post'], '/controls/save', [
				'uses'  => 'Controls@save',
				'as'    => 'managepurchaseorders.save',
				'middleware' => 'verifypost:managepurchaseorders/controls/view'
			]);
			
			Route::match(['get', 'post'], '/controls/ajax_delivery_receipt_form/{vendor_id?}/{purchase_order_id?}', [
				'uses'  => 'Controls@ajax_delivery_receipt_form',
				'as'    => 'managepurchaseorders.ajax_delivery_receipt_form'
			]);
			
			Route::match(['get', 'post'], '/controls/ajax_create_purchase_order_form_VALIDATE', [
				'uses'  => 'Controls@ajax_create_purchase_order_form_VALIDATE',
				'as'    => 'managepurchaseorders.ajax_create_purchase_order_form_VALIDATE'
			]);
			
			Route::match(['get', 'post'], '/controls/ajax_create_purchase_order_form_LOADFORM/{vendor_id?}/{product_ids?}/{category_ids?}', [
				'uses'  => 'Controls@ajax_create_purchase_order_form_LOADFORM',
				'as'    => 'managepurchaseorders.ajax_create_purchase_order_form_LOADFORM'
			]);
	
			Route::get('/controls/edit/{edit_id}', [
				'uses'  => 'Controls@edit',
				'as'    => 'managepurchaseorders.edit'
			]);
	
			Route::match(['get', 'post'], '/controls/options', [
				'uses'  => 'Controls@options',
				'as'    => 'managepurchaseorders.options',
				'middleware' => 'verifypost:managepurchaseorders/controls/view'
			]);
			
		} );
		
		
		
		Route::group( array( 'prefix' => 'manageorders', 'namespace' => 'manageorders' ), function() {
	
			Route::match(['get','post'], '/controls/view/{vendor_id?}', [
				'uses'  => 'Controls@view',
				'as'    => 'manageorders.view'
			]);
			
	
			Route::match(['get','post'], '/controls/add/', [
				'uses'  => 'Controls@add',
				'as'    => 'manageorders.add'
			]);
	
	
			Route::match(['get', 'post'], '/controls/save', [
				'uses'  => 'Controls@save',
				'as'    => 'manageorders.save',
				'middleware' => 'verifypost:manageorders/controls/view'
			]);
	
			Route::get('/controls/edit/{edit_id}', [
				'uses'  => 'Controls@edit',
				'as'    => 'manageorders.edit'
			]);
	
			Route::match(['get', 'post'], '/controls/options', [
				'uses'  => 'Controls@options',
				'as'    => 'manageorders.options',
				'middleware' => 'verifypost:manageorders/controls/view'
			]);
			
			Route::get('/controls/get_detail_data/{order_id}/{vendor_id}', [
				'uses'  => 'Controls@get_detail_data',
				'as'    => 'manageorders.get_detail_data'
			]);
			
			
			
			
			Route::match(['get', 'post'], '/controls/ajax_order_outbound_pickup_list/{warehouse_id?}/{order_id?}/{product_id?}/{quantity?}/{select_product?}', [
				'uses'  => 'Controls@ajax_order_outbound_pickup_list',
				'as'    => 'manageorders.ajax_order_outbound_pickup_list'
			]);
			
			
			Route::match(['get', 'post'], '/controls/ajax_ship_order/{order_id?}', [
				'uses'  => 'Controls@ajax_ship_order',
				'as'    => 'manageorders.ajax_ship_order'
			]);
			
			Route::match(['get', 'post'], '/controls/ajax_creditmemo_order/{order_id?}', [
				'uses'  => 'Controls@ajax_creditmemo_order',
				'as'    => 'manageorders.ajax_creditmemo_order'
			]);
			
			Route::match(['get', 'post'], '/controls/ajax_creditmemo_detail/{order_id?}/{creditmemo_id?}', [
				'uses'  => 'Controls@ajax_creditmemo_detail',
				'as'    => 'manageorders.ajax_creditmemo_detail'
			]);
			
			
			
			
			Route::match(['get', 'post'], '/controls/ajax_hold_order/{order_id?}', [
				'uses'  => 'Controls@ajax_hold_order',
				'as'    => 'manageorders.ajax_hold_order'
			]);
			
			Route::match(['get', 'post'], '/controls/ajax_invoice_order/{order_id?}', [
				'uses'  => 'Controls@ajax_invoice_order',
				'as'    => 'manageorders.ajax_invoice_order'
			]);
			
			
			Route::match(['get', 'post'], '/controls/ajax_shipment_detail/{order_id?}/{shipment_id?}', [
				'uses'  => 'Controls@ajax_shipment_detail',
				'as'    => 'manageorders.ajax_shipment_detail'
			]);
			
			
			Route::match(['get', 'post'], '/controls/ajax_invoice_detail/{order_id?}/{invoice_id?}', [
				'uses'  => 'Controls@ajax_invoice_detail',
				'as'    => 'manageorders.ajax_invoice_detail'
			]);
			
			
			
			
			
		} );
		
		
		Route::group( array( 'prefix' => 'manageinventory', 'namespace' => 'manageinventory' ), function() {
	
			Route::get('/controls/view/{sellercenter_status?}', [
				'uses'  => 'Controls@view',
				'as'    => 'manageinventory.view'
			]);
			
			Route::match(['get', 'post'], '/controls/get_detail_data/{delivery_receipt_id?}/{filter_status?}', [
				'uses'  => 'Controls@get_detail_data',
				'as'    => 'manageinventory.get_detail_data'
			]);	
	
			Route::match(['get','post'], '/controls/add/', [
				'uses'  => 'Controls@add',
				'as'    => 'manageinventory.add'
			]);
	
			Route::match(['get', 'post'], '/controls/save', [
				'uses'  => 'Controls@save',
				'as'    => 'manageinventory.save',
				'middleware' => 'verifypost:manageinventory/controls/view'
			]);
	
			Route::get('/controls/edit/{edit_id}', [
				'uses'  => 'Controls@edit',
				'as'    => 'manageinventory.edit'
			]);
	
			Route::match(['get', 'post'], '/controls/options', [
				'uses'  => 'Controls@options',
				'as'    => 'manageinventory.options',
				'middleware' => 'verifypost:manageinventory/controls/view'
			]);
			
			Route::match(['get', 'post'], '/controls/ajax_approve_reject_delivery_receipt_products/{delivery_product_ids?}/{change_status_to?}', [
				'uses'  => 'Controls@ajax_approve_reject_delivery_receipt_products',
				'as'    => 'manageinventory.ajax_approve_reject_delivery_receipt_products'
			]);
			
			
			
		} );
		
		Route::group( array( 'prefix' => 'managebaseproducts', 'namespace' => 'managebaseproducts' ), function() {
			
			Route::get('/controls/view/', [
				'uses'  => 'Controls@view',
				'as'    => 'managebaseproducts.view'
			]);
	
			Route::match(['get','post'], '/controls/add/', [
				'uses'  => 'Controls@add',
				'as'    => 'managebaseproducts.add'
			]);
			
			Route::match(['get', 'post'], '/controls/save', [
				'uses'  => 'Controls@save',
				'as'    => 'managebaseproducts.save',
				'middleware' => 'verifypost:managebaseproducts/controls/view'
			]);
			
			
			Route::get('/controls/edit/{edit_id}', [
				'uses'  => 'Controls@edit',
				'as'    => 'managebaseproducts.edit'
			]);
			
			Route::match(['get', 'post'], '/controls/options', [
				'uses'  => 'Controls@options',
				'as'    => 'managebaseproducts.options',
				'middleware' => 'verifypost:managebaseproducts/controls/view'
			]);
			
			Route::match(['get', 'post'], '/controls/ajax_delete_product_image/', [
				'uses'  => 'Controls@ajax_delete_product_image',
				'as'    => 'managebaseproducts.ajax_delete_product_image'
			]);
			
			Route::get('/controls/get_detail_data/{product_id?}', [
				'uses'  => 'Controls@get_detail_data',
				'as'    => 'managebaseproducts.get_detail_data'
			]);
			
		} );
		
		Route::group( array( 'prefix' => 'managevendorsproducts', 'namespace' => 'managevendorsproducts' ), function() {
	
			Route::get('/controls/view/', [
				'uses'  => 'Controls@view',
				'as'    => 'managevendorsproducts.view'
			]);
	
			Route::match(['get','post'], '/controls/add/', [
				'uses'  => 'Controls@add',
				'as'    => 'managevendorsproducts.add'
			]);
	
			Route::match(['get','post'], '/controls/searchproducts/', [
				'uses'  => 'Controls@searchproducts',
				'as'    => 'managevendorsproducts.searchproducts'
			]);
			
			Route::match(['get','post'], '/controls/createproductform/{is_base_product}', [
				'uses'  => 'Controls@createproductform',
				'as'    => 'managevendorsproducts.createproductform'
			]);
	
			Route::match(['get', 'post'], '/controls/save/{is_ajax?}', [
				'uses'  => 'Controls@save',
				'as'    => 'managevendorsproducts.save',
				'middleware' => 'verifypost:managevendorsproducts/controls/view'
			]);
	
			Route::get('/controls/overview/{product_id}', [
				'uses'  => 'Controls@overview',
				'as'    => 'managevendorsproducts.overview'
			]);
	
			Route::match(['get', 'post'], '/controls/ajax_request_consignment_pickup/{vendor_id?}/{product_id?}', [
				'uses'  => 'Controls@ajax_request_consignment_pickup',
				'as'    => 'managevendorsproducts.ajax_request_consignment_pickup'
			]);
			
			Route::get('/controls/get_detail_data/{product_id?}', [
				'uses'  => 'Controls@get_detail_data',
				'as'    => 'managevendorsproducts.get_detail_data'
			]);
			
			/*
			Route::match(['get', 'post'], '/controls/Treeview_get_category', [
				'uses'  => 'Controls@Treeview_get_category',
				'as'    => 'managecategory.Treeview_get_category'
			]);
			
			Route::match(['get', 'post'], '/controls/Treeview_get_category/{extra_condition}', [
				'uses'  => 'Controls@Treeview_get_category',
				'as'    => 'managecategory.Treeview_get_category'
			]);
			
			Route::match(['get', 'post'], '/controls/Treeview_move_category', [
				'uses'  => 'Controls@Treeview_move_category',
				'as'    => 'managecategory.Treeview_move_category'
			]);
			*/
			
			Route::get('/controls/edit/{edit_id}', [
				'uses'  => 'Controls@edit',
				'as'    => 'managevendorsproducts.edit'
			]);
	
			Route::match(['get', 'post'], '/controls/options', [
				'uses'  => 'Controls@options',
				'as'    => 'managevendorsproducts.options',
				'middleware' => 'verifypost:managevendorsproducts/controls/view'
			]);
			
		} );
		
		
		Route::group( array( 'prefix' => 'managevendorcategoriescommissions', 'namespace' => 'managevendorcategoriescommissions' ), function() {
	
			Route::get('/controls/view/', [
				'uses'  => 'Controls@view',
				'as'    => 'managevendorcategoriescommissions.view'
			]);
	
			Route::match(['get','post'], '/controls/add/', [
				'uses'  => 'Controls@add',
				'as'    => 'managevendorcategoriescommissions.add'
			]);
	
			Route::match(['get', 'post'], '/controls/save', [
				'uses'  => 'Controls@save',
				'as'    => 'managevendorcategoriescommissions.save',
				'middleware' => 'verifypost:managevendorcategoriescommissions/controls/view'
			]);
	
			Route::get('/controls/edit/{edit_id}', [
				'uses'  => 'Controls@edit',
				'as'    => 'managevendorcategoriescommissions.edit'
			]);
	
			Route::match(['get', 'post'], '/controls/options', [
				'uses'  => 'Controls@options',
				'as'    => 'managevendorcategoriescommissions.options',
				'middleware' => 'verifypost:managevendorcategoriescommissions/controls/view'
			]);
			
		} );
		
		
		
		Route::group( array( 'prefix' => 'managecsvproducts', 'namespace' => 'managecsvproducts' ), function(){
	
			Route::match(['get', 'post'], '/controls/view/', [
				'uses'  => 'Controls@view',
				'as'    => 'managecsvproducts.view'
			]);        
			
		} );
		
		Route::group( array( 'prefix' => 'managecyclecount', 'namespace' => 'managecyclecount' ), function(){
	
			Route::match(['get', 'post'], '/controls/view/', [
				'uses'  => 'Controls@view',
				'as'    => 'managecyclecount.view'
			]);        
			
		} );
	
		Route::group(array( 'prefix' => 'managemappingvendors', 'namespace' => 'managemappingvendors' ), function () {
	
			Route::get('/controls/view/', [
				'uses'  => 'Controls@view',
				'as'    => 'managemappingvendors.view'
			]);
	
			Route::get('/controls/add/', [
				'uses'  => 'Controls@add',
				'as'    => 'managemappingvendors.add'
			]);
	
			Route::get('/controls/edit/{edit_id}', [
				'uses'  => 'Controls@edit',
				'as'    => 'managemappingvendors.edit'
			]);
	
			Route::match(['get', 'post'], '/controls/save', [
				'uses'  => 'Controls@save',
				'as'    => 'managemappingvendors.save',
				'middleware' => 'verifypost:managemappingvendors/controls/view'
			]);
	
			Route::match(['get', 'post'], '/controls/options', [
				'uses'  => 'Controls@options',
				'as'    => 'managemappingvendors.options',
				'middleware' => 'verifypost:managemappingvendors/controls/view'
			]);
	
		});
		
		
		Route::group(array( 'prefix' => 'managecategory', 'namespace' => 'managecategory' ), function () {
	
			Route::get('/controls/view/', [
				'uses'  => 'Controls@view',
				'as'    => 'managecategory.view'
			]);
	
			Route::get('/controls/add/', [
				'uses'  => 'Controls@add',
				'as'    => 'managecategory.add'
			]);
	
			Route::get('/controls/edit/{edit_id}', [
				'uses'  => 'Controls@edit',
				'as'    => 'managecategory.edit'
			]);
	
			Route::match(['get', 'post'], '/controls/save', [
				'uses'  => 'Controls@save',
				'as'    => 'managecategory.save',
				'middleware' => 'verifypost:managecategory/controls/view'
			]);
	
			Route::match(['get', 'post'], '/controls/options', [
				'uses'  => 'Controls@options',
				'as'    => 'managecategory.options',
				'middleware' => 'verifypost:managecategory/controls/view'
			]);
			
			Route::match(['get', 'post'], '/controls/Treeview_get_category', [
				'uses'  => 'Controls@Treeview_get_category',
				'as'    => 'managecategory.Treeview_get_category'
			]);
			
			Route::match(['get', 'post'], '/controls/Treeview_get_category/{extra_condition}', [
				'uses'  => 'Controls@Treeview_get_category',
				'as'    => 'managecategory.Treeview_get_category'
			]);
			
			Route::match(['get', 'post'], '/controls/Treeview_move_category', [
				'uses'  => 'Controls@Treeview_move_category',
				'as'    => 'managecategory.Treeview_move_category'
			]);
			
			
	
		});
	
		Route::group(array( 'prefix' => 'managevendors', 'namespace' => 'managevendors' ), function () {
	
			Route::get('/controls/view/', [
				'uses'  => 'Controls@view',
				'as'    => 'managevendors.view'
			]);
	
			Route::get('/controls/add/', [
				'uses'  => 'Controls@add',
				'as'    => 'managevendors.add'
			]);
	
			Route::get('/controls/edit/{edit_id}', [
				'uses'  => 'Controls@edit',
				'as'    => 'managevendors.edit'
			]);
	
			Route::match(['get', 'post'], '/controls/save', [
				'uses'  => 'Controls@save',
				'as'    => 'managevendors.save',
				'middleware' => 'verifypost:managevendors/controls/view'
			]);
	
			Route::match(['get', 'post'], '/controls/options', [
				'uses'  => 'Controls@options',
				'as'    => 'managevendors.options',
				'middleware' => 'verifypost:managevendors/controls/view'
			]);
	
		});
	
	
		Route::group(array( 'prefix' => 'managecommissions', 'namespace' => 'managecommissions' ), function () {
	
			Route::get('/controls/view/', [
				'uses'  => 'Controls@view',
				'as'    => 'managecommissions.view'
			]);
	
			Route::get('/controls/edit/{edit_id}', [
				'uses'  => 'Controls@edit',
				'as'    => 'managecommissions.edit'
			]);
	
			Route::post('/controls/save', [
				'uses'  => 'Controls@save',
				'as'    => 'managecommissions.save',
				'middleware' => 'verifypost:managecommissions/controls/view'
			]);
	
	
		});
	
	
		Route::group(array( 'prefix' => 'manageaddress', 'namespace' => 'manageaddress' ), function () {
	
			Route::get('/controls/view/', [
				'uses'  => 'Controls@view',
				'as'    => 'manageaddress.view'
			]);
	
			Route::get('/controls/add/', [
				'uses'  => 'Controls@add',
				'as'    => 'manageaddress.add'
			]);
	
			Route::get('/controls/edit/{edit_id}', [
				'uses'  => 'Controls@edit',
				'as'    => 'manageaddress.edit'
			]);
	
			Route::post('/controls/save', [
				'uses'  => 'Controls@save',
				'as'    => 'manageaddress.save',
				'middleware' => 'verifypost:manageaddress/controls/view'
			]);
	
			Route::match(['get', 'post'], '/controls/options', [
				'uses'  => 'Controls@options',
				'as'    => 'manageaddress.options',
				'middleware' => 'verifypost:manageaddress/controls/view'
			]);
	
	
		});
	
	
	
	
	});
	
	
	
	
	Route::group(['middleware' => ['web', 'auth', 'verifyrolepermissions']], function () {
	
	
		Route::group(array( 'prefix' => 'Ajaxmethods' ), function () {
	
	
			Route::match(['get', 'post'], 'ajax_create_frontend_navigation/{is_ajax?}', [
				'uses'  => 'Ajaxmethods@ajax_create_frontend_navigation',
				'as'    => 'Ajaxmethods.ajax_create_frontend_navigation'
			]);
			
			Route::match(['get', 'post'], 'ajax_getFormatted_Price/{price?}', [
				'uses'  => 'Ajaxmethods@ajax_getFormatted_Price',
				'as'    => 'Ajaxmethods.ajax_getFormatted_Price'
			]);
			
			Route::match(['get', 'post'], 'ajax_getProducts_byVendors/{vendor_id?}', [
				'uses'  => 'Ajaxmethods@ajax_getProducts_byVendors',
				'as'    => 'Ajaxmethods.ajax_getProducts_byVendors'
			]);
			
			Route::match(['get', 'post'], 'ajax_getVendorProducts_ByVendorCategories/{is_ajax?}/{vendor_ids?}/{category_ids?}', [
				'uses'  => 'Ajaxmethods@ajax_getVendorProducts_ByVendorCategories',
				'as'    => 'Ajaxmethods.ajax_getVendorProducts_ByVendorCategories'
			]);
			
			Route::match(['get', 'post'], 'ajax_render_warehouse_location/{is_ajax?}/{fetch_mode?}', [
				'uses'  => 'Ajaxmethods@ajax_render_warehouse_location',
				'as'    => 'Ajaxmethods.ajax_render_warehouse_location'
			]);
			
			Route::match(['get', 'post'], 'ajax_submit_order_comment/{is_ajax?}/{order_id}', [
				'uses'  => 'Ajaxmethods@ajax_submit_order_comment',
				'as'    => 'Ajaxmethods.ajax_submit_order_comment'
			]);
			
			
		   
		});
	
	});
}
