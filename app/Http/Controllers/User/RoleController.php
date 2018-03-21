<?php

namespace PacketPrep\Http\Controllers\User;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\User\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Role $role)
    {
        $this->authorize('view', $role);
        $node = Role::defaultOrder()->get()->toTree();
        if(count($node))
            $nodes = $role->displayUnorderedList($node);
        else
            $nodes =null;

        return view('appl.user.role.index')
                ->with('nodes',$nodes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Role $role)
    {
        $this->authorize('create', $role);
        $select_options = $role->displaySelectOption($role->get()->toTree());
        return view('appl.user.role.createedit')
                ->with('stub','Create')
                ->with('select_options',$select_options);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Role $role)
    {

        $request->slug = str_replace(' ', '-', $request->slug);
        $child_attributes =['name'=>$request->name,'slug'=>$request->slug];
        $parent = Role::where('id','=',$request->parent_id)->first();
        $child = new Role($child_attributes);

        $slug_exists_test = Role::where('slug','=',$request->slug)->first();

        if($slug_exists_test)
        {
            flash('The slug(<b>'.$request->slug.'</b>) is already taken. Kindly use a different slug.')->error();
                 return redirect()->back()->withInput();;
        }

        if($request->parent_id!='0')
            $parent->appendNode($child);
        else
            $child->save();

        flash('A new Role('.$request->name.') is created!')->success();
        return redirect()->route('role.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($role_slug,Request $request)
    {
        $role = Role::where('slug',$role_slug)->first();
        $this->authorize('view', $role);
        $parent = Role::getParent($role);

        $order = $request->get('order');
        
        if($order=='up')
            $role->up();
        elseif($order=='down')
            $role->down();

        if($parent){
            $firstchild = Role::defaultOrder()->descendantsOf($parent->id)->first();
            $first = $firstchild;

            $list ='<ul class="sortable">';
            do{
                ($role_slug==$firstchild->slug) ? $class = ' class="current" ' : $class = ' ' ;
                    
                $list= $list.'<li '.$class.' data-slug="'.$firstchild->slug.'"><a href="'.route('role.show',$firstchild->slug).'">'.$firstchild->name.'</a></li>';

            }while($firstchild =$firstchild->getNextSibling());
            
            $list=$list."</ul>";

            if(count($first->getSiblings())==0)
                $list = null;
             
        }else{
            $siblings = Role::defaultOrder()->withDepth()->having('depth', '=', 0)->get();

            $list ="<ul class='sortable'>";
             foreach($siblings as $child){
                ($role_slug==$child->slug) ? $class = ' class="current" ' : $class = ' ' ;
                $list= $list.'<li '.$class.' data-slug="'.$child->slug.'"><a href="'.route('role.show',$child->slug).'">'.$child->name.'</a></li>';
             }
                
            $list=$list."</ul>";

            if(count($siblings)<2 )
                $list =null;

        }


        if($role)
            return view('appl.user.role.show')
                    ->with('role',$role)
                    ->with('parent',$parent)
                    ->with('list',$list);
        else
            abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($role_slug)
    {
       
        $node = Role::where('slug',$role_slug)->first();
        $this->authorize('edit', $node);
        $parent = Role::getParent($node);

        if(!$parent){
            $parent = new Role;
            $parent->id=null;
        }

        $select_options = Role::displaySelectOption($node->defaultOrder()->get()->toTree(),
            [   'select_id'     =>  $parent->id,
                'disable_id'    =>  $node->id,
            ]
        );

        if($node)
            return view('appl.user.role.createedit')
                    ->with('role',$node)
                    ->with('parent',$parent)
                    ->with('stub','Update')
                    ->with('select_options',$select_options);
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
    public function update(Request $request, $role_slug)
    {
        $this->authorize(\auth::user());
        // get the base category and parent       
        $role = Role::where('slug',$role_slug)->first();
        $new_parent = Role::where('id',$request->parent_id)->first();

        // change the parent
        $new_parent->appendNode($role);

        //get the new reference to the category item
        $role = Role::where('slug',$role_slug)->first();
        //update category details 
        $role->name = $request->name;
        $role->slug = str_replace(' ', '-', $request->slug);
        $role->save();

        flash('Role(<b>'.$request->name.'</b>) successfully updated!')->success();
        return redirect()->route('role.show',$role->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($role_slug)
    {
        $this->authorize(\auth::user());
        $node = Role::where('slug',$role_slug)->first();
        $node->delete();
        flash('Role('.$role_slug.')Tree Successfully deleted!')->success();
        return redirect()->route('role.index');
    }
}
