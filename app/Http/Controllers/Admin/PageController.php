<?php

namespace App\Http\Controllers\Admin;

use App\models\Page;
use App\Traits\HasCrudActions;
use Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\StaticPageRequest;
use DataTables;
// use Modules\Page\Http\Requests\SavePageRequest;

class PageController
{
    use HasCrudActions;

       /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Page::class;
    
    protected $routePrefix = 'admin.static-page';

    protected $label = 'StaticPage';
    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = StaticPageRequest::class;

    protected function redirectTo($page)
    {
        return route('admin.static-page.edit',['id'=>$page->id, 'type'=>$page->cat_type]);
    }

    public function __construct(Page $s)
    {
        $this->view = 'admin.page';
        $this->route = 'admin.static-page';
        $this->viewName = __('StaticPage');
        // $this->module_route = url('static-page');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type,Request $request)
    {
        if ($request->ajax()) {
			$query = Page::withoutGlobalScope('status')->where('cat_type',$type)->get();
			
			return DataTables::of($query)
				->addColumn('action', function ($row) use($type) {
					$btn = view('admin.general.action_btn')->with(['id' => $row->id, 'route' => 'admin.static-page','type'=>$type])->render();
					return $btn;
				})
                ->addColumn('name', function ($row) {
                    // echo "<pre>";
                    // print_R( $row->translate('en')->title);
                    // exit;
                    return $row->translate('en')->title;
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
                ->addColumn('on_home', function ($row) {
                    $icon = "fa-home black";
                    if($row->on_home == 1) {
                        $icon = "fa-home green";
                    }
					$schk = view('admin.general.singlecheckbox')->with(['id' => $row->id , 'column'=>'on_home', "value"=>$row->on_home, 'icon_class'=>$icon, 'class'=>'on_home'])->render();
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
				->rawColumns(['name','checkbox', 'status','on_home','action'])
				->make(true);
		}
        return view($this->view . '.index', compact('type'));
    }

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store($type,StaticPageRequest $request)
    // {
    //     $param = $request->all();
    //     $param['type'] = $type;
    //     $param['status']=empty($request->status)? 0 : $request->status;

    //     if ($request->hasFile('image')) {
	// 		$name = ImageHelper::saveUploadedImage(request()->image, 'Banner', storage_path("app/public/uploads/page/"));
    //         $param['image']= $name;
    //     }
    //     if ($request->hasFile('banner_image')) {
	// 		$name = ImageHelper::saveUploadedImage(request()->banner_image, 'Banner', storage_path("app/public/uploads/page/"));
    //         $param['banner_image']= $name;
    //     }
    //     $staticpage = StaticPage::create($param);
   
    //     $staticpage->save();
    //     if ($staticpage){
	// 		return response()->json(['status'=>'success']);
	// 	}else{
	// 		return response()->json(['status'=>'error']);
	// 	}
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$type)
    {
        // dd($id);
        $data['title'] = 'Edit '.$this->viewName;
        $data['edit'] = Page::withoutGlobalScope('status')->findOrFail($id);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(StaticPageRequest $request, $id)
    // {
    //     $param = $request->all();
    //     // dd($param);
    //     $type= $param['type'];
    //     $param['status']=empty($request->status)? 0 : $request->status;
    //     unset($param['_token'], $param['_method'],$param['type']);

    //     if ($request->hasFile('image')) {
	// 		$name = ImageHelper::saveUploadedImage(request()->image, 'Banner', storage_path("app/public/uploads/page/"));
    //         $param['image']= $name;
    //     }
    //     if ($request->hasFile('banner_image')) {
	// 		$name = ImageHelper::saveUploadedImage(request()->banner_image, 'Banner', storage_path("app/public/uploads/page/"));
    //         $param['banner_image']= $name;
    //     }
    //     $staticpage = StaticPage::where('id', $id);
    //     $staticpage->update($param);
        
    //     if ($staticpage){
	// 		return response()->json(['status'=>'success']);
	// 	}else{
	// 		return response()->json(['status'=>'error']);
	// 	}
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}