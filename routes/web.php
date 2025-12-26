<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend/home');
});

Route::get('/layanan', function () {
    return view('frontend/layanan');
});

Route::get('/product', function () {
    return view('frontend/product');
});

Route::get('/detail-product', function () {
    return view('frontend/detail-product');
});

Route::get('/portofolio', function () {
    return view('frontend/portofolio');
});

Route::get('/software-house', function () {
    return view('frontend/software-house');
});

Route::get('/contact', function () {
    return view('frontend/contact');
});
