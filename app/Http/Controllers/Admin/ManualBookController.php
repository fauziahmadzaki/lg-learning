<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManualBookController extends Controller
{
    /**
     * Display the manual book / system guide.
     */
    public function index()
    {
        return view('admin.manual.index');
    }
}
