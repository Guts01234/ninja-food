<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RedirectController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{shortCode}', RedirectController::class)->where('shortCode', '[a-zA-Z0-9]{6}');

