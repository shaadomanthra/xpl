<?php

namespace PacketPrep\Http\Controllers\Product;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Product\Coupon as Obj;
use PacketPrep\User;
use PacketPrep\Models\Product\Product;
use PacketPrep\Models\Product\Company_Coupons;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PacketPrep\Mail\CustomerCoupon;

class CouponController extends Controller
{


    public function __construct(){
        $this->app      =   'product';
        $this->module   =   'coupon';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Obj $obj,Request $request)
    {

        $this->authorize('view', $obj);

        $search = $request->search;
        $item = $request->item;
        
        $objs = $obj->where('code','LIKE',"%{$item}%")->with('order')
                    ->orderBy('created_at','desc ')
                    ->paginate(config('global.no_of_records'));   
        $view = $search ? 'list': 'index';

        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('objs',$objs)
                ->with('obj',$obj)
                ->with('app',$this);
    }


    public function referral(Request $request){

        return view('appl.product.coupon.referral');
    }

    public function coupon(Request $request){

        $model = new Company_Coupons();
        $user = \auth::user();
        $referral = $request->get('referral');
        if($referral){
            if(User::where('username',$referral)->first())
            $referral_id = User::where('username',$referral)->first()->id;
            else
            $referral_id = 60;   
        }else{
            $referral_id = 1;
            $referral = 'krishnateja';
        }
        
        $company = $request->get('company');

        if(!$company)
            abort('404','Company not declared');

        $model->user_id = $user->id;
        $model->referral_id = $referral_id;
        $model->name = $user->name;
        $model->referral = $referral;
        $model->company = $company;
        $model->save();

        if($user->colleges()->first())
        $user->college = $user->colleges()->first()->name;
        else
        $user->college = ' - NA -';

        if($user->branches()->first())
        $user->branch = $user->branches()->first()->name;
        else
        $user->branch = ' - NA -';

        if($user->details()->first()){
            $user->phone = $user->details()->first()->phone;
            $user->year_of_passing = $user->details()->first()->year_of_passing;
        }
        else{
            $user->phone = ' - NA -';
            $user->year_of_passing = ' - NA -';
        }
        
         Mail::to($user->email)->send(new CustomerCoupon($user,$model));
        
        return view('appl.product.coupon.download')->with('user',$user);
    }

    public function couponAdmin(Request $request){

        
        $obj = new Company_Coupons();

        $search = $request->search;
        $item = $request->item;
        
        $objs = $obj->where('name','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc ')
                    ->paginate(config('global.no_of_records')); 
         
        $view = $search ? 'list': 'couponadmin';

        return view('appl.product.customer.'.$view)
                ->with('objs',$objs)
                ->with('obj',$obj)
                ->with('app',$this);
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $obj = new Obj();
        $products = Product::all();

        $this->authorize('create', $obj);

        return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Create')
                ->with('products',$products)
                ->with('jqueryui',true)
                ->with('obj',$obj)
                ->with('app',$this);
    }

    

    public function getamount($amount,$code,$product)
    {
        $obj = Obj::where('code',$code)->first();

        
        if($obj){
            if($obj->status == 0){
                $status = 'Coupon Inactive';
            }
            else if($obj->product_id != $product && ($obj->product_id!=0 || $obj->product_id!=null)){
                $status = 'This Coupon is not valid for the above product.';
            }elseif(strtotime($obj->expiry) < strtotime(date('Y-m-d'))){
                $status = 'Coupon Expired';
            }else{
                if($obj->percent)
                    $amount = $amount * round(1 -($obj->percent / 100),2);//floor($amount * (1 - round($obj->percent / 100,2)));
                else if($obj->price)
                    $amount = $amount - $price;
                $status = 'Coupon Successfully Added';
            }

            
        }else{
            $amb = User::where('username',$code)->first();

            if($amb){
                $true = $amb->checkRole(['ambassador']);

                if($true){
                    $p = Product::where('id',$product)->first();
                    $amount = $amount - $p->discount;
                    $status = 'Rs.'.$p->discount.' discount coupon successfully added';
                }else
                {
                    $status = 'Invalid Coupon Code - Ambassador error';
                }
            }else{
                $status = 'Invalid Coupon Code ';
            }
            
        }

        $data = (object)['amount'=>$amount,'status'=>$status];
        $data = json_encode($data);
        echo $data;

        
    }
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Obj $obj, Request $request)
    {
         try{
            $obj = $obj->create($request->all());
            flash('A new ('.$this->app.'/'.$this->module.') item is created!')->success();
            return redirect()->route($this->module.'.index');
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                flash('Some error in Creating the record')->error();
                 return redirect()->back()->withInput();;
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $obj = Obj::where('id',$id)->first();
        $this->authorize('view', $obj);
        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.show')
                    ->with('obj',$obj)->with('app',$this);
        else
            abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $obj= Obj::where('id',$id)->first();
        $products = Product::all();
        $this->authorize('update', $obj);


        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Update')
                ->with('products',$products)
                ->with('jqueryui',true)
                ->with('obj',$obj)->with('app',$this);
        else
            abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $obj = Obj::where('id',$id)->first();

            $this->authorize('update', $obj);
            $obj = $obj->update($request->all()); 
            flash('('.$this->app.'/'.$this->module.') item is updated!')->success();
            return redirect()->route($this->module.'.show',$id);
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                 flash('Some error in updating the record')->error();
                 return redirect()->back()->withInput();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
        $obj = Obj::where('id',$id)->first();
        $this->authorize('update', $obj);
        $obj->delete();

        flash('('.$this->app.'/'.$this->module.') item  Successfully deleted!')->success();
        return redirect()->route($this->module.'.index');
    }
}
