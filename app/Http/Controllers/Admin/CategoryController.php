<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\models\Category;
use App\Http\Requests\SaveCategoryRequest;
use DataTables;

class CategoryController
{
    use HasCrudActions;
    protected $model = Category::class;
    
    protected $routePrefix = 'admin.category';

    protected $label = 'page::pages.page';

     /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveCategoryRequest::class;

    protected function redirectTo($category)
    {
        return route('admin.category.edit',['id'=>$category->id]);
    }

    public function __construct(Category $model)
    {
        $this->view = 'admin.category';
        $this->route = 'admin.category';
        $this->viewName = 'Category';
        $this->model =  $model;
        // $this->module_route = url('static-page');
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
			$category_level = $this->model->treeList();
            $order = implode(',', array_keys($category_level));

            $query = Category::whereRaw('1=1');
            if($order != ''){
                $query->orderByRaw("FIELD(id, ".$order.")");
                }
			$query->get();
			
			return DataTables::of($query)
				->addColumn('action', function ($row)  {
					$btn = view('admin.general.action_btn')->with(['id' => $row->id, 'route' => 'admin.category','is_not_ord'=>'yes'])->render();
					return $btn;
				})
                ->addColumn('name', function ($row) use($category_level){
					return html_entity_decode($category_level[$row->id]);
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
				->setRowClass(function () {
					return 'row-move';
				})
				->setRowId(function ($row) {
					return 'row-' . $row->id;
				})
				->rawColumns(['name','checkbox', 'status','on_home','action'])
				->make(true);
		}
        return view($this->view . '.index');
    }

    public function create()
    {
        $data['url'] = route($this->route . '.store');
        $data['title'] = 'Add ' . $this->viewName;
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        $data['categories_select'] = $this->getCategory();
        // echo "<pre>";
        // print_r($data);
        // exit;

        return view('admin.general.create')->with($data);
    }

    public function getCategory() {
        $category_level = $this->model->treeList();
        return  $category_level ;
   }

   public function edit($id)
   {
       $data['title'] = 'Edit '.$this->viewName;
       $data['edit'] = Category::withoutGlobalScope('status')->findOrFail($id);
       $data['url'] = route( $this->route . '.update', ['id' => $id]);
       $data['module'] = $this->viewName;
       $data['resourcePath'] = $this->view;
       $data['route'] = $this->route;
       $data['categories_select'] = $this->getCategory();
       
       return view('admin.general.edit', compact('data'));//->with($data);
   }




   public function manageCategory(Request $request) {
    $category_tree = $this->model->tree();
       
    return view('admin.category.treeview', compact('category_tree'));   
   }


}
