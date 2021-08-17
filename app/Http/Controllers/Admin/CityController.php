<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Http\Requests\CityRequest;

class CityController
{
    use HasCrudActions;

    protected $model = City::class;
    
    protected $routePrefix = 'admin.cities';

    protected $label = 'City';
   

     /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = CityRequest::class;

    protected function redirectTo($city)
    {
        return route("{$this->routePrefix}.index",['type'=>$city->country_id,'type2'=>$city->state_id]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //
        $this->view = 'admin.cities';
        $this->route = $this->routePrefix;
        $this->viewName = __($this->label);
    }

    public function index($type,$type2,Request $request)
    {
        $cities = City::withoutGlobalScope('status')->where('state_id', $type2)->where('country_id', $type)->get();
        
        return view($this->view . '.index', compact('cities','type','type2'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type,$type2)
    {
        $data['type'] = $type;        
        $data['type2'] =$type2;
        $data['url'] = route($this->route . '.store', array('type'=>$type));
        $data['title'] = 'Add ' . $this->viewName;
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
    public function edit($id,$type,$type2)
    {
        $data['type'] =$type;
        $data['type2'] = $type2;
        $data['title'] = 'Edit '.$this->viewName;
        $data['edit'] = City::withoutGlobalScope('status')->findOrFail($id);
        $data['url'] = route($this->route . '.update', ['id' => $id,'type'=>$type]);
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        // dd($data);
		return view('admin.general.edit', compact('data'));
    }

}
