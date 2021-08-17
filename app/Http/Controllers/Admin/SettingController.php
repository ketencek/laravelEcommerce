<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Http\Requests\SettingsRequest;

class SettingController
{
    use HasCrudActions;

    protected $model = Setting::class;
    
    protected $routePrefix = 'admin.settings';

    protected $label = 'Settings';

     /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SettingsRequest::class;

    protected function redirectTo($setting)
    {
        return route('admin.settings.index',['type'=>$setting->label]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //
        $this->view = 'admin.settings';
        $this->route = 'admin.settings';
        $this->viewName = __('Settings');
    }

    /**
     * Display a listing of the setting Type.
     *
     * @return \Illuminate\Http\Response
     */
    public function  typeList(Request $request) {
        // $module_name = config('custom_setting.image_optimize_module_name');
        return view($this->view . '.typelist');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type,Request $request)
    {
        $settings = Setting::where('label',$type)->get();
        return view($this->view . '.index', compact('type', 'settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        $data['url'] = route($this->route . '.store',array('type'=>$type));
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
    //  * @param  \App\Models\Setting  $setting
    //  * @return \Illuminate\Http\Response
    //  */
    public function edit($id, $type)
    {
        $data['title'] = 'Edit '.$this->viewName;
        $data['edit'] = Setting::findOrFail($id);
        $data['url'] = route($this->route . '.update', ['id' => $id, 'type'=>$type]);
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        $data['type']=$type;
        // dd($data);
		return view('admin.general.edit', compact('data'));
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\Setting  $setting
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, Setting $setting)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Setting  $setting
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Setting $setting)
    // {
    //     //
    // }
}
