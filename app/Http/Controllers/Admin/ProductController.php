<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use App\Traits\HasCrudActions;
use Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\ProductRequest;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\PriceType;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductKeyword;
use App\Models\ProductOption;
use App\Models\ProductPrice;
use App\Models\ProductQuantity;
use App\Models\ProductSize;
use DataTables;

class ProductController
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Product::class;

    protected $routePrefix = 'admin.products';

    protected $label = 'Product';
    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = ProductRequest::class;

    protected function redirectTo($product)
    {
        return route('admin.products.edit',['id'=>$product->id]);
    }

    public function __construct(Product $s)
    {
        $this->view = 'admin.products';
        $this->route = 'admin.products';
        $this->viewName = __('Product');
        // $this->module_route = url('products');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Product::withoutGlobalScope('status')->get();

            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    $btn = view('admin.general.action_btn')->with(['id' => $row->id, 'route' => 'admin.products'])->render();
                    return $btn;
                })
                ->addColumn('name', function ($row) {
                    return (isset($row->translate(config('settingconfig.admin_default_language'))->name) ? $row->translate(config('settingconfig.admin_default_language'))->name : '');
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
                ->addColumn('on_home', function ($row) {
                    $icon = "fa-home black";
                    if ($row->on_home == 1) {
                        $icon = "fa-home green";
                    }
                    $schk = view('admin.general.singlecheckbox')->with(['id' => $row->id, 'column' => 'on_home', "value" => $row->on_home, 'icon_class' => $icon, 'class' => 'on_home'])->render();
                    return $schk;
                })
                ->addColumn('is_new', function ($row) {
                    $icon = "fa-square-o";
                    if ($row->is_new == 1) {
                        $icon = "fa-check-square-o";
                    }
                    $schk = view('admin.general.singlecheckbox')->with(['id' => $row->id, 'column' => 'is_new', "value" => $row->is_new, 'icon_class' => $icon, 'class' => 'green'])->render();
                    return $schk;
                })
                ->setRowClass(function () {
                    return 'row-move';
                })
                ->setRowId(function ($row) {
                    return 'row-' . $row->id;
                })
                // ,'image','banner_image'
                ->rawColumns(['name', 'checkbox', 'status', 'on_home', 'is_new', 'action'])
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

        return view('admin.general.create')->with($data);
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
        $data['edit'] = Product::withoutGlobalScope('status')->findOrFail($id);
        $data['url'] = route($this->route . '.update', ['id' => $id]);
        $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        // dd($data);
        return view('admin.general.edit', compact('data'));
    }

    // product category Tab start
    public function getCategoryTab(Request $request)
    {
        if ($request->ajax()) {
            $product_id = $request->get('product_id');
            $product = Product::withoutGlobalScope('status')->find($product_id);

            if ($request->isMethod('post')) {
                $param = $request->all();

                $product->categories()->sync($param['product']['category'], true);

                $res['status'] = 'success';
                $res['message'] = __('Category Save successfully');
                return response()->json($res);
            }
            $categories = Category::tree();
            return view('admin.products.getCategoryTab')->with(['categories' => $categories, 'product' => $product]);
        }
    }

    // product Color Tab start
    public function getColorTab(Request $request)
    {
        if ($request->ajax()) {
            $product_id = $request->get('product_id');
            $product = Product::withoutGlobalScope('status')->find($product_id);
            if ($request->has('id')) {
                $product->colors()->sync($request->get('id'), false);
                $res['status'] = 'success';
                $res['message'] =  __('Record updated successfully');
                return response()->json($res);
            }
            $selected_colors = $product->colors->toArray();
            // $selected_colors = array_column($selected_colors, 'id');
            // echo "<pre>";
            // print_r($selected_colors);
            // exit;
            return view('admin.products.getColorTab')->with(['selectedcolors' => $selected_colors]);
        }
    }
    public function findProductColor(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->get('query');
            $locale = config('settingconfig.admin_default_language');
            $colors = Color::whereHas('translations', function ($query)  use ($search, $locale) {
                $query->whereRaw('name like ?', array('%' . $search . '%'));
                $query->where('locale',  $locale);
            })
                ->get();

            $return_array = [];
            foreach ($colors as $color) {
                $return_array[] = array(
                    'Id' => $color->id,
                    'Name' => $color->name
                );
            }
            return response()->json($return_array);
        }
    }
    public function deleteProductColor(Request $request)
    {
        if ($request->ajax()) {

            $id = $request->get('id');

            $pc = ProductColor::find($id);

            if ($pc) {
                $product_id = $pc->product_id;
                $color_id = $pc->color_id;
                $pc->delete();

                $product_quantity = ProductQuantity::where('product_id', $product_id)->where('color_id', $color_id)->first();
                if ($product_quantity) {
                    $product_quantity->delete();
                }
                $product_price = ProductPrice::where('product_id', $product_id)->where('color_id', $color_id)->first();
                if ($product_price) {
                    $product_price->delete();
                }
            }

            $res['status'] = 'success';
            $res['message'] = __('Record deleted successfully');
            return response()->json($res);
        }
    }

    public function getSizeTab(Request $request)
    {
        if ($request->ajax()) {
            $product_id = $request->get('product_id');
            $product = Product::withoutGlobalScope('status')->find($product_id);
            if ($request->has('id')) {
                $product->sizes()->sync($request->get('id'), false);
                $res['status'] = 'success';
                $res['message'] =  __('Record updated successfully');
                return response()->json($res);
            }
            $selected_sizes = $product->sizes->toArray();
            // $selected_colors = array_column($selected_colors, 'id');
            // echo "<pre>";
            // print_r($selected_colors);
            // exit;
            return view('admin.products.getSizeTab')->with(['selectedsizes' => $selected_sizes]);
        }
    }

    public function findProductSize(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->get('query');
            $locale = config('settingconfig.admin_default_language');
            $sizes = Size::whereHas('translations', function ($query)  use ($search, $locale) {
                $query->whereRaw('name like ?', array('%' . $search . '%'));
                $query->where('locale',  $locale);
            })
                ->get();

            $return_array = [];
            foreach ($sizes as $size) {
                $return_array[] = array(
                    'Id' => $size->id,
                    'Name' => $size->name
                );
            }
            return response()->json($return_array);
        }
    }
    public function deleteProductSize(Request $request)
    {
        if ($request->ajax()) {

            $id = $request->get('id');

            $pc = ProductSize::find($id);

            if ($pc) {
                $product_id = $pc->product_id;
                $size_id = $pc->size_id;
                $pc->delete();

                $product_quantity = ProductQuantity::where('product_id', $product_id)->where('size_id', $size_id)->first();
                if ($product_quantity) {
                    $product_quantity->delete();
                }
                $product_price = ProductPrice::where('product_id', $product_id)->where('size_id', $size_id)->first();
                if ($product_price) {
                    $product_price->delete();
                }
            }

            $res['status'] = 'success';
            $res['message'] = __('Record deleted successfully');
            return response()->json($res);
        }
    }


    public function getImageTab(Request $request)
    {
        if ($request->ajax()) {
            $product_id = $request->get('product_id');
            $product = Product::withoutGlobalScope('status')->find($product_id);

            // $size  = config('imageSize.Product.big') ? config('imageSize.Product.big') : "0";

            $data['images'] = $product->product_images->toArray();
            $data['colors'] = $product->colors->toArray();
            $data['product'] = $product;
            // $data['size'] = 
            // echo "<pre>";
            // print_r($data);
            // exit;
            return view('admin.products.getImageTab')->with($data);
        }
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
                    unset($param['_token']);
                    $param['image'] = $name;
                    $image = ProductImage::create($param);
                    $image->save();

                    $res['status'] = 'success';
                    $res['message'] = __('Record updated successfully');
                }
                return response()->json($res);
            }
        }
    }

    public function getColorPopUp(Request $request)
    {
        if ($request->ajax()) {
            $product_id = $request->get('product_id');
            $product = Product::withoutGlobalScope('status')->find($product_id);
            $data['colors'] = $product->colors->toArray();
            $data['product_id'] = $product_id;
            $data['id'] = $request->get('id');
            $data['color_id'] = $request->get('color_id');

            $res['html'] = view('admin.products.getColorPopUp')->with($data)->render();
            $res['message'] = 'success';
            return response()->json($res);
        }
    }
    public function saveImageColor(Request $request)
    {
        if ($request->ajax()) {
            $product_id = $request->get('product_id');
            $id = $request->get('id');
            $color_id = $request->get('color_id');

            if ($id == NULL) {
                $productimage = new ProductImage();
                $productimage->product_id = $product_id;
            } else {
                $productimage = ProductImage::find($id);
            }

            if (!$productimage) {
                $productimage = new ProductImage();
                $productimage->product_id = $product_id;
            }

            $productimage->color_id = $color_id;
            $productimage->status = 1;
            $productimage->save();
            $productimage->ord = $productimage->id;
            $productimage->save();

            $res['id'] = $productimage->id;
            $res['status'] = 'success';
            $res['message'] = __('Record updated successfully');
            return response()->json($res);
        }
    }

    public function getAttributeTab(Request $request)
    {
        if ($request->ajax()) {
            $product_id = $request->get('product_id');
            $product = Product::withoutGlobalScope('status')->find($product_id);
            $data['product_options'] = array_column($product->optionvalues->toArray(), 'option_value_id');
            $data['options'] = Option::withoutGlobalScope('status')->get();
            $data['product_id'] = $product_id;

            return view('admin.products.getAttributeTab')->with($data);
        }
    }

    public function saveProductOptions(Request $request)
    {
        if ($request->ajax()) {
            $params = $request->all();
            $product_id = $request->get('product_id');
            foreach ($params['optionvalue'] as $option_id => $option_value_id) {
                $pc = ProductOption::where('option_id', $option_id)->where('product_id', $product_id)->first();
                if ($option_value_id != '') {
                    if (!$pc) {
                        $pc = new ProductOption();
                    }
                    $pc->product_id = $product_id;
                    $pc->option_id = $option_id;
                    $pc->option_value_id = $option_value_id;
                    $pc->save();
                } else {
                    if ($pc) {
                        $pc->delete();
                    }
                }
            }
            $res['status'] = 'success';
            $res['message'] = __('Record updated successfully');

            return response()->json($res);
        }
    }

    public function getInventoryTab(Request $request)
    {
        if ($request->ajax()) {
            $product_id = $request->get('product_id');
            $p_type = Product::withoutGlobalScope('status')->findOrFail($product_id);
            $product_type = $p_type['product_type'];

            if ($product_type != 'NoColorSize') {
                if ($product_type == 'ColorBase' || $product_type == 'BOTH') {
                    $data['colors'] = $p_type->colors->toArray();
                }
                if ($product_type == 'SizeBase' || $product_type == 'BOTH') {
                    $data['sizes'] = $p_type->sizes->toArray();
                }
            }
            $product_quantity =  $p_type->product_quantities->toArray();
            $qty = 0;
            $array = [];
            if (count($product_quantity) > 0) {
                foreach ($product_quantity as $qua) {
                    if ($product_type == 'BOTH') {
                        $array[$qua['color_id'] . "_" . $qua['size_id']] = $qua['quantity'];
                    } elseif ($product_type == 'ColorBase') {
                        $array[$qua['color_id']] = $qua['quantity'];
                    } elseif ($product_type == 'SizeBase') {
                        $array[$qua['size_id']] = $qua['quantity'];
                    } else {
                        $array = $qua['quantity'];
                    }
                    $qty = $qua['quantity'] + $qty;
                }
            }

            $data['array'] = $array;
            $data['totalquantity'] = $qty;
            $data['product_type'] = $product_type;
            $data['product_id'] = $product_id;

            return view('admin.products.getInventoryTab')->with($data);
        }
    }

    public function saveProductQuantity(Request $request)
    {
        if ($request->ajax()) {
            $color_id = $request->get('color_id');
            $size_id = $request->get('size_id');
            $product_id = $request->get('product_id');
            $quantity = $request->get('value');

            $pq = ProductQuantity::where('product_id', $product_id)->where('size_id', $size_id)->where('color_id', $color_id)->first();
            if ($quantity != 0 &&  $quantity != '') {
                if (!$pq) {
                    $pq = new ProductQuantity();
                }
                $pq->product_id = $product_id;
                $pq->color_id = $color_id;
                $pq->size_id = $size_id;
                $pq->quantity = $quantity;
                $pq->save();
            } else {
                if ($pq) {
                    $pq->delete();
                }
            }

            $res['status'] = 'success';
            $res['message'] = __('Record updated successfully');
            return response()->json($res);
        }
    }

    public function getPriceTab(Request $request)
    {
        if ($request->ajax()) {
            $product_id = $request->get('product_id');
            $data['price_types'] = PriceType::all();

            $p_type = Product::withoutGlobalScope('status')->findOrFail($product_id);
            $product_type = $p_type['product_type'];

            foreach ($data['price_types'] as $price_type) {
                if ($product_type == 'ColorBase' || $product_type == 'BOTH') {
                    $data['colors'] = $p_type->colors->toArray();
                }
                if ($product_type == 'SizeBase' || $product_type == 'BOTH') {
                    $data['sizes'] = $p_type->sizes->toArray();
                }
            }
            $product_price =  $p_type->product_prices->toArray();

            $array = [];
            if (count($product_price) > 0) {
                foreach ($product_price as $price) {
                    if ($product_type == 'BOTH') {
                        $array[$price['color_id'] . "_" . $price['size_id'] . "_" . $price_type['id']] = $price['price'];
                    } elseif ($product_type == 'ColorBase') {
                        $array[$price['color_id'] . "_" . $price_type['id']] = $price['price'];
                    } elseif ($product_type == 'SizeBase') {
                        $array[$price['size_id'] . "_" . $price_type['id']] = $price['price'];
                    } else {
                        $array[$price_type['id']] = $price['price'];
                    }
                }
            }

            $data['array'] = $array;
            $data['product_id'] = $product_id;
            $data['product_type'] = $product_type;
            return view('admin.products.getPriceTab')->with($data);
        }
    }
    public function saveProductPrice(Request $request)
    {
        if ($request->ajax()) {
            $color_id = $request->get('color_id');
            $size_id = $request->get('size_id');
            $product_id = $request->get('product_id');
            $price = $request->get('value');
            $price_type_id = $request->get('price_type_id');

            $pq = ProductPrice::where('product_id', $product_id)
                ->where('size_id', $size_id)
                ->where('color_id', $color_id)
                ->where('price_type_id', $price_type_id)
                ->first();

            if ($price != 0 && $price != '') {
                if (!$pq) {
                    $pq = new ProductPrice();
                }
                $pq->product_id = $product_id;
                $pq->color_id = $color_id;
                $pq->size_id = $size_id;
                $pq->price = $price;
                $pq->price_type_id = $price_type_id;
                $pq->save();
            } else {
                if ($pq) {
                    $pq->delete();
                }
            }
            $res['status'] = 'success';
            $res['message'] = __('Record updated successfully');
            return response()->json($res);
        }
    }

    public function saveAllProductPrice(Request $request)
    {
        if ($request->ajax()) {

            $product_id = $request->get('product_id');
            $price = $request->get('value');

            $price_types = PriceType::all();

            $p_type = Product::withoutGlobalScope('status')->findOrFail($product_id);
            $product_type = $p_type['product_type'];
            foreach ($price_types as $price_type) {
                $price_type_id = $price_type['id'];
                if ($product_type != 'NoColorSize') {
                    if ($product_type == 'ColorBase' || $product_type == 'BOTH') {
                        $colors = $p_type->colors->toArray();
                    }
                    if ($product_type == 'SizeBase' || $product_type == 'BOTH') {
                        $sizes = $p_type->sizes->toArray();
                    }
                }
                if ($product_type == 'BOTH') {
                    foreach ($colors as $color) {
                        $color_id = $color['id'];
                        foreach ($sizes as $size) {
                            $size_id = $size['id'];
                            $pq = ProductPrice::where('product_id', $product_id)
                                ->where('size_id', $size_id)
                                ->where('color_id', $color_id)
                                ->where('price_type_id', $price_type_id)
                                ->first();

                            if ($price != 0 && $price != '') {
                                if (!$pq) {
                                    $pq = new ProductPrice();
                                }
                                $pq->product_id = $product_id;
                                $pq->color_id = $color_id;
                                $pq->size_id = $size_id;
                                $pq->price = $price;
                                $pq->price_type_id = $price_type_id;
                                $pq->save();
                            } else {
                                if ($pq) {
                                    $pq->delete();
                                }
                            }
                        }
                    }
                } elseif ($product_type == 'ColorBase') {
                    $size_id = 1;
                    foreach ($colors as $color) {
                        $color_id = $color['id'];
                        $pq = ProductPrice::where('product_id', $product_id)
                            ->where('size_id', $size_id)
                            ->where('color_id', $color_id)
                            ->where('price_type_id', $price_type_id)
                            ->first();

                        if ($price != 0) {
                            if (!$pq) {
                                $pq = new ProductPrice();
                            }
                            $pq->product_id = $product_id;
                            $pq->color_id = $color_id;
                            $pq->size_id = $size_id;
                            $pq->price = $price;
                            $pq->price_type_id = $price_type_id;
                            $pq->save();
                        } else {
                            if ($pq) {
                                $pq->delete();
                            }
                        }
                    }
                } elseif ($product_type == 'SizeBase') {
                    $color_id = 1;
                    foreach ($sizes as $size) {
                        $size_id = $size['id'];
                        $pq = ProductPrice::where('product_id', $product_id)
                            ->where('size_id', $size_id)
                            ->where('color_id', $color_id)
                            ->where('price_type_id', $price_type_id)
                            ->first();
                        if ($price != 0) {
                            if (!$pq) {
                                $pq = new ProductPrice();
                            }
                            $pq->product_id = $product_id;
                            $pq->color_id = $color_id;
                            $pq->size_id = $size_id;
                            $pq->price = $price;
                            $pq->price_type_id = $price_type_id;
                            $pq->save();
                        } else {
                            if ($pq) {
                                $pq->delete();
                            }
                        }
                    }
                } else {
                    $color_id = 1;
                    $size_id = 1;
                    $pq = ProductPrice::where('product_id', $product_id)
                        ->where('size_id', $size_id)
                        ->where('color_id', $color_id)
                        ->where('price_type_id', $price_type_id)
                        ->first();
                    if ($price != 0) {
                        if (!$pq) {
                            $pq = new ProductPrice();
                        }
                        $pq->product_id = $product_id;
                        $pq->color_id = $color_id;
                        $pq->size_id = $size_id;
                        $pq->price = $price;
                        $pq->price_type_id = $price_type_id;
                        $pq->save();
                    } else {
                        if ($pq) {
                            $pq->delete();
                        }
                    }
                }
            }

            $res['status'] = 'success';
            $res['message'] = __('Record updated successfully');
            return response()->json($res);
        }
    }

    public function getProductKeywordTab(Request $request)
    {
        if ($request->ajax()) {
            $product_id = $request->get('product_id');

            $keywords = ProductKeyword::where('product_id', $product_id)->get();
            $str = '';
            foreach ($keywords as $k => $key) {
                $str .= $key['search_keyword'];
                if (isset($keywords[$k + 1])) {
                    $str .= ' , ';
                }
            }
            $data['keywords'] = $str;
            $data['product_id'] = $product_id;
            return view('admin.products.getProductKeywordTab')->with($data);
        }
    }
    public function saveProductKeywords(Request $request) {
        if ($request->isXmlHttpRequest()) {
			$params = $request->all();
			$product_id = $params['product_id'];
			$product_keyword = $params['producKeyword'];
			$keywords = explode(',', $product_keyword);
			foreach ($keywords as $keyword) {
				$keyword = trim($keyword);
                $pc = ProductKeyword::where('product_id', $product_id)->where('search_keyword', $keyword)->first();
				if (!$pc) {
					$pc = new ProductKeyword();
				}
				$pc->product_id = $product_id;
				$pc->search_keyword = $keyword;
				$pc->save();
			}

			$res['status'] = 'success';
			$res['message'] = __('Record updated successfully');
            return response()->json($res);
		}
    }

    public function getDiscountTab(Request $request)
    {
    }
    public function getBannerImage(Request $request)
    {
    }
}
