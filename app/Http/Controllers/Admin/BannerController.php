<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Http\Requests\BannerRequest;

class BannerController
{
    use HasCrudActions;

    protected $model = Banner::class;
    
    protected $routePrefix = 'admin.banner';

    protected $label = 'Banner';

     /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = BannerRequest::class;

    protected function redirectTo($banner)
    {
        return route('admin.banners.index',['type'=>$banner->cat_type]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //
        $this->view = 'admin.banner';
        $this->route = 'admin.banner';
        $this->viewName = __('Banner');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type)
    {
        $banners = Banner::withoutGlobalScope('status')->where('type', $type)->get();
        return view($this->view . '.index', compact('type', 'banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        $data['url'] = route($this->route . '.store', array('type'=>$type));
        $data['title'] = __('Add').' '. __($type);
        // $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        $data['type'] = $type;

        return view('admin.general.create')->with($data);
    }

   

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\Banner  $Banner
    //  * @return \Illuminate\Http\Response
    //  */
    public function edit($id, $type)
    {
        $data['title'] = __('Edit').' '. __($type);
        $data['edit'] = Banner::withoutGlobalScope('status')->findOrFail($id);
        $data['url'] = route($this->route . '.update', ['id' => $id, 'type' => $type]);
        // $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        $data['type'] = $type;
        // dd($data);
		return view('admin.general.edit', compact('data'));
    }

}
