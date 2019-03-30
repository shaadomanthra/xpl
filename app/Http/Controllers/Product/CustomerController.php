<?php

namespace PacketPrep\Http\Controllers\Product;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;

class CustomerController extends Controller
{
    

    public function bootcamp(Request $request){

    	return view('appl.product.customer.bootcamp');
    }

    public function firstacademy(Request $request){
    	return view('appl.product.customer.firstacademy');
    }

}
