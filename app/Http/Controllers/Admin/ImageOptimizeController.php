<?php

namespace App\Http\Controllers\Admin;

use App\Models\ImageOptimize;
use App\Traits\HasCrudActions;
use Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\ImageOptimizeRequest;
use DataTables;
use DB;
// use Modules\Page\Http\Requests\SavePageRequest;

class ImageOptimizeController
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = ImageOptimize::class;

    protected $routePrefix = 'admin.image-optimize';

    protected $label = 'page::pages.page';
    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = ImageOptimizeRequest::class;

    public function __construct(ImageOptimize $s)
    {
        $this->view = 'admin.imageoptimize';
        $this->route = 'admin.image-optimizes';
        $this->viewName = 'ImageOptimize';
        // $this->module_route = url('static-page');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $i_o_array = ImageOptimize::getImageOptimize();

        return view($this->view . '.index', compact('i_o_array'));
    }

    public function create()
    {
        $data['url'] = route($this->route . '.store');
        $data['title'] = __('Image optimize');
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;

        return view('admin.general.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageOptimizeRequest $request)
    {
        $exist_module = ImageOptimize::where('module_name', $request->module_name)->first();
        if (!$exist_module) {
            foreach ($request->thumb_folder as $key => $value) {
                if ((isset($request->width[$value]) || $request->width[$value] != 0) && (isset($request->height[$value]) || $request->height[$value] != 0)) {
                    $image = ImageOptimize::create([
                        'module_name' => $request->module_name,
                        'crop_ratio' => $request->crop_ratio,
                        'thumb_folder' => $value,
                        'width' => $request->width[$value],
                        'height' => $request->height[$value],
                        'is_optimise' => isset($request->is_optimise[$value]) ? $request->is_optimise[$value] : 0,
                    ]);
                }
            }
            ImageOptimize::saveImageSize();
            return redirect()->route($this->route . '.index')->withSuccess(__('Image Optimize added Successfully'));
        } else {
            return redirect()->route($this->route . '.index')->withError(__('Module name already exist.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        $data['title'] = 'Edit ' . $this->viewName;
        $record = ImageOptimize::getImageOptimize(['module_name' => $id]);
        $data['edit'] = $record[0];
        $data['url'] = route($this->route . '.update', ['id' => $id]);
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        // dd($data);s
        return view('admin.general.edit', compact('data'));
    }

    public function update(ImageOptimizeRequest $request, $id)
    {

        foreach ($request->thumb_folder as $key => $value) {
            $exist_module = ImageOptimize::where('module_name', $id)->where('thumb_folder', $value)->first();
            if ((isset($request->width[$value]) && $request->width[$value] != 0) && (isset($request->height[$value]) && $request->height[$value] != 0)) {

                if (!$exist_module) {
                    $image = ImageOptimize::create([
                        'module_name' => $request->module_name,
                        'crop_ratio' => $request->crop_ratio,
                        'thumb_folder' => $value,
                        'width' => $request->width[$value],
                        'height' => $request->height[$value],
                        'is_optimise' => isset($request->is_optimise[$value]) ? $request->is_optimise[$value] : 0,
                    ]);
                } else {
                        $exist_module->module_name = $request->module_name;
                        $exist_module->crop_ratio = $request->crop_ratio;
                        $exist_module->thumb_folder = $value;
                        $exist_module->width = $request->width[$value];
                        $exist_module->height = $request->height[$value];
                        $exist_module->is_optimise = isset($request->is_optimise[$value]) ? $request->is_optimise[$value] : 0;
                        $exist_module->save();
                }
            } else {
                if($exist_module){
                    $exist_module->delete();
                }
            }
        }
        ImageOptimize::saveImageSize();
        // exit;
        return redirect()->route($this->route . '.index')->withSuccess(__('Image Optimize updated Successfully'));
    }


    public function destroy($id)
    {
        // $module = $id;
        DB::table('image_optimizes')->where('module_name', $id)->delete();
        $res['status'] = 'Success';
        $res['message'] = 'Deleted successfully';
        return response()->json($res);
    }
}
