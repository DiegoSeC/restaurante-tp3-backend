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

});
