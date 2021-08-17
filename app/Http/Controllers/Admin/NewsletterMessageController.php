<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Models\NewsletterMessage;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Http\Requests\NewsletterMessageRequest;
use App\Models\Newsletter;
use App\Models\NewsletterImage;
use Illuminate\Support\Facades\View;

class NewsletterMessageController
{
    use HasCrudActions;

    protected $model = NewsletterMessage::class;

    protected $routePrefix = 'admin.newsletter-messages';

    protected $label = 'Message';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = NewsletterMessageRequest::class;

    protected function redirectTo($n_m)
    {
        return route("{$this->routePrefix}.edit", ['id' => $n_m->id]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //
        $this->view = 'admin.newslettermessage';
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
        $messages = NewsletterMessage::withoutGlobalScope('status')->get();

        return view($this->view . '.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['url'] = route($this->route . '.store');
        $data['title'] = __('Add') . ' ' . __($this->label);
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;

        return view('admin.general.create')->with($data);
    }



    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\NewsletterMessage  $NewsletterMessage
    //  * @return \Illuminate\Http\Response
    //  */
    public function edit($id)
    {
        $data['title'] = __('Edit') . ' ' . __($this->label);
        $data['edit'] = NewsletterMessage::withoutGlobalScope('status')->findOrFail($id);
        $data['url'] = route($this->route . '.update', ['id' => $id]);
        // $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        // dd($data);
        return view('admin.general.edit', compact('data'));
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $messages = NewsletterMessage::withoutGlobalScope('status')->findOrFail($id);
            return view('admin.newslettermessage.show', compact('messages'));
        }
    }

    public function send(Request $request,$id)
    {
        if ($request->ajax()) {
            $messages = NewsletterMessage::withoutGlobalScope('status')->findOrFail($id);
            $mail = Newsletter::where('subscribed_type', $messages->subscribed_type)->where('is_subscribed',1)->pluck('email')->toArray();
        
            $images = NewsletterImage::where('newsletter_message_id', $id)->where('image_type', 'image')->get();
            $attach = NewsletterImage::where('newsletter_message_id', $id)->where('image_type', 'attachment')->get();

            $message = $messages->body;

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
                    $param['status'] = 1;
                    unset($param['_token']);
                    $param['image'] = $name;
                    $param['image_type'] = 'image';
                    $param['newsletter_message_id'] = $param['page_id'];
                    $image = NewsletterImage::create($param);
                    $image->save();

                    $res['status'] = 'success';
                    $res['message'] = __('Record updated successfully');
                }
                return response()->json($res);
            }
        }
    }

    public function getImage(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->get('page_id');
            $images = NewsletterImage::withoutGlobalScope('status')->where('newsletter_message_id', $id)->where('image_type', 'image')->get();
            $page_id = $id;
            return view('admin.newslettermessage.getImage', compact('images', 'page_id'));
        }
    }

    public function saveLink(Request $request)
    {
        if ($request->ajax()) {
            $params = $request->all();
            $link = $request->get('link');
            $product = NewsletterImage::withoutGlobalScope('status')->find($request->get('id'));
            if ($product) {
                $product->link = $link;
                $product->save();
                $res['success'] = 1;
                $res['id'] = $request->get('id');
            } else {
                $res['success'] = 0;
            }
            return response()->json($res);
        }
    }

    public function getAttachment(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->get('page_id');
            $images = NewsletterImage::withoutGlobalScope('status')->where('newsletter_message_id', $id)->where('image_type', 'attachment')->get();
            $page_id = $id;
            return view('admin.newslettermessage.getAttachment', compact('images', 'page_id'));
        }
    }

    public function addAttachment(Request $request)
    {
        if ($request->ajax()) {
            if ($request->hasFile('photo')) {
                $ext = $request->photo->extension();
                
                if ($ext == 'pdf' || $ext == 'xls' || $ext == 'xlsx' || $ext == 'docx' || $ext == 'doc' || $ext == 'ppt' || $ext == 'pptx') {
                    $name = ImageHelper::uploadFile($request->photo, config('customconfig.path.doc.newslettermessage') . 'attachment/');

                    if ($name['error_msg'] != '') {
                        $res['status'] = 'error';
                        $res['message'] = $name['error_msg'];
                    } else {
                        $param = $request->all();
                        $param['status'] = 1;
                        unset($param['_token']);
                        $param['image'] = $name['name'];
                        $param['image_type'] = 'attachment';
                        $param['newsletter_message_id'] = $param['page_id'];
                        $image = NewsletterImage::create($param);
                        $image->save();

                        $res['status'] = 'success';
                        $res['message'] = __('Record updated successfully');
                    }
                } else {
                    $res['status'] = 'error';
                    $res['message'] = 'Extension does not match';
                }
                return response()->json($res);
            }
        }
    }
}
