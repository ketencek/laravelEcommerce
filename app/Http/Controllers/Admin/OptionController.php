<?php

namespace App\Http\Controllers\Admin;

use App\Models\Option;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Http\Requests\SaveOptionRequest;

class OptionController
{
    use HasCrudActions;

    protected $model = Option::class;
    
    protected $routePrefix = 'admin.options';

    protected $label = 'page::pages.page';

     /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveOptionRequest::class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //
        $this->view = 'admin.options';
        $this->route = 'admin.options';
        $this->viewName = __('Option');
    }

    public function index(Request $request)
    {
        $options = Option::withoutGlobalScope('status')->get();
        return view($this->view . '.index', compact('options'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['url'] = route($this->route . '.store');
        $data['title'] = 'Add ' . $this->viewName;
        $data['module'] = $this->viewName;
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
    public function edit($id)
    {
        $data['title'] = 'Edit '.$this->viewName;
        $data['edit'] = Option::withoutGlobalScope('status')->findOrFail($id);
        $data['url'] = route($this->route . '.update', ['id' => $id]);
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        // dd($data);
		return view('admin.general.edit', compact('data'));
    }

}
