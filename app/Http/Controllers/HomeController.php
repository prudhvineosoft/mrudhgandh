<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;
use Mail;

class HomeController extends Controller
{
    public function index()
    {
        $products = Products::where('featured',1)->get();
        return view('welcome',compact('products'));
        
    }
   
}
