<?php

use App\Http\Controllers\categoryController;
use App\Http\Controllers\customerControllerapi;
use App\Http\Controllers\employeecontrollerapi;
use App\Http\Controllers\orderControllerapi;
use App\Http\Controllers\orderDetailControllerapi;
use App\Http\Controllers\paymentControllerapi;
use App\Http\Controllers\productControllerapi;
use App\Http\Controllers\productImageControllerapi;
use App\Http\Controllers\userControllerapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//  ------------ User Route -----------

Route::get('/readuser',[userControllerapi::class,'ReadUser']);
Route::get('/adduser',[userControllerapi::class,'userAdd']);
Route::post('/getuser',[userControllerapi::class,'getUser']);
Route::put('/edituser',[userControllerapi::class,'editUser']);
Route::delete('/deleteuser',[userControllerapi::class,'deleteUser']);

//  ------------ Products Route -----------
Route::get('/getallproduct',[productControllerapi::class,'GetAllProduct']);
Route::get('/getProduct',[productControllerapi::class,'GetProduct']);
Route::post('/addproduct',[productControllerapi::class,'AddProduct']);
Route::put('/editproduct/{id}',[productControllerapi::class,'EditProduct']);
Route::delete('/deleteproduct/{id}',[productControllerapi::class,'DeleteProduct']);

//  ------------ Category Route -----------
Route::get('/readcategory',[categoryController::class,'ReadCategory']);
Route::get('/getcategory',[categoryController::class,'GetCategory']);
Route::post('/addcategory',[categoryController::class,'AddCategory']);
Route::put('/editcategory/{id}',[categoryController::class,'EditCategory']);
Route::delete('/deletecategory/{id}',[categoryController::class,'DeleteCategory']);

//  ------------ Order Route -----------
Route::get('/readorder',[orderControllerapi::class,'ReadOrder']);
Route::get('/getorder', [OrderControllerApi::class, 'GetOrder']);
Route::post('/addorder',[orderControllerapi::class,'AddOrder']);
Route::put('/editorder',[orderControllerapi::class,'EditOrder']);
Route::delete('/deleteorder',[orderControllerapi::class,'DeleteOrder']);

//  ------------ Order Detail Route -----------
Route::get('/readorderdetail',[orderDetailControllerapi::class,'ReadOrderDetail']);
Route::get('/getorderdetail',[orderDetailControllerapi::class,'GetOrderDetail']);
Route::post('/addorderdetail',[orderDetailControllerapi::class,'AddOrderDetail']);
Route::put('/editorderdetail',[orderDetailControllerapi::class,'EditOrderDetail']);
Route::delete('/deleteorderdetail',[orderDetailControllerapi::class,'DeleteOrderDetail']);

//  ------------ Image Route -----------
Route::get('/readimage',[productImageControllerapi::class,'Readimage']);
Route::get('/getimage',[productImageControllerapi::class,'Getimage']);
Route::post('/addimage',[productImageControllerapi::class,'Addimage']);
Route::put('/editimage',[productImageControllerapi::class,'Editimage']);
Route::delete('/deleteimage',[productImageControllerapi::class,'Deleteimage']);

//  ------------ Employee Route -----------
Route::get('/reademployee',[employeecontrollerapi::class,'ReadEmployee']);
Route::get('/getemployee',[employeecontrollerapi::class,'GetEmployee']);
Route::post('/addemployee',[employeecontrollerapi::class,'AddEmployee']);
Route::put('/editemployee',[employeecontrollerapi::class,'EditEmployee']);
Route::delete('/deleteemployee',[employeecontrollerapi::class,'DeleteEmployee']);

//  ------------ Payment method Route -----------
Route::get('/readpayment',[paymentControllerapi::class,'Readpayment']);
Route::get('/getpayment',[paymentControllerapi::class,'Getpayment']);
Route::post('/addpayment',[paymentControllerapi::class,'Addpayment']);
Route::put('/editpayment/{id}',[paymentControllerapi::class,'Editpayment']);
Route::delete('/deletepayment/{id}',[paymentControllerapi::class,'Deletepayment']);

//  ------------  Customer Route -----------
Route::get('/readcustomer',[customerControllerapi::class,'ReadCustomer']);
Route::get('/getcustomer',[customerControllerapi::class,'GetCustomer']);
Route::post('/addcustomer',[customerControllerapi::class,'AddCustomer']);
Route::put('/editcustomer/{id}',[customerControllerapi::class,'EditCustomer']);
Route::delete('/deletecustomer/{id}',[customerControllerapi::class,'DeleteCustomer']);