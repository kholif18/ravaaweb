<?php

namespace App\Controllers;

class DetailProduct extends BaseController
{
    public function index()
    {
        return view('frontend/detail-product', [
            'title' => 'Ravaa Creative - Setail'
        ]);
    }
}