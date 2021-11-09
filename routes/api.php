<?php

use Illuminate\Support\Facades\Route;


Route::group(['middleware'=>['api','changeLanguage'],'namespace'=>'User'],function (){
    ////// route User
    Route::post('registerUser','AuthController@register');
    Route::post('loginUser','AuthController@login');

    Route::group(['middleware' =>['auth:api'] ],function(){
        ////////// route Posts  //////////
        Route::get('getPosts','PostController@getPosts');
        Route::post('createPost','PostController@create');
        Route::post('updatePost/{id}','PostController@updatePost');
        Route::post('deletePost/{id}','PostController@deletePost');

        ///// logout user/////
        Route::post('logoutUser','AuthController@logout');
    });
});



