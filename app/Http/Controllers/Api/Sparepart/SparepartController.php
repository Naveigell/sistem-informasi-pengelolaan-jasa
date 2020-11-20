<?php

namespace App\Http\Controllers\Api\Sparepart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SparepartController extends Controller {
    public function index()
    {
        return view('sparepart.index');
    }
}
