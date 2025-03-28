<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;

class RestaurantsController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::paginate(10);
        return view('main.restaurants', compact('restaurants'));
    }
}
