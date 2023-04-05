<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Order;

class OrdersController extends Controller
{
    
    public function index(){
        $orders = Order::all();
        return view('admin.orders.index',compact('orders'));
    }
    public function details($id){
        $order = Order::with('orderItems')->find($id);
        if($order)
        return view('admin.orders.details',compact('order'));
    }
    

}
