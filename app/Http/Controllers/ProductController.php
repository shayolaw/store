<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //
    public function index(){
        $products = Product::all();
        return response()->json($products);
    }
    public function show($id){
        $product = product::find($id);
        return response()->json($product);
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            // 'category_id' => 'required',
            // 'in_stock' => 'required',
        ]);
        $product = Product::create($request->all());
        return response()->json($product);
    }
    public function update(Request $request, $id){
        $product = Product::find($id);
        $product->update($request->all());
        return response()->json($product);
    }
    public function destroy($id){
        $product = Product::find($id);
        $product->delete();
        return response()->json(['message' => 'Product deleted']);
    }
    public function getForm($id = null){
        $products = Product::all();
        if(isset($id)){
            $product = Product::find($id);
            return view('layouts.products.product_form', ['product' => $product,'products'=>$products]);
        }
        return view('layouts.products.product_form')->with('products',$products);
    }
}
