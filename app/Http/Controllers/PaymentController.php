<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Redirect;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use App\Order;

class PaymentController extends Controller
{
    //
    /**
     * Show the informative contents to user.
     *
     * @param  int  $slug
     * @return View
     */
    public function index()
    {
        return view('checkout.index');    
    }

    
    public function payment(Request $request)
    {        
        $success = true;
        $message = "Payment Failed";
        $input = $request->all(); 
        $status_class = 'alert-danger';
        if (empty($_POST['razorpay_payment_id']) === false)
        {
            $api = new Api('rzp_test_8ktwuyPk6uitOP', 'aO9cQzFr8S9o1Pk87dm45bmd');

            try
            {
                // Please note that the razorpay order ID must
                // come from a trusted source (session here, but
                // could be database or something else)
                
                $attributes = array(
                    'razorpay_order_id' => session()->get('razorpay_order_id'),
                    'razorpay_payment_id' => $_POST['razorpay_payment_id'],
                    'razorpay_signature' => $_POST['razorpay_signature']
                );

                $api->utility->verifyPaymentSignature($attributes);
            }
            catch(SignatureVerificationError $e)
            {
                $success = false;
                $message = 'Razorpay Error : ' . $e->getMessage();
            }
        }

        if ($success === true)
        {
            // Save the razorpay_order_id razorpay_payment_id and all other details to database here.
            $message ="";
            $message .= "Payment Successful."; 
            $message .= "";
            $message .= "Your payment for the order ".session()->get('razorpay_order_id')." was successful, Payment ID: ".$_POST['razorpay_payment_id'];
            $status_class = 'alert-success';

            Order::where('rozar_pay_order_id',session()->get('razorpay_order_id'))->update(['status'=>'ordered','rozar_pay_response'=>json_encode($attributes)]);
            session()->forget('cart');
        }   
        else
        {
            $status_class = 'alert-danger';
            $message = "Your payment failed" .$error;
        }

        return view('payment.index',compact('status_class','message'));    
    }
}
