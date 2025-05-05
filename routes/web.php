<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});


//catch-all route
Route::get('/{any}', function () {
    return view('app'); // SPA entry point
})->where('any', '.*');
