<?php

namespace PacketPrep\Http\Controllers\Product;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;

use PaytmWallet;

class OrderController extends Controller
{

	 /**
     * Redirect the user to the Payment Gateway.
     *
     * @return Response
     */
    public function order()
    {
        $payment = PaytmWallet::with('receive');
        
        $user = new OrderController;
        $order = new OrderController;
        $order->id = 'ORDS59889748';
        $user->id = 'Krishnateja';
        $user->email = 'krishnatejags@gmail.com';
        $user->phonenumber = '8888888888';
        $order->amount = '100';

        $payment->prepare([
          'order' => $order->id,
          'user' => $user->id,
          'mobile_number' => $user->phonenumber,
          'email' => $user->email,
          'amount' => $order->amount,
          'callback_url' => 'https://corporate.onlinelibrary.co/payment/status'
        ]);
        return $payment->receive();
    }

    /**
     * Obtain the payment information.
     *
     * @return Object
     */
    public function paymentCallback()
    {
        $transaction = PaytmWallet::with('receive');
        
        $response = $transaction->response(); // To get raw response as object
        //Check out response parameters sent by paytm here -> http://paywithpaytm.com/developer/paytm_api_doc?target=interpreting-response-sent-by-paytm
        
        if($transaction->isSuccessful()){
          echo "Transaction Successful<br>";
          dd($response);
        }else if($transaction->isFailed()){
          echo "Transaction Failed<br>";
          dd($response);
        }else if($transaction->isOpen()){
          echo "Transaction Open<br>";
          dd($response);
        }
        $transaction->getResponseMessage(); //Get Response Message If Available
        //get important parameters via public methods
        $transaction->getOrderId(); // Get order id
        $transaction->getTransactionId(); // Get transaction id
    }    
}
