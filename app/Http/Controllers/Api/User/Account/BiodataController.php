<?php

namespace App\Http\Controllers\Api\User\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BiodataController extends Controller {
    public function index() {
        return view('user.account.biodata');
    }
}
