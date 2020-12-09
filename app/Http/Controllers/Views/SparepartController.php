<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SparepartController extends Controller
{
    public function edit($id)
    {
        return view("sparepart.update", compact("id"));
    }
}
