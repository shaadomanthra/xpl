<?php

namespace PacketPrep\Http\Controllers\Product;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Product\Order;


class OrderController extends Controller
{

	 /**
     * Redirect the user to the Payment Gateway.
     *
     * @return Response
     */
    public function order(Request $request)
    {
      //dd($request->all());
        $user = \auth::user();
        $o = Order::where('client_id',$user->client_id())->where(function ($query) {
                $query->where('package', '=', 'flex')
                      ->orWhere('package', '=', 'basic')
                      ->orWhere('package', '=', 'pro')
                      ->orWhere('package', '=', 'ultimate');
            })->first();

        if($o && $request->package!='credit'){
          return view('appl.product.pages.checkout_denail')->with('order',$o);
        }
        if($request->type=='paytm'){
          
          $order = new Order();
          $order->order_id = 'ORD_'.rand(100000,999999);
          $order->client_id = $user->client_id();
          $order->user_id = $user->id;
          $order->txn_amount = $request->txn_amount;
          $order->status=0;
          $order->package = $request->package;

          if($request->package=='flex')
          {
            $order->credit_count = 200;
            $order->credit_rate = 200;
          }elseif($request->package=='basic'){
            $order->credit_count = 200;
            $order->credit_rate = 175;
          }elseif($request->package=='pro')
          {
            $order->credit_count = 500;
            $order->credit_rate = 150;
          }elseif($request->package=='ultimate'){
            $order->credit_count = 1000;
            $order->credit_rate = 125;
          }else{
            $order->credit_count = $request->credit_count;
            $order->credit_rate = $request->credit_rate;
            $order->txn_amount = $request->credit_count*$request->credit_rate;
          }

          $order->save();


          $data = 'ORDER_ID='.$order->order_id.'&CUST_ID='.$order->client_id.'&INDUSTRY_TYPE_ID=Retail109&CHANNEL_ID=WEB&TXN_AMOUNT='.$order->txn_amount;
          
          header('Location: '.url('/').'/pgRedirect.php?'.$data);
        }else{

          $user = \auth::user();
          $order = new Order();
          $order->order_id = 'ORD_'.rand(100000,999999);
          $order->client_id = $user->client_id();
          $order->user_id = $user->id;
          $order->txn_amount = $request->txn_amount;
          $order->status=1;
          $order->package = $request->package;

          if($request->package=='flex')
          {
            $order->credit_count = 200;
            $order->credit_rate = 200;
          }elseif($request->package=='basic'){
            $order->credit_count = 200;
            $order->credit_rate = 175;
          }elseif($request->package=='pro')
          {
            $order->credit_count = 500;
            $order->credit_rate = 150;
          }elseif($request->package=='ultimate'){
            $order->credit_count = 1000;
            $order->credit_rate = 125;
          }else{
            $order->credit_count = $request->credit_count;
            $order->credit_rate = $request->credit_rate;
          }

          $order->payment_mode = 'cheque';
          $order->txn_id = $request->cheque;

          $order->save();
          

          return view('appl.product.pages.checkout_success')->with('order',$order);
        }
        
    }

    /**
     * Obtain the payment information.
     *
     * @return Object
     */
    public function callback()
    {
        
      header("Pragma: no-cache");
      header("Cache-Control: no-cache");
      header("Expires: 0");

      // following files need to be included
      require_once("./lib/config_paytm.php");
      require_once("./lib/encdec_paytm.php");

      $paytmChecksum = "";
      $paramList = array();
      $isValidChecksum = "FALSE";

      $paramList = $_POST;
      $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

      //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
      $isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.


      if($isValidChecksum == "TRUE") {
        //echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
        if (isset($_POST) && count($_POST)>0 )
          { 
            $order = Order::where('order_id',$_POST['ORDERID'])->first();
            
            $order->payment_mode = $_POST['PAYMENTMODE'];
            $order->bank_txn_id = $_POST['BANKTXNID'];
            $order->bank_name = $_POST['BANKNAME'];
            $order->txn_id = $_POST['TXNID'];
            if ($_POST["STATUS"] == "TXN_SUCCESS")
            $order->status = 1;
            else
            $order->status = 2;

            $order->save();
          }

        if ($_POST["STATUS"] == "TXN_SUCCESS") {
          return view('appl.product.pages.checkout_success')->with('order',$order);
          //Process your transaction here as success transaction.
          //Verify amount & order id received from Payment gateway with your application's order id and amount.
        }
        else {
          return view('appl.product.pages.checkout_txn_failure');
        }

        
        

      }
      else {
        return view('appl.product.pages.checkout_checksum_failure');
        //Process transaction as suspicious.
      }

    //return view('appl.product.pages.checkout_success');
    }    
}
