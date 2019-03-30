<?php

namespace PacketPrep\Http\Controllers\Product;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Product\Coupon as Obj;
use PacketPrep\User;
use PacketPrep\Models\Product\Product;

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
        
        $objs = $obj->where('code','LIKE',"%{$item}%")
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

        $user = \auth::user();
        return view('appl.product.coupon.download')->with('user',$user);
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $obj = new Obj();
        $this->authorize('create', $obj);

        return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Create')
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
            }elseif(strtotime($obj->expiry) < strtotime(date('Y-m-d'))){
                $status = 'Coupon Expired';
            }else{
                $amount = floor($amount * (1 - ($obj->percent / 100)));
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
        $this->authorize('update', $obj);


        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Update')
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
