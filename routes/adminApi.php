<?php

use Illuminate\Support\Facades\Route;


Route::group(['middleware'=>['api','changeLanguage'],'namespace'=>'Admin'],function (){
// this route has prefixed => admin-api
    //// login admin
    Route::post('login','AuthController@login');
    Route::group(['middleware'=>['auth:admin-api']],function (){
        ///// admin content (get and delete user)
        Route::get('getUsers','AuthController@getUsers');
        Route::post('deleteUser/{id}','AuthController@deleteUser');
        //////  route logout admin
        Route::post('logoutAdmin','AuthController@logout');
    });
});
