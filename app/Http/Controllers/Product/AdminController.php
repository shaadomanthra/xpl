<?php

namespace PacketPrep\Http\Controllers\Product;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Product\Client;
use PacketPrep\Models\Course\Course;
use PacketPrep\Models\User\Role;
use PacketPrep\User;
use Intervention\Image\ImageManagerStatic as Image;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slug = subdomain();
        $client = client::where('slug',$slug)->first();

        return view('appl.product.admin.index')->with('client',$client);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        $slug = subdomain();
        $client = client::where('slug',$slug)->first();
        $courses = $client->courses;
        $this->authorize('edit', $client);

        $users = array();
        $users['client_owner'] = Role::getUsers('client-owner');
        $users['client_manager'] = Role::getUsers('client-manager');

        if($client)
            return view('appl.product.admin.settings')
                ->with('stub','Update')
                ->with('jqueryui',true)
                ->with('users',$users)
                ->with('courses',$courses)
                ->with('client',$client);
        else
            abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function settings_store(Request $request)
    {
        $slug = subdomain();
        $courses = $request->get('course');

        try{
            $request->slug = str_replace(' ', '-', $request->slug);
            $client = client::where('slug',$slug)->first();

            $client->name = $request->name;
            $client->contact = htmlentities($request->contact);
            $client->save(); 

            $course_list =  $client->courses->pluck('id')->toArray();
            //update tags
            if($courses)
            foreach($course_list as $course){
                if(in_array($course, $courses)){
                    $client->updateVisibility($client->id,$course,1);
                        
                }else{
                    $client->updateVisibility($client->id,$course,0);
                }
                
            } else{
                $client->updateVisibility($client->id,null,0);
            }


            $newJsonString = json_encode($client, JSON_PRETTY_PRINT);
            file_put_contents(base_path('json/'.$client->slug.'.json'), stripslashes($newJsonString));

            flash('Your Settings Successfully updated!')->success();
            return redirect()->route('admin.settings');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
