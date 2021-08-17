<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Http\Requests\FaqRequest;
use Illuminate\Support\Facades\View;

class FaqController
{
    use HasCrudActions;

    protected $model = Faq::class;
    
    protected $routePrefix = 'admin.faqs';

    protected $label = 'Faq';

    

     /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = FaqRequest::class;

    protected function redirectTo($faq)
    {
        return route("{$this->routePrefix}.edit",['id'=>$faq->id,'type'=>$faq->faq_category_id]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //
        $this->view = 'admin.faq';
        $this->route = $this->routePrefix;
        $this->viewName = __($this->label);
        View::share('label', __($this->label));
    }

    public function index($type,Request $request)
    {
        $faqs = Faq::withoutGlobalScope('status')->where('Faq_category_id', $type)->get();
        
        return view($this->view . '.index', compact('faqs','type'));
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
        $data['title'] = __('Add').' '. __($this->label);
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
        $data['title'] = __('Edit').' '. __($this->label);
        $data['edit'] = Faq::withoutGlobalScope('status')->findOrFail($id);
        // echo "<pre>";
        // print_r($data['edit']->toArray());
        // exit;
        $data['url'] = route($this->route . '.update', ['id' => $id,'type'=> $type]);
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        // dd($data);
		return view('admin.general.edit', compact('data'));
    }

}
