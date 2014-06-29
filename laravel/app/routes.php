<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

Route::get('/', function() {
    global $app;
    return "hola";
});

//Route::get('/', 'Login@checkLogin');

Route::get('/login', 'Login@form');
Route::post('/login', 'Login@login');
Route::any('/logout', 'Login@logout');

Route::get('/main', array('before' => 'loggedUser', 'uses' => 'Main@mainMenu'));
//Route::get('/main', 'Main@mainMenu');

//Route::get('test/', 'Login@test');
Route::get('test/', array('before' => 'loggedUser', 'uses' => 'Login@test'));

Route::get('sysdate', 'Login@sysdate');

