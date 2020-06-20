<?php

namespace PacketPrep\Http\Controllers\Product;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;

use PacketPrep\Models\Product\Product;
use PacketPrep\User;

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
    		$product = $user->products()->where('product_user.product_id',31)->first();
    	}

        return view('appl.product.student.referral')
        ->with('user',$user)
        ->with('product',$product)
        ->with('type',$type);
    }


    public function userreferral($u, Request $request)
    {
        $user = User::where('username',$u)->first();



        $type=null;
        if($user)
            if($user->colleges->first())
            $type = substr($user->colleges->first()->type,0,1);
            else
            $type = 'd';

        if($type=='b')
            $type='e';

        $name = $user->colleges->first()->name;
        if($request->get('othercollege')){
            $users = \auth::user()->where('user_id',$user->id)
                        ->whereHas('colleges', function ($query) use($name) {
                                $query->where('name', '!=', $name);
                            })->orderBy('updated_at','desc')
                            ->paginate(150); 

        }else
        $users = \auth::user()->where('user_id',$user->id)->orderBy('updated_at','desc')->paginate(150);

        $college = array();
        foreach($users as $u){
            if(!array_key_exists($u->colleges->first()->name, $college))
            $college[$u->colleges->first()->name] = 1;
            else
            $college[$u->colleges->first()->name] = $college[$u->colleges->first()->name] +1;
        }

        return view('appl.user.referral')
        ->with('user',$user)->with('username',$user->username)
        ->with('users',$users)
        ->with('colleges',$college)
        ->with('type',$type);
    }


    public function referrallist( Request $request)
    {
        if(!\auth::user()->checkRole(['administrator','investor','patron','promoter','employee','client-owner','client-manager','manager']))
        {
             abort(403,'Unauthorised Access');   
        }
        
        $users = User::has('referrals')->get()->groupBy('id');
        $usergroup = User::get()->groupBy('user_id');
        $ulist = null;
        foreach($usergroup as $k=>$u){
            $ulist[$k] = count($u);
        }
        arsort($ulist);
        
        
        return view('appl.user.referrallist')
        ->with('users',$users)->with('usergroup',$usergroup)->with('ulist',$ulist);
    }

    public function proaccess(Request $request)
    {
    	$user = null;
    	if(\auth::user()){
    		$user = \auth::user();

    		if(count($user->referrals)>=3){

    			$pid = 31;
                        $month = 12;

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

    public function coordinator(Request $request)
    {
        return view('appl.product.student.coordinator');
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
