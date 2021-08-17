<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Http\Requests\UserRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UserController
{
    use HasCrudActions;

    protected $model = User::class;

    protected $routePrefix = 'admin.users';

    protected $label = 'Users';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = UserRequest::class;

    protected function redirectTo($user)
    {
        return route('admin.users.index',['type'=>$user->roles->first()->name]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //
        $this->view = 'admin.users';
        $this->route = 'admin.users';
        $this->viewName = __('Users');
    }

    public function index($type, Request $request)
    {
        if ($request->ajax()) {
            $query = User::whereHas('roles', function ($q) use ($type) {
                $q->where('name', $type);
            })->where('is_superadmin', '!=', 1)->get();

            return DataTables::of($query)
                ->addColumn('action', function ($row) use ($type) {
                    $btn = view('admin.general.action_btn')->with(['id' => $row->id, 'route' => 'admin.users', 'type' => $type])->render();
                    return $btn;
                })
                ->addColumn('name', function ($user) {
                    return $user->first_name . " " . $user->last_name . "<br>(" . $user->email . ")";
                })
                ->addColumn('checkbox', function ($row) {
                    $chk = view('admin.general.checkbox')->with(['id' => $row->id])->render();
                    return $chk;
                })
                ->addColumn('status', function ($row) {
                    $icon = "fa-square-o";
                    if ($row->status == 1) {
                        $icon = "fa-check-square-o";
                    }
                    $schk = view('admin.general.singlecheckbox')->with(['id' => $row->id, 'column' => 'status', "value" => $row->status, 'icon_class' => $icon, 'class' => 'green'])->render();
                    return $schk;
                })
                ->addColumn('login', function ($row) {
                    return 'login';
                })
                ->addColumn('mobile', function ($row) {
                    return config('settingconfig.Mobile format') . $row->mobile;
                })
                ->addColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('d/m/Y H:i:s');
                })
                ->setRowClass(function () {
                    return 'row-move';
                })
                ->setRowId(function ($row) {
                    return 'row-' . $row->id;
                })
                // ,'image','banner_image'
                ->rawColumns(['name', 'checkbox', 'status', 'action', 'login', 'mobile'])
                ->make(true);
        }
        return view($this->view . '.index', compact('type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        $data['url'] = route($this->route . '.store', array('type' => $type));
        $data['title'] = __('add') . ' ' . __($type);
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        $data['type'] = $type;

        return view('admin.general.create')->with($data);
    }



    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\User  $User
    //  * @return \Illuminate\Http\Response
    //  */
    public function edit($id, $type)
    {
        $data['title'] = __('Edit') . ' ' . __($type);
        $data['edit'] = User::findOrFail($id);
        $data['url'] = route($this->route . '.update', ['id' => $id, 'type' => $type]);
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        $data['type'] = $type;
        return view('admin.general.edit', compact('data'));
    }


    public function changePassword(Request $request)
    {
        $request->validate([
            'new_password' => ['required'],
            'confirm_new_password' => ['same:new_password'],
        ]);

        User::find($request->get('user_id'))->update(['password' => Hash::make($request->new_password)]);

        $res['status'] = 'success';
        $res['message'] = __("Password changed successfully");
        return response()->json($res);
    }

    public function adminChangePassword(Request $request)
    {
        $data = [];
        if ($request->isMethod('post')) {
            $request->validate([
                'old_password' => ['required',  function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('Old Password didn\'t match');
                    }
                },],
                'password' => ['required'],
                'confirm_password' => ['same:password'],
            ]);
            User::find(Auth::user()->id)->update(['password' => Hash::make($request->password)]);
            $data['success'] = __("Password changed successfully");
        }
        return view('admin.users.adminChangePassword')->with($data);
    }
}
