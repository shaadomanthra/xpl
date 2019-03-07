<?php

namespace PacketPrep\Http\Controllers\Social;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Social\Blog;

use Image;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Blog $blog)
    {
        
        $blogs = $blog->orderBy('created_at','desc ')
                    ->paginate(config('global.no_of_records'));
        
        return view('appl.social.blog.index')
            ->with('blog',$blog)
            ->with('blogs',$blogs);
    }


  

   /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Blog $blog)
    {
        $this->authorize('create', $blog);
        return view('appl.social.blog.createedit')
                ->with('blog',$blog)
                ->with('jqueryui',true)
                ->with('editor',true)
                ->with('stub','Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = \auth::user();

        $status = $this->image_upload($request);
        $image =null;
        if($status['success'])
            $image = $status['image'];
        else
            dd($status);

        try{
            $blog = new Blog;
            $blog->user_id_moderator = $request->user_id_moderator;
            $blog->user_id_writer = $request->user_id_writer;
            $blog->title= $request->title;
            $blog->slug= $request->slug;
            $blog->intro = ($request->intro)?$request->intro:' ';
            $blog->content = ($request->content)? summernote_imageupload($user,$request->content):' ';
            $blog->image = $image ;
            $blog->keywords= $request->keywords;
            $blog->label_id= $request->label_id;
            $blog->status= $request->status;
            $blog->schedule= $request->schedule;
            $blog->save();

            flash('A new blog('.$request->slug.') is created!')->success();
            return redirect()->route('blog.index');
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                flash('Some error is there kindly recheck!')->error();
                 return redirect()->back()->withInput();;
            }
        }
    }


    public function image_remove(){
        
        $file = $_REQUEST['image'];
        unlink(trim($file));
    }

    public function image_upload($request){

        $p = explode('.',$_FILES["fileToUpload"]['name']);
        

        $status = array();
        $target_dir = "img/blog/";
        if(\auth::guest())
            $username = $request->username;
        else 
            $username = \auth::user()->username;

        if(isset($_FILES["fileToUpload"])){
        $target_file = $target_dir .$username.'_'.$request->slug.'.'.end($p) ;
        $status['image'] = $target_file;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        // Check if image file is a actual image or fake image
        
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                $status['message'] = "File is an image - " . $check["mime"] . ".";
                $status['success'] = 1;

            } else {
                $status['message'] = "File is not an image.";
                $status['success']  = 0;
                 return $status;
            }
      

        
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $status['message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $status['success']  = 0;
            return $status;
        }
        
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $status['message'] = "Successfully uploaded";
                $status['success']  = 1;
            } else {
                $status['message'] = "Sorry, there was an error uploading your file.";
                $status['success']  = 0;
            }

            $imgr = Image::make($target_file);
                    $imgr->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $imgr->save($target_file);
            

        }

        return $status;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($blog_slug)
    {
        $blog = blog::where('slug',$blog_slug)->first();
        return view('appl.social.blog.show')
                    ->with('blog',$blog)
                    ->with('stub',$blog->title);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = blog::where('id',$id)->first();
        $this->authorize('edit', $blog);
        if($blog)
            return view('appl.social.blog.createedit')
                    ->with('jqueryui',true)
                    ->with('blog',$blog)
                    ->with('editor',true)
                    ->with('stub','Update');
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
        $user = \auth::user();

        $image = $request->image;
        if($_FILES["fileToUpload"]["tmp_name"]){
            $status = $this->image_upload($request);
            if($status['success'])
            $image = $status['image'];
            else
            dd($status);
        }

        try{
            $blog = blog::where('id',$id)->first();
            $blog->user_id_moderator = $request->user_id_moderator;
            $blog->user_id_writer = $request->user_id_writer;
            $blog->title= $request->title;
            $blog->slug= $request->slug;
            $blog->intro = ($request->intro)?$request->intro:' ';
            $blog->content = ($request->content)?summernote_imageupload($user,$request->content):' ';
            $blog->keywords= $request->keywords;
            $blog->image= $image;
            $blog->label_id= $request->label_id;
            $blog->status= $request->status;
            $blog->schedule= $request->schedule;
            $blog->save();

            flash('blog (<b>'.$blog->slug.'</b>) Successfully updated!')->success();
            return redirect()->route('blog.index');
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                 flash('Some error is there kindly recheck!')->error();
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
        $blog = blog::where('id',$id)->first();
        $this->authorize('create', $blog);
        if (file_exists($blog->image)) {
            unlink($blog->image);
          } 
        $blog->content = summernote_imageremove($blog->content);
        $blog->delete();
        flash('Blog Successfully deleted!')->success();
        return redirect()->route('blog.index');
    }
}
