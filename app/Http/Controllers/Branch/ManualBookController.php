<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class ManualBookController extends Controller
{
    public function index(Branch $branch)
    {
        return view('branch.manual.index', compact('branch'));
    }
}
