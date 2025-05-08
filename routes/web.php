<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Jobs\SendWelcomeEmail;

Route::get('/send-email', function () {
    SendWelcomeEmail::dispatch('test@example.com');
    return 'Email job dispatched!';
});
