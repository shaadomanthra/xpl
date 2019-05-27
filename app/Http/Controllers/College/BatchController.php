<?php

namespace PacketPrep\Http\Controllers\College;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\College\Batch as Obj;
use PacketPrep\User;
use PacketPrep\Models\College\College;


class BatchController extends Controller
{
    public function __construct(){
        $this->app      =   'college';
        $this->module   =   'batch';
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

        if(request()->session()->get('college')){
                $col = request()->session()->get('college')['id'];
                $college =  College::where('id',$col)->first();
            }else
                $college = \auth::user()->colleges()->first();

        $college_id = $college->id;
        $objs = $obj->where('name','LIKE',"%{$item}%")
                    ->where('college_id',$college_id)
                    ->orderBy('created_at','desc ')
                    ->paginate(config('global.no_of_records'));   
        $view = $search ? 'list': 'index';

        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
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
        $this->authorize('create', $obj);

        if(request()->session()->get('college')){
                $col = request()->session()->get('college')['id'];
                $college =  College::where('id',$col)->first();
            }else
                $college = \auth::user()->colleges()->first();

        $obj->college_id = $college->id;
        $obj->slug = substr(md5(microtime()),8);
        $obj->code = strtoupper($this->random_str(3, 'abcdefghijklmnopqrstuvwxyz'));

        return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Create')
                ->with('jqueryui',true)
                ->with('obj',$obj)
                ->with('app',$this);
    }

    function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
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
    public function show($id,Request $request)
    {

        

        $obj = Obj::where('slug',$id)->first();
        $this->authorize('view', $obj);

        $item = $request->item;
        $search = $request->search;

        if(request()->session()->get('college')){
                $col = request()->session()->get('college')['id'];
                $college =  College::where('id',$col)->first();
            }else
                $college = \auth::user()->colleges()->first();

        $college_id = $college->id;
        $objs = $obj->users()->where('name','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc ')
                    ->paginate(config('global.no_of_records'));   
        $view = $search ? 'list_students': 'show';

        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                    ->with('obj',$obj)->with('app',$this)->with('objs',$objs);
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
            $obj->update($request->all()); 
            flash('('.$this->app.'/'.$this->module.') item is updated!')->success();
            return redirect()->route($this->module.'.show',$obj->slug);
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                 flash('Some error in updating the record')->error();
                 return redirect()->back()->withInput();
            }
        }
    }

    public function attachUser(Request $request, $id)
    {
        try{
            $obj = Obj::where('id',$id)->first();

            if(request()->session()->get('college')){
                $col = request()->session()->get('college')['id'];
                $college =  College::where('id',$col)->first();
            }else
                $college = \auth::user()->colleges()->first();

            if(\auth::user()->checkRole(['tpo'])){
                $user = User::Where('id',$request->user_id)->first();
                if(!$obj->users->contains($request->user_id))
                    $obj->users()->attach($request->user_id);
                    flash('You have successfully add '.$user->name.' to the batch - '.$obj->name)->success();
                return redirect()->back();
            }else{

                if($obj->code == strtoupper($request->code))
                {
                    if(!$obj->users->contains($request->user_id))
                        $obj->users()->attach($request->user_id);

                    flash('You have successfully joined the batch - '.$obj->name)->success();
                }else
                    flash('Access Code is Incorrect!')->error();
                return redirect()->route($this->module.'.show',$obj->slug);

            }

            
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                 flash('Some error in updating the record')->error();
                 return redirect()->back()->withInput();
            }
        }
    }

    public function detachUser(Request $request, $id)
    {
        try{
            $obj = Obj::where('id',$id)->first();
            $user = User::Where('id',$request->user_id)->first();
            if($obj->users->contains($request->user_id))
                $obj->users()->detach($request->user_id);
            flash($user->name.' is successfully removed from the batch - '.$obj->name)->success();
            if($request->url)
                return redirect()->back();
            else
                return redirect()->route($this->module.'.show',$obj->slug);
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
