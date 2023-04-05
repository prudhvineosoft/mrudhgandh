<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;
use App\User;
use App\Order;
use App\OrderItem;
use Mail;
use Auth;
use Hash;
use Illuminate\Support\Str;
use Razorpay\Api\Api;

class CartsController extends Controller
{
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function cart()
    {
        $cart = session()->get('cart');
        return view('cart.index');
    }
   
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function addToCart(Request $request)
    {
        $id = $request->id;
        $product = Products::findOrFail($id);
        if($product){
            $cart = session()->get('cart', []);
    
            if(isset($cart[$id])) {
                $cart[$id]['quantity']++;
            } else {
                $cart[$id] = [
                    "id" => $product->id,
                    "name" => $product->name,
                    "quantity" => 1,
                    "sale_price" => $product->sale_price,
                    "image" => $product->image
                ];
            }
            session()->put('cart', $cart);
            return response()->json(['message' => 'Product added to cart successfully!','count'=>count($cart)]);
        }  
        
    }


    public function placeOrder(Request $request)
    {
        $cart = session()->get('cart');
        if($cart){

            $first_name = $request->first_name;
            $last_name = $request->last_name;
            $email = $request->email;
            $mobile = $request->mobile;
            $address1 = $request->address1;
            $address2 = $request->address2;
            $country = $request->country;
            $city = $request->city;
            $state = $request->state;
            $zip_code = $request->zip_code;
            $product_ids = $request->products;

            $user = User::where('email',$email)->first();
            if(!$user){
                $user = new User();
                $user->name = $first_name." ".$last_name;
                $user->email = $email;
                $user->mobile = $mobile;
                $password = Str::random(10);
                $user->password = Hash::make($password);
                $user->save();
                
                // SEND EMAIL TO USER WITH LOGIN DETAILS
                $details = [
                    'first_name' => $first_name,
                    'email' => $email,
                    'password' => $password,
                ];
                Mail::to($email)->send(new \App\Mail\WelcomeMail($details));
            }
            Auth::login($user);
            // Calculate the Total Order Amount
            $total = 0;
            foreach($cart as $id => $details){
                $total += $details['sale_price'] * $details['quantity'];
            }        
        
            // Insert Record in Orders Table
            $order = new Order();
            $order->user_id = Auth::user()->id;
            $order->firstname = $first_name;
            $order->lastname = $last_name;
            $order->email = $email;
            $order->mobile = $mobile;
            $order->address1 = $address1;
            $order->address2 = $address2;
            $order->country = $country;
            $order->city = $city;
            $order->state = $state;
            $order->zipcode = $zip_code;
            $order->subtotal = $total;
            $order->total = $total;
            $order->save();

            // insert records in orderItems
            foreach($cart as $id => $details){
                $orderItem = new OrderItem();
                $orderItem->product_id = $details['id'];
                $orderItem->order_id = $order->id;
                $orderItem->price = $details['sale_price'];
                $orderItem->quantity = $details['quantity'];
                $orderItem->save();
            }


            $api = new Api('rzp_test_8ktwuyPk6uitOP', 'aO9cQzFr8S9o1Pk87dm45bmd');
            $orderData = [
                'receipt'         => $order->id,
                'amount'          => $total * 100, // 2000 rupees in paise
                'currency'        => 'INR',
                'payment_capture' => 1 // auto capture
            ];

            $razorpayOrder = $api->order->create($orderData);
            $razorpayOrderId = $razorpayOrder['id'];

            $order->rozar_pay_order_id = $razorpayOrderId;
            $order->save();

            session()->put('razorpay_order_id', $razorpayOrderId);
            $displayAmount = $amount = $orderData['amount'];


            $data = [
                "key"               => 'rzp_test_8ktwuyPk6uitOP',
                "amount"            => $amount,
                "name"              => 'MRUDGANDHMUDPOTTERY',
                "description"       => "MRUDGANDHMUDPOTTERY",
                "image"             => "https://s29.postimg.org/r6dj1g85z/daft_punk.jpg",
                "prefill"           => [
                    "name"              => $first_name,
                    "email"             => $email,
                    "contact"           => $mobile,
                ],
                "notes"             => [
                "address"           => $address1,
                "merchant_order_id" => $order->id,
                ],
                "theme"             => [
                "color"             => "#F37254"
                ],
                "order_id"          => $razorpayOrderId,
            
            ];

            $json = json_encode($data);
            
            return response()->json(['data' => $json]);
        }    
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['sale_price'] * $item['quantity'];
            }
            return response()->json(['count'=>count($cart),'cart'=>$cart,'total'=>$total]);
        }
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }
}
