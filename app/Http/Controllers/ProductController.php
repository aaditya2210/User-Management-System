<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function explorer()
    {
        // Simulate maintenance mode
        $maintenance = true;
        
        return view('products.explorer', compact('maintenance'));
    }
}