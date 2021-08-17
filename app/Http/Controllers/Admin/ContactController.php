<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\View;

class ContactController
{
    use HasCrudActions;

    protected $model = Contact::class;
    
    protected $routePrefix = 'admin.contacts';

    protected $label = 'Contact';

     /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = ContactRequest::class;

    protected function redirectTo($contact)
    {
        return route('admin.contacts.edit',['id'=>$contact->id]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //
        $this->view = 'admin.contacts';
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
        $contacts = Contact::withoutGlobalScope('status')->get();
        return view($this->view . '.index', compact('contacts'));
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
        // $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;

        return view('admin.general.create')->with($data);
    }

   

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\Contact  $contact
    //  * @return \Illuminate\Http\Response
    //  */
    public function edit($id)
    {
        $data['title'] = __('Edit').' '. __($this->label);
        $data['edit'] = Contact::withoutGlobalScope('status')->findOrFail($id);
        $data['url'] = route($this->route . '.update', ['id' => $id]);
        // $data['module'] = $this->viewName;
        $data['resourcePath'] = $this->view;
        $data['route'] = $this->route;
        // dd($data);
		return view('admin.general.edit', compact('data'));
    }

}
