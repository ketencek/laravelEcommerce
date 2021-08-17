<?php

namespace App\Http\Controllers\Admin;

use App\Models\Color;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Http\Requests\ColorRequest;

class ColorController
{
    use HasCrudActions;

    protected $model = Color::class;
    
    protected $routePrefix = 'admin.colors';

    protected $label = 'page::pages.page';

     /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = ColorRequest::class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //
        $this->view = 'admin.colors';
        $this->route = 'admin.colors';
        $this->viewName = __('Color');
    }

    public function index(Request $request)
    {
        $colors = Color::withoutGlobalScope('status')->get();
        return view($this->view . '.index', compact('colors'));
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
    //  * @param  \App\Models\Color  $Color
    //  * @return \Illuminate\Http\Response
    //  */
    public function edit($id)
    {
        $data['title'] = 'Edit '.$this->viewName;
        $data['edit'] = Color::withoutGlobalScope('status')->findOrFail($id);
        $data['url'] = route($this->route . '.update', ['id' => $id]);
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        // dd($data);
		return view('admin.general.edit', compact('data'));
    }

}
