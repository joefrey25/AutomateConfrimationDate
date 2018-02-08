<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductsController extends Controller
{

    public function index() 
    {
        $product = new Product;
        $products = $product->getAvailableProducts()->get();
        return view('products.index', compact('products'));
    }
    
    public function create()
    {
        return view('products.create');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'productName' => 'required',
            'productDescription' => 'required',
            'productImage' => 'required',
        ]);

        if ($request->hasFile('productImage')) {
            $file = $request->file('productImage');
            $fileName = $file->getClientOriginalName() . '.' . $file->getClientOriginalExtension();

            $path = 'uploads/' . $fileName;
            $file = $file->move($path, $fileName);
        }

        Product::create([
            'name' => $request->productName, 
            'description' => $request->productDescription,
            'image' => $path, 
        ]);
        return redirect('/products');
    }
}
