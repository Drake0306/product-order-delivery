<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $page = 'Dash Data';
        return view('dashboard', compact('page'));
    }
}
