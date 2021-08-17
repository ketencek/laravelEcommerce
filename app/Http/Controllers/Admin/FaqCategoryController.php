<?php

namespace App\Http\Controllers\Admin;

use App\Models\FaqCategory;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Http\Requests\FaqCategoryRequest;
use Illuminate\Support\Facades\View;

class FaqCategoryController
{
    use HasCrudActions;

    protected $model = FaqCategory::class;
    
    protected $routePrefix = 'admin.faq-categories';

    protected $label = 'Faq Category';

     /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = FaqCategoryRequest::class;

    protected function redirectTo($blc)
    {
        return route('admin.faq-categories.edit',['id'=>$blc->id]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //
        $this->view = 'admin.faqcategory';
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
        $faq_categories = FaqCategory::withoutGlobalScope('status')->get();
        return view($this->view . '.index', compact('faq_categories'));
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
    //  * @param  \App\Models\FaqCategory  $FaqCategory
    //  * @return \Illuminate\Http\Response
    //  */
    public function edit($id)
    {
        $data['title'] = __('Edit').' '. __($this->label);
        $data['edit'] = FaqCategory::withoutGlobalScope('status')->findOrFail($id);
        $data['url'] = route($this->route . '.update', ['id' => $id]);
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        // dd($data);
		return view('admin.general.edit', compact('data'));
    }

}
