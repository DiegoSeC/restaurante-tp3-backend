<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['prefix' => 'api'], function () use($app) {

    //waybills
    $app->get('waybills', 'WaybillController@index');
    $app->post('waybills', 'WaybillController@post');
    $app->put('waybills/batch-update', 'WaybillController@batchUpdate');
    $app->get('waybills/{uuid}', 'WaybillController@get');
    $app->put('waybills/{uuid}', 'WaybillController@put');
    $app->patch('waybills/{uuid}', 'WaybillController@patch');
    $app->delete('waybills/{uuid}', 'WaybillController@delete');
    $app->get('carriers/{uuid}/waybills', 'WaybillController@getByCarrierUuid');

    //products
    $app->get('products', 'ProductController@index');

    //warehouses
    $app->get('warehouses', 'WarehouseController@index');

    //orders
    $app->get('orders', 'OrderController@index');
    $app->get('orders/{uuid}', 'OrderController@get');
    $app->post('orders', 'OrderController@post');
    $app->put('orders/{uuid}', 'OrderController@put');
    $app->patch('orders/{uuid}', 'OrderController@patch');
    $app->delete('orders/{uuid}', 'OrderController@delete');


    //carriers
    $app->get('carriers', 'CarrierController@index');

    //trucks
    $app->get('trucks', 'TruckController@index');

    //quotation-requests
    $app->get('quotation-requests', 'QuotationRequestController@index');
    $app->get('quotation-requests/{uuid}', 'QuotationRequestController@get');
    $app->post('quotation-requests', 'QuotationRequestController@post');
    $app->put('quotation-requests/{uuid}', 'QuotationRequestController@put');
    $app->patch('quotation-requests/{uuid}', 'QuotationRequestController@patch');
    $app->delete('quotation-requests/{uuid}', 'QuotationRequestController@delete');

    //transfer-guides
    $app->get('transfer-guides', 'TransferGuideController@index');
    $app->get('transfer-guides/{uuid}', 'TransferGuideController@get');
    $app->post('transfer-guides', 'TransferGuideController@post');
    $app->put('transfer-guides/{uuid}', 'TransferGuideController@put');
    $app->patch('transfer-guides/{uuid}', 'TransferGuideController@patch');
    $app->delete('transfer-guides/{uuid}', 'TransferGuideController@delete');

    //suppliers
    $app->get('suppliers', 'SupplierController@index');
    $app->get('suppliers/{uuid}', 'SupplierController@get');

    //test
    $app->get('test/email', 'TestController@email');

    //employees
    $app->get('employees/{uuid}', 'EmployeeController@get');

    //users
    $app->get('users/{uuid}/employee', 'EmployeeController@getByUserUuid');

});
