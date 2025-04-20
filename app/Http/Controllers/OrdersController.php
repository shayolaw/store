<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    //
    public function index(){

        return response()->json(Order::all());
    }
    public function create(Request $request){
    $request->validate([
        'user_id' => 'required',
        'total_price' => 'required | decimal:0,2',
        'sub_total' => 'required',
        'total_tax' => 'required',
        'products' => 'required'
    ]);
    $order = $request->all();
    $products = $order['products'];
    $order['status'] = 'Created';
    $orders = Order::create($order);
    foreach($products as $product){
        $product = [
            "order_id"=>$orders->id,
            "product_id" => $product['id'],
            "quantity" => $product['quantity'],
            "price" => $product["price"]
        ];
        OrderItem::create($product);
    }
    return response()->json($orders);
    }
    public function update(Request $request,$id){
        $request->validate([
            'user_id' => 'required',
            'total_price' => 'required | decimal:0,2',
            'sub_total' => 'required',
            'total_tax' => 'required'
        ]);
        $order = $request->all();
        $order['status'] = 'Updated';
        $orders = Order::find($id);
        $orders->update($order);
        return response()->json($orders->fresh());
        }
    public function show($id){
       return response()->json(Order::with('order_items')->find($id));
    }
    public function delete($id){
        Order::find($id)->delete();
        return response()->json(["message"=>"Deleted Succesfully"]);
    }
}
