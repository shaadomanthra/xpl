<?php

namespace PacketPrep\Http\Controllers\Product;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Product\Order;
use Illuminate\Support\Facades\Mail;
use PacketPrep\Mail\OrderSuccess;
use PacketPrep\Mail\OrderCreated;
use PacketPrep\Models\Product\Client;
use PacketPrep\Models\Course\Course;
use PacketPrep\Models\Product\Product;
use PacketPrep\User;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{



    public function checkout(Request $request){

      $product = $request->get('product');
      $test = $request->get('test');

      if($product){
        $product = Product::where('slug',$product)->first();

          if(!$product)
            return view('appl.product.pages.checkout-invalid');
          else{
              
              return view('appl.product.pages.checkout')->with('product',$product);
          }

      }


    }

	 /**
     * Redirect the user to the Payment Gateway.
     *
     * @return Response
     */
    public function order(Request $request)
    {
        //dd($request->all());
        $user = \auth::user();
        $o = Order::where('product_id',$request->get('product_id'))
              ->where('user_id',$user->id)->first();


        if($o)
        if($o->status == 1 ){
          return view('appl.product.pages.checkout_denail')->with('order',$o);
        }
        if($request->type=='paytm'){
          
          $order = new Order();
          $order->order_id = 'ORD_'.rand(100000,999999);

          $o_check = Order::where('order_id',$order->order_id)->first();
          while($o_check){
            $order->order_id = 'ORD_'.rand(100000,999999);
            $o_check = Order::where('order_id',$order->order_id)->first();
            if(!$o_check)
              break;
          }

          $order->user_id = $user->id;
          $order->txn_amount = $request->txn_amount;
          $order->status=0;
          $order->product_id = $request->get('product_id');

          
           //dd($order);
          $order->save();
          $order->payment_status = 'Pending';
          
          //Mail::to($user->email)->send(new OrderSuccess($user,$order));
        
          //return view('appl.product.pages.checkout_success')->with('order',$order);


          $data = 'ORDER_ID='.$order->order_id.'&CUST_ID='.$order->user_id.'&INDUSTRY_TYPE_ID=Retail109&CHANNEL_ID=WEB&TXN_AMOUNT='.$order->txn_amount;
          
          header('Location: '.url('/').'/pgRedirect.php?'.$data);
        }else{

        }
        Mail::to($user->email)->send(new OrderCreated($user,$order));
        
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
            $user = User::where('id',$order->user_id)->first();

            $order->payment_mode = $_POST['PAYMENTMODE'];
            $order->bank_txn_id = $_POST['BANKTXNID'];
            $order->bank_name = $_POST['BANKNAME'];
            $order->txn_id = $_POST['TXNID'];
            if ($_POST["STATUS"] == "TXN_SUCCESS"){
              $order->status = 1;
              $valid_till = $valid_till = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s") .' + '.(24)*31).' days'));
              if(!$user->products->contains($product->id))
              $user->products()->attach($order->product_id,['validity'=>24,'created_at'=>date("Y-m-d H:i:s"),'valid_till'=>$valid_till,'status'=>1])
            }
            else{
              $order->status = 2;
              
            }

            $order->save();
          }

        if ($_POST["STATUS"] == "TXN_SUCCESS") {
          $order->payment_status = 'Successful';
          Mail::to($user->email)->send(new OrderSuccess($user,$order));
        
        return view('appl.product.pages.checkout_success')->with('order',$order);
            
          

          //Process your transaction here as success transaction.
          //Verify amount & order id received from Payment gateway with your application's order id and amount.
        }
        else {
          $order->payment_status = 'Failure';
          Mail::to($user->email)->send(new OrderSuccess($user,$order));
          return view('appl.product.pages.checkout_txn_failure');
        }


      }
      else {

        $order = Order::where('order_id',$_POST['ORDERID'])->first();
        
        return view('appl.product.pages.checkout_checksum_failure');
            
        
        //Process transaction as suspicious.
      }

    //return view('appl.product.pages.checkout_success');
    }    


     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_transaction($id)
    {
        $order = Order::where('order_id',$id)->first();

      

        if($order)
            return view('appl.product.order.show')
                    ->with('order',$order);
        else
            abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function list_transactions(Request $request)
    {
        $order = new Order();
        $search = $request->search;
        $item = $request->item;
        $client_id = Client::where('slug',\auth::user()->client_slug)->first()->id;
        $orders = $order->where('order_id','LIKE',"%{$item}%")
                  ->where('client_id',$client_id)
                  ->orderBy('created_at','desc ')
                  ->paginate(config('global.no_of_records'));
        $view = $search ? 'list': 'index';

        return view('appl.product.order.'.$view)
        ->with('orders',$orders)->with('order',$order);
    }


    public function transactions(Request $request)
    {
        $order = new Order();
        $search = $request->search;
        $user = \auth::user();
        $item = $request->item;
        $orders = $order->where('order_id','LIKE',"%{$item}%")
                  ->where('user_id',$user->id)
                  ->orderBy('created_at','desc ')
                  ->paginate(config('global.no_of_records'));
        $view = $search ? 'newlist': 'transactions';

        return view('appl.product.order.'.$view)
        ->with('orders',$orders)->with('order',$order);
    }

    public function transaction($id)
    {
        $order = Order::where('order_id',$id)->first();

        if($order)
            return view('appl.product.order.transaction')
                    ->with('order',$order);
        else
            abort(404);
    }
     

    public function ordersuccess(Request $request)
    {
        $client = Client::where('slug',\auth::user()->client_slug)->first();
        $order = new Order();
        ($request->get('order_id'))? $order->order_id = $request->get('order_id'):$order->order_id = 'ORD_12345_SAMPLE';
        ($request->get('credit_count'))?$order->credit_count = $request->get('credit_count') :$order->credit_count = '200';

        return view('appl.product.admin.ordersuccess')->with('client',$client)->with('order',$order);
    }

    public function orderfailure(Request $request)
    {
        $client = Client::where('slug',\auth::user()->client_slug)->first();
        return view('appl.product.admin.orderfailure')->with('client',$client);
    }
}
