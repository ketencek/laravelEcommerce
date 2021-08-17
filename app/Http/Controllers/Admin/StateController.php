<?php

namespace App\Http\Controllers\Admin;

use App\Models\State;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Http\Requests\StateRequest;
use App\Models\City;
use App\Models\Country;

class StateController
{
    use HasCrudActions;

    protected $model = State::class;
    
    protected $routePrefix = 'admin.states';

    protected $label = 'State';

    

     /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = StateRequest::class;

    protected function redirectTo($state)
    {
        return route("{$this->routePrefix}.index",['type'=>$state->country_id]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //
        $this->view = 'admin.states';
        $this->route = $this->routePrefix;
        $this->viewName = __('State');
    }

    public function index($type,Request $request)
    {
        $states = State::withoutGlobalScope('status')->where('country_id', $type)->get();
        
        return view($this->view . '.index', compact('states','type'));
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
    public function edit($id,$type)
    {
        $data['type'] =$type;
        $data['title'] = 'Edit '.$this->viewName;
        $data['edit'] = State::withoutGlobalScope('status')->findOrFail($id);
        $data['url'] = route($this->route . '.update', ['id' => $id,'type'=> $type]);
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        // dd($data);
		return view('admin.general.edit', compact('data'));
    }

}
