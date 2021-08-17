<?php

namespace App\Http\Controllers\Admin;

use App\Models\Size;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Http\Requests\SizeRequest;

class SizeController
{
    use HasCrudActions;

    protected $model = Size::class;
    
    protected $routePrefix = 'admin.sizes';

    protected $label = 'page::pages.page';

     /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SizeRequest::class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //
        $this->view = 'admin.sizes';
        $this->route = 'admin.sizes';
        $this->viewName = __('Size');
    }

    public function index(Request $request)
    {
        $sizes = Size::withoutGlobalScope('status')->get();
        // echo "<pre>";
        // print_r($sizes->toArray());
        // exit;
        return view($this->view . '.index', compact('sizes'));
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
    //  * @param  \App\Models\Size  $Size
    //  * @return \Illuminate\Http\Response
    //  */
    public function edit($id)
    {
        $data['title'] = 'Edit '.$this->viewName;
        $data['edit'] = Size::withoutGlobalScope('status')->findOrFail($id);
        $data['url'] = route($this->route . '.update', ['id' => $id]);
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        // dd($data);
		return view('admin.general.edit', compact('data'));
    }

}
