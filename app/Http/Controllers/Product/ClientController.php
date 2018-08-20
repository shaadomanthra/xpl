<?php

namespace PacketPrep\Http\Controllers\Product;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Product\Client;
use PacketPrep\Models\User\Role;
use PacketPrep\User;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(client $client,Request $request)
    {
        $this->authorize('view', $client);

        $search = $request->search;
        $item = $request->item;
        $clients = $client->where('name','LIKE',"%{$item}%")->orderBy('created_at','desc ')->paginate(config('global.no_of_records'));
        $view = $search ? 'list': 'index';

        return view('appl.product.client.'.$view)
        ->with('clients',$clients)->with('client',new client());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client = new client();
        $this->authorize('create', $client);

        $users = array();

        return view('appl.product.client.createedit')
                ->with('stub','Create')
                ->with('jqueryui',true)
                ->with('client',$client)
                ->with('users',$users);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(client $client,Request $request)
    {

        try{
            $request->slug = str_replace(' ', '-', $request->slug);

            $client_exists = client::where('slug',$request->slug)->first();

            if($client_exists){
                flash('The slug(<b>'.$request->slug.'</b>) is already taken. Kindly use a different slug.')->error();
                 return redirect()->back()->withInput();
            }

            $client->name = $request->name;
            $client->slug = strtolower($request->slug);
            $client->user_id_creator = $request->user_id_creator;
            $client->user_id_owner = ($request->user_id_owner)?$request->user_id_owner:null;
            $client->user_id_manager = null;
            $client->status = $request->status;
            $client->save(); 


            $newJsonString = json_encode($client, JSON_PRETTY_PRINT);
            file_put_contents(base_path('json/'.$client->slug.'.json'), stripslashes($newJsonString));


            flash('A new client('.$request->name.') is created!')->success();
            return redirect()->route('client.index');
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = client::where('slug',$id)->first();

        $this->authorize('view', $client);

        if($client)
            return view('appl.product.client.show')
                    ->with('client',$client)
                    ->with('stub',$client->name);
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
        $client = client::where('slug',$id)->first();
        $this->authorize('update', $client);

        $users = array();
        $users['client_owner'] = Role::getUsers('client-owner');
        $users['client_manager'] = Role::getUsers('client-manager');

        if($client)
            return view('appl.product.client.createedit')
                ->with('stub','Update')
                ->with('jqueryui',true)
                ->with('users',$users)
                ->with('client',$client);
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
        $engineers = $request->get('engineers');

        try{
            $request->slug = str_replace(' ', '-', $request->slug);
            $client = client::where('id',$id)->first();

            $this->authorize('update', $client);


            $client->name = $request->name;
            $client->slug = strtolower($request->slug);
            $client->status = $request->status;
            $client->save(); 

            $newJsonString = json_encode($client, JSON_PRETTY_PRINT);
            file_put_contents(base_path('json/'.$client->slug.'.json'), stripslashes($newJsonString));

            flash('client (<b>'.$request->name.'</b>) Successfully updated!')->success();
            return redirect()->route('client.show',$request->slug);
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
        $client = client::where('id',$id)->first();
        $this->authorize('update', $client);
        $file = base_path('json/'.strtolower($client->slug).'.json');
        unlink($file);
        $client->delete();
        flash('client Successfully deleted!')->success();
        return redirect()->route('client.index');
       
    }
}
