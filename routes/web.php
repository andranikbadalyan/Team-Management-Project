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
Route::get('/', function () {
    if( Auth::check() ){
        return redirect()->route('admin');
    }
    return redirect()->route('login');
});

Auth::routes();
Route::resource('/users', 'UserController')->only(['index', 'store', 'update', 'destroy']);
Route::resource('/teams', 'TeamController')->only(['index', 'store', 'update', 'destroy']);
Route::resource('/teams/{team}/players', 'PlayerController')->only(['index', 'store', 'update', 'destroy']);




/*
|--------------------------------------------------------------------------
| Vue Routes
|--------------------------------------------------------------------------
|
| Any route that begins with /admin should be left for vue router to handle.
|
*/
Route::get('/admin', function(){
    return view('layouts.app');
})->name('admin')->middleware('auth');

Route::any('/admin/{all}', function(){
    return view('layouts.app');
})->where(['all' => '.*'])->middleware('auth');
