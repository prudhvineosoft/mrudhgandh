<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;
use App\Category;

class ProductsController extends Controller
{
    
    public function index(){
        $products = Products::paginate(16);
        return view('products.index',compact('products'));
    }

    public function details($id){
        $product = Products::find($id);
        $similar_products = Products::where('id','!=',$id)->where('is_active',1)->inRandomOrder()->limit(5)->get();
        return view('products.details',compact('product','similar_products'));
    }
   

    public function productByCategory($slug){
        $category = Category::where('slug',$slug)->first();
        if($category){
            $products = Products::where('category_id',$category->id)->paginate(16);
            return view('products.index',compact('products','category'));
        }else{
            return redirect('/');
        }
        
    }
}
