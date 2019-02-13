<?php

namespace PacketPrep\Http\Controllers\Product;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;

use PacketPrep\Models\Product\Product;

class StudentController extends Controller
{
    

	

    public function targettcs(Request $request)
    {
        return view('appl.product.student.targettcs');
    }

    public function referral(Request $request)
    {
    	$type=null;
    	if(\auth::user())
	    	if(\auth::user()->colleges->first())
			$type = substr(\auth::user()->colleges->first()->type,0,1);
			else
			$type = 'd';



        if($type=='b')
            $type='e';

    	$user = null;$product=null;
    	if(\auth::user()){
    		$user = \auth::user();
    		$product = $user->products()->where('product_user.product_id',18)->first();
    	}

        return view('appl.product.student.referral')
        ->with('user',$user)
        ->with('product',$product)
        ->with('type',$type);
    }

    public function proaccess(Request $request)
    {
    	$user = null;
    	if(\auth::user()){
    		$user = \auth::user();

    		if(count($user->referrals)>=3){

    			$pid = 18;
                        $month = 3;

                        $valid_till = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s") .' + '.($month*31).' days'));
                        if(!$user->products->contains($pid)){
                            $product = Product::where('id',$pid)->first();
                            if($product->status!=0)
                            $user->products()->attach($pid,['validity'=>$month,'created_at'=>date("Y-m-d H:i:s"),'valid_till'=>$valid_till,'status'=>1]);
                        }
    		}
    	}
    	
        return redirect()->route('dashboard');
    }

    public function ambassador(Request $request)
    {
        return view('appl.product.student.ambassador');
    }

    public function apply(Request $request)
    {
        return view('appl.product.student.ambassador');
    }
    
    public function save(Request $request)
    {
        return view('appl.product.student.ambassador');
    }

}
