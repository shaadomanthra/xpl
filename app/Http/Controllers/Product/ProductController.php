<?php

namespace PacketPrep\Http\Controllers\Product;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Product\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product,Request $request)
    {

        $this->authorize('view', $product);

        $search = $request->search;
        $item = $request->item;
        
        $products = $product->where('name','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc ')
                    ->paginate(config('global.no_of_records'));   
        $view = $search ? 'list': 'index';

        return view('appl.product.product.'.$view)
        ->with('products',$products)->with('product',$product);
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = new Product();
        $this->authorize('create', $product);


        return view('appl.product.product.createedit')
                ->with('stub','Create')
                ->with('jqueryui',true)
                ->with('product',$product);
    }
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Product $product, Request $request)
    {
         try{

            if(!$request->slug )
            $request->slug  = $request->name;
            $request->slug = strtolower(str_replace(' ', '-', $request->slug));

            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->description = ($request->description) ? $request->description: null;
            $product->price = $request->price;
            $product->save(); 

            flash('A new product('.$request->name.') is created!')->success();
            return redirect()->route('product.index');
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                flash('The slug(<b>'.$request->slug.'</b>) is already taken. Kindly use a different slug.')->error();
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
        $product= Product::where('slug',$id)->first();

        
        $this->authorize('view', $product);

        if($product)
            return view('appl.product.product.show')
                    ->with('product',$product);
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
        $product= Product::where('slug',$id)->first();
        $this->authorize('update', $product);


        if($product)
            return view('appl.product.product.createedit')
                ->with('stub','Update')
                ->with('jqueryui',true)
                ->with('product',$product);
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
    public function update(Request $request, $slug)
    {
        try{
            $product = Product::where('slug',$slug)->first();

            $this->authorize('update', $product);

            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->description = ($request->description) ? $request->description: null;
            $product->price = $request->price;
            $product->save(); 

            flash('Product (<b>'.$request->name.'</b>) Successfully updated!')->success();
            return redirect()->route('product.show',$request->slug);
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                flash('The slug(<b>'.$request->slug.'</b>) is already taken. Kindly use a different slug.')->error();
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
        $product = Product::where('id',$id)->first();
        $this->authorize('update', $product);
        $product->delete();

        flash('Product Successfully deleted!')->success();
        return redirect()->route('product.index');
    }
}
