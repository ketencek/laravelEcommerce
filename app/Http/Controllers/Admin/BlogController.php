<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Http\Requests\BlogRequest;
use Illuminate\Support\Facades\View;

class BlogController
{
    use HasCrudActions;

    protected $model = Blog::class;
    
    protected $routePrefix = 'admin.blogs';

    protected $label = 'Blog';

    

     /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = BlogRequest::class;

    protected function redirectTo($blog)
    {
        return route("{$this->routePrefix}.edit",['id'=>$blog->id,'type'=>$blog->blog_category_id]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //
        $this->view = 'admin.blog';
        $this->route = $this->routePrefix;
        $this->viewName = __($this->label);
        View::share('label', __($this->label));
    }

    public function index($type,Request $request)
    {
        $blogs = Blog::withoutGlobalScope('status')->where('blog_category_id', $type)->get();
        
        return view($this->view . '.index', compact('blogs','type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        $data['type'] = $type;
        $data['url'] = route($this->route . '.store', array('type'=>$type));
        $data['title'] = __('Add').' '. __($this->label);
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;       

        return view('admin.general.create')->with($data);
    }

   

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\Option  $Option
    //  * @return \Illuminate\Http\Response
    //  */
    public function edit($id,$type)
    {
        $data['type'] =$type;
        $data['title'] = __('Edit').' '. __($this->label);
        $data['edit'] = Blog::withoutGlobalScope('status')->findOrFail($id);
        // echo "<pre>";
        // print_r($data['edit']->toArray());
        // exit;
        $data['url'] = route($this->route . '.update', ['id' => $id,'type'=> $type]);
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        // dd($data);
		return view('admin.general.edit', compact('data'));
    }

}
