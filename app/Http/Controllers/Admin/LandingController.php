<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use DB;
use App\Models\Setting;
use App\Helpers\ImageHelper;

class LandingController extends Controller
{
	public function __construct()
	{
		$this->moduleName = "admin/dashboard.title"; // name given in lang file
		$this->moduleRoute = url('admin/');
		$this->moduleView = "admin.landing";

		View::share('module_name', $this->moduleName);
		View::share('module_route', $this->moduleRoute);
		View::share('moduleView', $this->moduleView);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		// echo "Ad";
		// exit;
		return view($this->moduleView . ".index");
	}

	public function ckeditor($folder, Request $request)
	{
		exit;
		$funcNum = $request->getParameter('CKEditorFuncNum');

		$file = $_FILES['upload']['name'];

		if ($file) {
			$filename = stripslashes($_FILES['upload']['name']);
			$i = strrpos($filename, '.');
			if (!$i) {
				return '';
			}
			$l = strlen($filename) - $i;
			$ext = substr($filename, $i + 1, $l);
			$extension = $ext;
			$extension = strtolower($extension);

			if ($extension != 'jpg' && $extension != 'jpeg' && $extension != 'gif' && $extension != 'png' && $extension != 'pdf') {
				$errors = 1;
				$error_msg = lang_upload_error_extension;
			}

			$size = filesize($_FILES['upload']['tmp_name']);
			if ($size > 1024 * 1024) {
				$errors = 1;
				$error_msg = lang_upload_error_filesize;
			}

			if ($errors == 0) {
				$file_name = time() . '.' . $extension;
				$new_name = 'uploads/' . $request->getParameter('folder') . '/' . $file_name;

				if (!move_uploaded_file($_FILES['upload']['tmp_name'], $new_name)) {
					$errors = 1;
					$error_msg = lang_upload_error;
				} else {
					$url = '/uploads/' . $request->getParameter('folder') . '/' . $file_name;
					$message = '';
					echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
				}
			} else {
				echo ($error_msg);
			}
		}
		// return sfView::NONE;
	}

	public function changeMultipleStatus(Request $request)
	{
		$table_name = $request->get('table_name');
		$param = $request->get('param');
		$id_array = explode(',', $request->get('id'));
		try {
			if ($param == 0) {
				foreach ($id_array as $id) {
					// dd($id);
					DB::table($table_name)->where('id', $id)
						->update([
							'status' => 0,
						]);
				}
			} elseif ($param == 1) {
				foreach ($id_array as $id) {
					// dd($id);
					DB::table($table_name)->where('id', $id)
						->update([
							'status' => 1,
						]);
				}
			}

			if ($table_name == 'settings') {
				Setting::saveConfig();
				// $all_setting = Settings::where('status', 1)->pluck('value','name')->toArray();
				// file_put_contents(base_path() .'/config/fashionb2b.php',  '<?php return ' . var_export($all_setting, true) . ';');
			}

			$res['status'] = 'Success';
			$res['message'] = 'Status Change successfully';
		} catch (\Exception $ex) {
			$res['status'] = 'Error';
			$res['message'] = 'Something went wrong.';
		}
		return response()->json($res);
	}

	public function deleteMultiple(Request $request)
	{
		$table_name = $request->get('table_name');
		$id_array = explode(',', $request->get('id'));
		// dd($id_array);
		// return;
		try {
			if ($request->has('folder_name')) {
				$folder_name = $request->get('folder_name');
				foreach ($id_array as $id) {
					$records = DB::table($table_name)->where('id', $id)->first();
					if (isset($records->image) && $records->image) {
						try {
							ImageHelper::deleteModuleMultipleImage($records->image, config('customconfig.path.doc.' . $folder_name));
						} catch (\Exception $ex) {
						}
					}
					if (isset($records->banner_image) && $records->banner_image) {
						try {
							ImageHelper::deleteModuleMultipleImage($records->banner_image, config('customconfig.path.doc.' . $folder_name));
						} catch (\Exception $ex) {
						}
					}
					DB::table($table_name)->where('id', $id)->delete();
				}
			} else {
				DB::table($table_name)->whereIn('id', $id_array)->delete();
			}
			if ($table_name == 'settings') {
				Setting::saveConfig();
			}

			// if($table_name == 'settings') {
			// 	DB::table($table_name)->whereIn('id', $id_array)->delete();
			// 	$all_setting = Settings::where('status', 1)->pluck('value','name')->toArray();
			// 	file_put_contents(base_path() .'/config/fashionb2b.php',  '<?php return ' . var_export($all_setting, true) . ';');
			// }
			$res['status'] = 'Success';
			$res['message'] = 'Deleted successfully';
		} catch (\Exception $ex) {

			$res['status'] = 'Error';
			$res['message'] = $ex->getMessage(); //'Kindly delete child element.';
		}
		return response()->json($res);
	}

	public function discountMultiple(Request $request)
	{
		$id_array = explode(',', $request->get('id'));
		dd($id_array);
	}

	public function changeOrder(Request $request)
	{
		if ($request->ajax()) {
			$table_name = $request->get('table_name');
			$ids = $request->get('row');
			foreach ($ids as $key => $value) {
				DB::table($table_name)->where('id', $value)
					->update([
						'ord' => ($key),
					]);
			}
		}
		$res['status'] = 'Success';
		$res['message'] = 'Order Change successfully';
		return response()->json($res);
	}

	public function getImage(Request $request)
	{
		if ($request->ajax()) {
			$table_name = $request->get('table_name');
			$folder_name = $request->get('folder_name');
			$field = $request->get('field');
			$page_id = $request->get('page_id');
			$records =  DB::table($table_name)->find($page_id);

			$data['table_name'] = $table_name;
			$data['folder_name'] = $folder_name;
			$data['field'] = $field;
			$data['images'] = $records;
			return view('admin.general.getImage')->with($data);
		}
	}

	public function addImage(Request $request)
	{
		if ($request->ajax()) {
			if ($request->hasFile('image')) {

				$records = DB::table($request->get('table_name'))->find($request->get('page_id'));
				$field = $request->get('field');
				$image_name = $records->$field;

				$name = ImageHelper::saveUploadedImage(request()->image, $request->get('type'), config('customconfig.path.doc.' . $request->get('folder_name')), $image_name);
				// echo "<pre>";
				// print_r($name);
				// exit;
				DB::table($request->get('table_name'))->where('id', $request->get('page_id'))
					->update([
						$field => $name,
					]);

				if (!$name) {
					$res['status'] = 'error';
					$res['message'] = 'Something went Wrong.';
				} else {
					$res['status'] = 'success';
					$res['message'] = 'Saved successfuly';
				}
				return response()->json($res);
			}
		}
	}

	public function imageDelete(Request $request, $table_name, $folder_name, $field, $id)
	{
		$offer_image = DB::table($table_name)->find($id);

		if ($field == 'image') {
			$oldimagesrc = $offer_image->image;
		} elseif ($field == 'banner_image') {
			$oldimagesrc = $offer_image->banner_image;
		}

		if ($oldimagesrc) {
			ImageHelper::deleteModuleMultipleImage($oldimagesrc, config('customconfig.path.doc.' . $folder_name));
		}

		DB::table($table_name)->where('id', $id)
			->update([
				$field => '',
			]);
		$res['status'] = 'success';
		return response()->json($res);
	}
}
