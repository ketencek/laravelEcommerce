<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Http\Requests\LanguageRequest;
use Illuminate\Support\Facades\View;

class LanguageController
{
    use HasCrudActions;

    protected $model = Language::class;
    
    protected $routePrefix = 'admin.languages';

    protected $label = 'Language';

     /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = LanguageRequest::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //
        $this->view = 'admin.language';
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
        $languages = Language::withoutGlobalScope('status')->get();
        return view($this->view . '.index', compact('languages'));
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
        // $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;

        return view('admin.general.create')->with($data);
    }

   

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\Language  $Language
    //  * @return \Illuminate\Http\Response
    //  */
    public function edit($id)
    {
        $data['title'] = __('Edit').' '. __($this->label);
        $data['edit'] = Language::withoutGlobalScope('status')->findOrFail($id);
        $data['url'] = route($this->route . '.update', ['id' => $id]);
        // $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        // dd($data);
		return view('admin.general.edit', compact('data'));
    }

}
