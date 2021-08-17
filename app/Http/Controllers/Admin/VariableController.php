<?php

namespace App\Http\Controllers\Admin;

use App\Models\Variable;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Http\Requests\VariablesRequest;
use Excel;
use App\Imports\VariablesImport;
use App\Exports\VariablesExport;

class VariableController
{
    use HasCrudActions;

    protected $model = Variable::class;
    
    protected $routePrefix = 'admin.variables';

    protected $label = 'page::pages.page';

     /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = VariablesRequest::class;

    protected function redirectTo($variable)
    {
        return route('admin.variables.index',['type'=>$variable->cat_type]);
    }

    public function __construct(Variable $s)
    {
        $this->view = 'admin.variables';
        $this->route = 'admin.variables';
        $this->viewName = 'Variable';
        // $this->module_route = url('static-page');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type,Request $request)
    {        
        $variables = Variable::withoutGlobalScope('status')->where('cat_type',$type)->get();
        return view($this->view . '.index', compact('type', 'variables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        // echo "<prE>";
        // print_r(\Config::get('translatable.locales'));
        // exit;
        $title= '';
        if ($type == 'OTHER') {
             $title= __('Variable');
        } else {
             $title= __($type) . ' '.__('Variable');
        } 
        $data['url'] = route($this->route . '.store',array('type'=>$type));
        $data['title'] = $title;
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        $data['type'] = $type;

        return view('admin.general.create')->with($data);
    }

    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Variable  $variable
     * @return \Illuminate\Http\Response
     */
    public function show(Variable $variable)
    {
        //
    }

  

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Variable  $variable
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$type)
    {
        // dd($id);
        $data['title'] = 'Edit '.$this->viewName;
        $data['edit'] = Variable::withoutGlobalScope('status')->findOrFail($id);
        $data['url'] = route($this->route . '.update', ['id' => $id, 'type'=>$type]);
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        $data['type']=$type;
        // dd($data);
		return view('admin.general.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Variable  $variable
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, Variable $variable)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Variable  $variable
     * @return \Illuminate\Http\Response
     */
    public function destroy(Variable $variable)
    {
        //
    }

    public function import()
    { 
        $params = request()->file('upl');
        $extension =  $params->clientExtension();
        
        if($extension =='xls' || $extension =='xlsx') {
            Excel::import(new VariablesImport,$params);   
            Variable::saveInTranslationFile();
        return response()->json(['status'=>'success', 'message'=>__('Imported successfuly')]);   
        } else {
            return response()->json(['status'=>'success', 'message'=>__('File type must be .xls or .xlsx')]);      
        }
        
    }

    public function export()
    { 
        $ids = request()->get('id');
        return Excel::download(new VariablesExport($ids), 'hummel_variable.xlsx');        
    }

    public function generateTranslationFile() {
        Variable::saveInTranslationFile();
        return redirect()->back()->with('msg', __('msg_file_generated'));
    }
}
