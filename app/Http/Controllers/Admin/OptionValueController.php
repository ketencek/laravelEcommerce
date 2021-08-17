<?php

namespace App\Http\Controllers\Admin;

use App\Models\OptionValue;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Http\Requests\OptionValueRequest;

class OptionValueController
{
    use HasCrudActions;

    protected $model = OptionValue::class;
    
    protected $routePrefix = 'admin.option-values';

    protected $label = 'Option';

     /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = OptionValueRequest::class;

    protected function redirectTo($ovalue)
    {
        return route('admin.option-values.index',['type'=>$ovalue->option_id]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //
        $this->view = 'admin.optionvalues';
        $this->route = 'admin.option-values';
        $this->viewName = __('Option');
    }

    public function index($type,Request $request)
    {
        $optionvalues = OptionValue::withoutGlobalScope('status')->get();
        return view($this->view . '.index', compact('optionvalues','type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        $data['url'] = route($this->route . '.store', array('type'=>$type));
        $data['title'] = 'Add ' . $this->viewName;
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        $data['type'] = $type;

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
        $data['title'] = 'Edit '.$this->viewName;
        $data['edit'] = OptionValue::withoutGlobalScope('status')->findOrFail($id);
        $data['url'] = route($this->route . '.update', ['id' => $id,'type'=> $type]);
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        // dd($data);
		return view('admin.general.edit', compact('data'));
    }

}
