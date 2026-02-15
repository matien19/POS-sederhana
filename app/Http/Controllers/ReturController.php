<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use function Termwind\render;

class ReturController extends Controller
{
    public function index()
    {
        return view('admin.retur');
    }
}
