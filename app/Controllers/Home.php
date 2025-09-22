<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('frontend/home', [
            'title' => 'Ravaa Creative - Promo & Produk Terbaru'
        ]);
    }
}