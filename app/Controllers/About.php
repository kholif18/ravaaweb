<?php

namespace App\Controllers;

class About extends BaseController
{
    public function index()
    {
        return view('frontend/about', [
            'title' => 'Ravaa Creative - About'
        ]);
    }
}