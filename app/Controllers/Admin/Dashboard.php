<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        return view('backend/layouts/main', [
            'content' => view('backend/dashboard')
        ]);
    }
}
