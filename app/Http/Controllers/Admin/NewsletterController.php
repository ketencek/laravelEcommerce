<?php

namespace App\Http\Controllers\Admin;

use App\Exports\NewsletterExport;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Http\Requests\NewsletterRequest;
use App\Imports\NewsletterImport;
use Illuminate\Support\Facades\View;
use DataTables;
use Excel;

class NewsletterController
{
    use HasCrudActions;

    protected $model = Newsletter::class;
    
    protected $routePrefix = 'admin.newsletters';

    protected $label = 'Newsletter';

     /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = NewsletterRequest::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //
        $this->view = 'admin.newsletter';
        $this->route = $this->routePrefix;
        $this->viewName = __($this->label);
        View::share('label', __($this->label));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
			$query = Newsletter::withoutGlobalScope('status')->get();
			
			return DataTables::of($query)
				->addColumn('action', function ($row) {
					$btn = view('admin.general.action_btn')->with(['id' => $row->id, 'route' => 'admin.newsletters','is_not_ord'=>'yes'])->render();
					return $btn;
				})
				->addColumn('checkbox', function ($row) {
					$chk = view('admin.general.checkbox')->with(['id' => $row->id])->render();
					return $chk;
				})
				->addColumn('status', function ($row) {
                    $icon = "fa-square-o";
                    if($row->status == 1) {
                        $icon = "fa-check-square-o";
                    }
					$schk = view('admin.general.singlecheckbox')->with(['id' => $row->id , 'column'=>'status', "value"=>$row->status, 'icon_class'=>$icon, 'class'=>'green'])->render();
					return $schk;
                })
                ->addColumn('is_subscribed', function ($row) {
                    $icon = "fa-square-o";
                    if($row->is_subscribed == 1) {
                        $icon = "fa-check-square-o";
                    }
					$schk = view('admin.general.singlecheckbox')->with(['id' => $row->id , 'column'=>'is_subscribed', "value"=>$row->is_subscribed, 'icon_class'=>$icon, 'class'=>'green'])->render();
					return $schk;
                })
                // ->editColumn('image', function ($row) {
                //     return view('admin.layout.image')->with(['image'=>$row->image,'folder_name'=>"page"]);
                    
                // })
                // ->editColumn('banner_image', function ($row) {
                //     return view('admin.layout.image')->with(['image'=>$row->banner_image,'folder_name'=>"page"]);
                    
				// })
				->setRowClass(function () {
					return 'row-move';
				})
				->setRowId(function ($row) {
					return 'row-' . $row->id;
				})
                // ,'image','banner_image'
				->rawColumns(['checkbox', 'status','is_subscribed','action'])
				->make(true);
		}
        return view($this->view . '.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['url'] = route($this->route . '.store');
        $data['title'] = __('Add').' '. __($this->label);
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;

        return view('admin.general.create')->with($data);
    }

   

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\Newsletter  $Newsletter
    //  * @return \Illuminate\Http\Response
    //  */
    public function edit($id)
    {
        $data['title'] = __('Edit').' '. __($this->label);
        $data['edit'] = Newsletter::withoutGlobalScope('status')->findOrFail($id);
        $data['url'] = route($this->route . '.update', ['id' => $id]);
        // $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        // dd($data);
		return view('admin.general.edit', compact('data'));
    }


    public function Export(Request $request) {
        return Excel::download(new NewsletterExport(), __('Newsletter').'.xlsx');   
    }

    public function Import(Request $request) {
        if ($request->isMethod('post')) {
            $params = request()->file('file');
            $extension =  $params->clientExtension();
            $subscribe_type = $request->get('newletter_type');
            if($extension =='xls' || $extension =='xlsx') {
               
                // $import = new NewsletterImport($subscribe_type);
                // $import->import($params);
                $import =  Excel::import(new NewsletterImport($subscribe_type), $params);
                
                return redirect()->back()->with('msg',__('Imported successfully'));
                // dd($import->errors());
                // exit;
            }
        }
        return view('admin.newsletter.import');
    }
}
