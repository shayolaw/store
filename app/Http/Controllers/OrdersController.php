<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    //
    public function index(){

        return response()->json(Orders::all());
    }
    public function create(Request $request){
    $request->validate([
        'user_id' => 'required',
        'total_price' => 'required | decimal:0,2',
        'sub_total' => 'required',
        'total_tax' => 'required'
    ]);
    $order = $request->all();
    $order['status'] = 'Created';
    $orders = Orders::create($order);
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
        $orders = Orders::find($id);
        $orders->update($order);
        return response()->json($orders->fresh());
        }
    public function show($id){
       return response()->json(Orders::find($id));
    }
    public function delete($id){
        Orders::find($id)->delete();
        return response()->json(["message"=>"Deleted Succesfully"]);
    }
}
