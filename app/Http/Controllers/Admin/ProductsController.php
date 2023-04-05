<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Products;
use App\ProductDetails;
use App\Category;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductsController extends Controller
{

    public function index()
    {
        $products = Products::all();
        return view('admin.products.index', compact('products'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function edit($id)
    {
        $product = Products::find($id);
        $categories = Category::all();
        if ($product) {
            return view('admin.products.edit', compact('product', 'categories'));
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'qty' => 'required',
            'price' => 'required',
            'sale_price' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $name = $request->name;
        $category_id = $request->category_id;
        $qty = $request->qty;
        $price = $request->price;
        $sale_price = $request->sale_price;
        $description = $request->description;
        $image = $request->image;
        $multiple_images = $request->multiple_images;
        $is_featured = $request->is_featured;

        $product = new Products();
        $product->name = $name;
        $product->category_id = $category_id;
        $product->quantity = $qty;
        $product->price = $price;
        $product->sale_price = $sale_price;
        $product->description = $description;
        $product->featured = $is_featured ? 1 : 0;
        $product->save();

        $image = $request->file('image');
        $storedName = $product->id . '.' . $image->extension();
        $storagepath = storage_path('app/public');
        \Storage::disk('public')->makeDirectory('images/' . $product->id);
        $img = Image::make($image->path());
        $img->resize(700, 600)->save($storagepath . '/images/' . $product->id . '/' . $storedName);

        // \Storage::disk('public')->put('/images/'.$product->id.'/'.$storedName,  \File::get($image));

        $product->image = '/images/' . $product->id . '/' . $storedName;
        $product->save();


        if ($multiple_images) {
            foreach ($multiple_images as $key => $multiple_image) {
                $product_details = new ProductDetails();
                $product_details->product_id = $product->id;
                $product_details->save();

                $storagepath = storage_path('app/public');
                $storedName = $product_details->id . '.' . $multiple_image->extension();
                \Storage::disk('public')->makeDirectory('images/' . $product->id . '/multi');
                $img1 = Image::make($multiple_image->path());
                $img1->resize(700, 600)->save($storagepath . '/images/' . $product->id . '/multi/' . $storedName);

                $product_details->full = '/images/' . $product->id . '/multi/' . $storedName;
                $product_details->save();
            }
        }

        return redirect()->back()->with('success', 'Product added successfully.');
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        $category_id = $request->category_id;
        $qty = $request->qty;
        $price = $request->price;
        $sale_price = $request->sale_price;
        $description = $request->description;
        $multiple_images = $request->multiple_images;
        $image = $request->image;
        $is_featured = $request->is_featured;

        $product = Products::find($id);
        if ($product) {
            $product->name = $name;
            $product->category_id = $category_id;
            $product->quantity = $qty;
            $product->price = $price;
            $product->sale_price = $sale_price;
            $product->description = $description;
            $product->featured = $is_featured ? 1 : 0;
            $product->save();
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $storedName = $product->id . '.' . $image->extension();
                $storagepath = storage_path('app/public');
                \Storage::disk('public')->makeDirectory('images/' . $product->id);
                $img = Image::make($image->path());
                $img->resize(700, 600)->save($storagepath . '/images/' . $product->id . '/' . $storedName);

                $product->image = '/images/' . $product->id . '/' . $storedName;
                $product->save();
            }

            if ($multiple_images) {
                foreach ($multiple_images as $key => $multiple_image) {
                    $product_details = new ProductDetails();
                    $product_details->product_id = $product->id;
                    $product_details->save();

                    $storagepath = storage_path('app/public');
                    $storedName = $product_details->id . '.' . $multiple_image->extension();
                    \Storage::disk('public')->makeDirectory('images/' . $product->id . '/multi');
                    $img1 = Image::make($multiple_image->path());
                    $img1->resize(700, 600)->save($storagepath . '/images/' . $product->id . '/multi/' . $storedName);

                    $product_details->full = '/images/' . $product->id . '/multi/' . $storedName;
                    $product_details->save();
                }
            }

            return redirect()->back()->with('success', 'Product updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Product not found.');
        }
    }


    public function delete(Request $request)
    {
        $product_id = $request->product_id;
        $product = Products::find($product_id);
        if ($product) {

            $storagepath = storage_path('app/public');
            if (file_exists($storagepath . '/images/' . $product->id)) {
                \Storage::disk('public')->deleteDirectory('/images/' . $product->id);
            }
            if ($product->details) {
                $product->details->each->delete();
            }

            $product->delete();
            return redirect()->back()->with('success', 'Product deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Product not found.');
        }
    }
}
