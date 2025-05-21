<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Log;
use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Webhook;

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

    Log::info("made it here");
    $line_items['line_items'] = $this->sortOrder($products);
    $line_items['mode'] = 'payment';
    $line_items['success_url'] = 'https://frontend.shayolaw.ca/shop';
    $line_items['cancel_url'] = 'https://frontend.shayolaw.ca/shop';
    $line_items['metadata'] = ['order_id'=> $orders->id];
    Log::info("made it there");
    // return response()->json($line_items);
    $stripe = new StripeClient(config('services.stripe.secret'));
    Log::info("did you make it here?");
    $checkout_session = $stripe->checkout->sessions->create($line_items);
    Log::info("what about here?");
    return response()->json($checkout_session);
    }


    public function update(Request $request,$id){
        $request->validate([
            'user_id' => 'required',
            'total_price' => 'required | decimal:0,2',
            'sub_total' => 'required',
            'total_tax' => 'required'
        ]);
        $order = $request->all();
        // $order['status'] = 'Updated';
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


    public function charge(){

        // Stripe::setApiKey(env('STRIPE_SECRET'));
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        // $customer = $stripe->customers->create(['name'=>'Daryl Doe', 'email'=>"daryldoe@gmail.com"]);
        $fake = [
            "line_items" => [
                [
                    "price_data"=> [
                        "currency"=> "cad",
                        "product_data"=> [
                            "name"=> "New product"
                ],
                        "unit_amount"=> '1699'
                ],
                    "quantity"=> 1
                ]
            ],
            "mode"=> "payment",
            "success_url"=> "https://frontend.shayolaw.ca/shop",
            "cancel_url"=> "https://api.shayolaw.ca/failed"
        ];
        $checkout_session = $stripe->checkout->sessions->create($fake);
          return redirect()->away($checkout_session->url);
        // return response()->json($checkout_session);
        // $amount = 20.00;
        // $email = "shayolaw@gmail.com";
        // $customer = Stripe::([
        //     'email' => $email,
        //     'source' => $request->input('stripeToken')
        // ]);

    }

    public function sortOrder($products){
        $arr = [];
        foreach($products as $product){
            $item = ['price_data' => [
                'currency' => 'cad',
                'product_data' => [
                  'name' => $product['name'],
                ],
            'unit_amount' => (int)((float)$product['price'] * 100)
            ],
        'quantity' => $product['quantity']
        ];
        $arr[] = $item;
        }
        return $arr;
    }
    public function handleWebhook(Request $request){
       $payload = $request->getContent();
       $sig_header = $request->header('Stripe-Signature');

       $endpoint_secret = config('services.stripe.webhook_secret');
       LOG::info("hit endpoint");
       try{
        $event = Webhook::constructEvent(
            $payload,$sig_header,$endpoint_secret
        );
       }catch (\UnexpectedValueException $e) {
        // Invalid payload
        return response()->json(['error' => 'Invalid payload'], 400);
    } catch (\Stripe\Exception\SignatureVerificationException $e) {
        // Invalid signature
        return response()->json(['error' => 'Invalid signature'], 400);
    }
    if ($event->type === 'checkout.session.completed') {
        $session = $event->data->object;
        $order_id = $session->metadata->order_id;
        $order = Order::find($order_id);
        $order->update([
            'status' => "Completed"
        ]);
        Log::info($order_id);
        Log::info("✅ Payment successful for session ID".json_encode($session));

        // You can update order status here
    }
    }
    public function failed(){
        return response()->json(['message'=>"Failed"]);
    }
    public function success(){
        return response()->json(['message'=>"Succeeded"]);
    }
}
