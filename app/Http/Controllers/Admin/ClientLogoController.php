<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Models\ClientLogo;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Http\Requests\ClientLogoRequest;

class ClientLogoController
{
    use HasCrudActions;

    protected $model = ClientLogo::class;

    protected $routePrefix = 'admin.logos';

    protected $label = 'Client Logo';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = ClientLogoRequest::class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //
        $this->view = 'admin.logo';
        $this->route = $this->routePrefix;
    }

    public function index($type, Request $request)
    {
        $logos = ClientLogo::withoutGlobalScope('status')->where('cat_type', $type)->get();
        return view($this->view . '.index', compact('logos', 'type'));
    }

    public function addImage(Request $request)
    {
        if ($request->ajax()) {
            if ($request->hasFile('image')) {
                $name = ImageHelper::saveUploadedImage(request()->image, $request->get('type'), config('customconfig.path.doc.' . $request->get('folder_name')));

                if (!$name) {
                    $res['status'] = 'error';
                    $res['message'] = 'Something went Wrong.';
                } else {

                    $param = $request->all();
                    $param['status'] = isset($param['status']) ? $param['status'] : 0;
                    $param['cat_type'] = $param['type'];
                    unset($param['_token'], $param['type']);
                    $param['image'] = $name;

                    $image = ClientLogo::create($param);
                    $image->save();

                    $res['status'] = 'success';
                    $res['message'] = __('Record updated successfully');
                }
                return response()->json($res);
            }
        }
    }

    public function addName(Request $request)
    {
        if ($request->ajax()) {
            $client_logo_id = $request->get('id');
            $logo = ClientLogo::withoutGlobalScope('status')->find($client_logo_id);
            if ($logo) {
                $logo->link = $request->get('name-tr');
                $logo->save();

                $res['success'] = 1;
                $res['id'] = $client_logo_id;
            } else {
                $res['success'] = 0;
            }
            return response()->json($res);
        }
    }
}
