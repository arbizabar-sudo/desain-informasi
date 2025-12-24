<?php

use Illuminate\Support\Facades\Route;

// Debug routes for notifications - only use locally
Route::get('/debug/notify', function () {
    return view('debug.notify');
});
