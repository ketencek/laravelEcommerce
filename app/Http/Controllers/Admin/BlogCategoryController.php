<?php

namespace App\Http\Controllers\Admin;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Http\Requests\BlogCategoryRequest;
use Illuminate\Support\Facades\View;

class BlogCategoryController
{
    use HasCrudActions;

    protected $model = BlogCategory::class;
    
    protected $routePrefix = 'admin.blog-categories';

    protected $label = 'Blog Category';

     /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = BlogCategoryRequest::class;

    protected function redirectTo($blc)
    {
        return route('admin.blog-categories.edit',['id'=>$blc->id]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //
        $this->view = 'admin.blogcategory';
        $this->route = $this->routePrefix;
        $this->viewName = __($this->label);
        View::share('label', __($this->label));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $blog_categories = BlogCategory::withoutGlobalScope('status')->get();
        return view($this->view . '.index', compact('blog_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['url'] = route($this->route . '.store');
        $data['title'] = __('Add').' '. __($this->label);
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;

        return view('admin.general.create')->with($data);
    }

   

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\BlogCategory  $BlogCategory
    //  * @return \Illuminate\Http\Response
    //  */
    public function edit($id)
    {
        $data['title'] = __('Edit').' '. __($this->label);
        $data['edit'] = BlogCategory::withoutGlobalScope('status')->findOrFail($id);
        $data['url'] = route($this->route . '.update', ['id' => $id]);
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        // dd($data);
		return view('admin.general.edit', compact('data'));
    }

}
