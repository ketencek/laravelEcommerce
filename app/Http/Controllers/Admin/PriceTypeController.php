<?php

namespace App\Http\Controllers\Admin;

use App\Models\PriceType;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Http\Requests\PriceTypeRequest;

class PriceTypeController
{
    use HasCrudActions;

    protected $model = PriceType::class;
    
    protected $routePrefix = 'admin.price-type';

    protected $label = 'Price Type';

     /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = PriceTypeRequest::class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //
        $this->view = 'admin.pricetype';
        $this->route = 'admin.price-type';
        $this->viewName = __('Price Type');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $priceTypes = PriceType::withoutGlobalScope('status')->get();
        return view($this->view . '.index', compact('priceTypes'));
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
    //  * @param  \App\Models\PriceType  $PriceType
    //  * @return \Illuminate\Http\Response
    //  */
    public function edit($id)
    {
        $data['title'] = 'Edit '.$this->viewName;
        $data['edit'] = PriceType::withoutGlobalScope('status')->findOrFail($id);
        $data['url'] = route($this->route . '.update');
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        // dd($data);
		return view('admin.general.edit', compact('data'));
    }
}
