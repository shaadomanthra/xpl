<?php

namespace PacketPrep\Http\Controllers\Exam;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Exam\Examtype;

class ExamtypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Examtype $examtype,Request $request)
    {
        $this->authorize('view', $examtype);

        $search = $request->search;
        $item = $request->item;
        $examtypes = $examtype->where('name','LIKE',"%{$item}%")->orderBy('created_at','desc ')->paginate(config('global.no_of_records'));
        $view = $search ? 'list': 'index';

        return view('appl.exam.examtype.'.$view)
        ->with('examtypes',$examtypes)->with('examtype',$examtype);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $examtype = new Examtype();
        $this->authorize('create', $examtype);


        return view('appl.exam.examtype.createedit')
                ->with('stub','Create')
                ->with('examtype',$examtype);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Examtype $examtype,Request $request)
    {
        try{

            if(!$request->slug )
            $request->slug  = $request->name;
            $request->slug = strtolower(str_replace(' ', '-', $request->slug));

            $examtype->name = $request->name;
            $examtype->slug = $request->slug;
            $examtype->save(); 

            flash('A new examtype('.$request->name.') is created!')->success();
            return redirect()->route('examtype.index');
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
        $examtype= Examtype::where('slug',$id)->first();

        
        $this->authorize('view', $examtype);

        if($examtype)
            return view('appl.exam.examtype.show')
                    ->with('examtype',$examtype);
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
        $examtype= Examtype::where('slug',$id)->first();
        $this->authorize('update', $examtype);


        if($examtype)
            return view('appl.exam.examtype.createedit')
                ->with('stub','Update')
                ->with('examtype',$examtype);
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
            $examtype = Examtype::where('slug',$slug)->first();

            $this->authorize('update', $examtype);

            $examtype->name = $request->name;
            $examtype->slug = $request->slug;
            $examtype->save(); 

            flash('Examtype (<b>'.$request->name.'</b>) Successfully updated!')->success();
            return redirect()->route('examtype.show',$request->slug);
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
        $examtype = Examtype::where('id',$id)->first();
        $this->authorize('update', $examtype);

        
        $examtype->delete();

        flash('Examtype Successfully deleted!')->success();
        return redirect()->route('examtype.index');
    }
}
