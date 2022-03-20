<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\{
    AuthController
};

Route::group(['prefix' => 'admin'], function () {

    //////////// auth ///////////
    Route::any('login',[AuthController::class,'login'])->name('admin.login');

    Route::group(['middleware' =>'admin'],function(){

        //////////// auth ///////////
        Route::get('logout',[AuthController::class,'logout'])->name('admin.logout');


        //////////// index ///////////
        Route::view('/','admin/index')->name('admin.index');
    });

});
