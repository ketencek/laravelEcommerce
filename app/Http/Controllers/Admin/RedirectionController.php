<?php

namespace App\Http\Controllers\Admin;

use App\Models\Redirection;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Http\Requests\RedirectionRequest;
use Illuminate\Support\Facades\View;

class RedirectionController
{
    use HasCrudActions;

    protected $model = Redirection::class;
    
    protected $routePrefix = 'admin.redirections';

    protected $label = 'Redirection';

     /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = RedirectionRequest::class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //
        $this->view = 'admin.redirection';
        $this->route = $this->routePrefix;
        $this->viewName = __($this->label);
        View::share('label', __($this->label));
    }

    public function index(Request $request)
    {
        $redirections = Redirection::withoutGlobalScope('status')->get();
        return view($this->view . '.index', compact('redirections'));
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
    //  * @param  \App\Models\Redirection  $Redirection
    //  * @return \Illuminate\Http\Response
    //  */
    public function edit($id)
    {
        $data['title'] = 'Edit '.$this->viewName;
        $data['edit'] = Redirection::withoutGlobalScope('status')->findOrFail($id);
        $data['url'] = route($this->route . '.update', ['id' => $id]);
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        // dd($data);
		return view('admin.general.edit', compact('data'));
    }

}
