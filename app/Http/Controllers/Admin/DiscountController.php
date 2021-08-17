<?php

namespace App\Http\Controllers\Admin;

use App\Models\Discount;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Http\Requests\DiscountRequest;
use App\Models\DiscountUser;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;

class DiscountController
{
    use HasCrudActions;

    protected $model = Discount::class;
    
    protected $routePrefix = 'admin.discounts';

    protected $label = 'Discount';

    

     /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = DiscountRequest::class;

    protected function redirectTo($discount, $store_variable)
    {
        if(isset($store_variable['user_id'])) {
            DiscountUser::where('discount_id', $discount['id'])->delete();

            $users = explode(',',$store_variable['user_id']);
            foreach($users as $user) {
                $d_u = new DiscountUser();
                $d_u->discount_id = $discount['id'];
                $d_u->user_id = $user;
                $d_u->save();
            }
        }
        
        if(!$discount['discount_code']) {
            return route("{$this->routePrefix}.index",['type'=>'general']);
        } else {
            return route("{$this->routePrefix}.index",['type'=>'global-user']);
        }
        // return route("{$this->routePrefix}.edit",['id'=>$disocunt->id]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //
        $this->view = 'admin.discount';
        $this->route = $this->routePrefix;
        $this->viewName = __($this->label);
        View::share('label', __($this->label));
    }

    public function index($type,Request $request)
    {
        if ($request->ajax()) {
			$discount = Discount::withoutGlobalScope('status');
            if($type == 'general') {
                $discount->whereNull('discount_code')->orWhere('discount_code','');
            } else {
                $discount->whereNotNull('discount_code')->orWhere('discount_code','!=','');
            }
            
            $query = $discount->get();
         			
			return DataTables::of($query)
				->addColumn('action', function ($row) use ($type) {
					$btn = view('admin.general.action_btn')->with(['id' => $row->id, 'route' => 'admin.discounts','type'=>$type])->render();
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
                ->addColumn('discount_percentage', function ($row) {
					return $row->discount_percentage.'%';
                })
                ->setRowClass(function () {
					return 'row-move';
				})
				->setRowId(function ($row) {
					return 'row-' . $row->id;
				})
				->rawColumns(['name','checkbox', 'status','discount_percentage','action'])
				->make(true);
		}
        // $discounts = Discount::withoutGlobalScope('status')->where('Discount_category_id', $type)->get();
        
        return view($this->view . '.index', compact('type'));
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
        $data['edit'] = Discount::withoutGlobalScope('status')->findOrFail($id);
        // echo "<pre>";
        // print_r($data['edit']->toArray());
        // exit;
        $data['url'] = route($this->route . '.update', ['id' => $id,'type'=> $type]);
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        // dd($data);
		return view('admin.general.edit', compact('data'));
    }

    public function findUser(Request $request) {
        $values = ['query' => $request->get('query')];
        $users = User::getUserListForDiscount('client', $values);
        echo json_encode($users);
		exit;
    }

}
