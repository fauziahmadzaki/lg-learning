<?php

namespace App\Http\Controllers;

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
