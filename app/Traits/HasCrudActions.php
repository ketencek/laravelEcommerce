<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Modules\Support\Search\Searchable;
use Modules\Admin\Ui\Facades\TabManager;

trait HasCrudActions
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('query')) {
            return $this->getModel()
                ->search($request->get('query'))
                ->query()
                ->limit($request->get('limit', 10))
                ->get();
        }

        if ($request->has('table')) {
            return $this->getModel()->table($request);
        }

        return view("{$this->viewPath}.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $data = array_merge([
        //     'tabs' => TabManager::get($this->getModel()->getTable()),
        //     $this->getResourceName() => $this->getModel(),
        // ], $this->getFormData('create'));
        $data['module_route'] = $this->moduleRoute;
        $data['moduleView'] = $this->viewPath;
        return view("admin.general.create")->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //    $have_slug = $this->getModel()->where('slug', $slug)->first();
        // echo "sd";
        $this->disableSearchSyncing();

        $store_variable = $this->getRequest('store')->all();

        if (isset($store_variable['blogdate'])) {
            $store_variable['blogdate'] = \Carbon\Carbon::createFromFormat('d/m/Y', $store_variable['blogdate'])->format('Y-m-d');
        }
        if (!isset($store_variable['status'])) {
            $store_variable['status'] = false;
        }
        if (!isset($store_variable['on_home'])) {
            $store_variable['on_home'] = false;
        }
        if (!isset($store_variable['on_footer'])) {
            $store_variable['on_footer'] = false;
        }
        if (!isset($store_variable['is_front'])) {
            $store_variable['is_front'] = false;
        }
        if (!isset($store_variable['is_subscribed'])) {
            $store_variable['is_subscribed'] = false;
        }
        // if(!isset($store_variable['status'])) {
        //     $store_variable['status'] = 0;
        // }

        try {
            $entity = $this->getModel()->create(
                $store_variable
            );
        } catch (\Exception $e) {
            if (isset($store_variable['has_slug'])) {
                foreach ($store_variable as $key => $s_v) {
                    if (is_array($s_v)) {
                        // EXIT;
                        unset($store_variable[$key]['slug']);
                    }
                }
            }
            $entity = $this->getModel()->create(
                $store_variable
            );
        }

        $this->setOtherFile();

        $type = '';
        if ($this->getRoutePrefix() == "admin.users") {
            $type = $store_variable['role'];
            $entity->assignRole($type);
        }

        if (method_exists($this, 'redirectTo')) {
            return redirect($this->redirectTo($entity, $store_variable))
                ->withSuccess(trans('resource_saved', ['resource' => $this->getLabel()]));
        }

        return redirect()->route("{$this->getRoutePrefix()}.index")
            ->withSuccess(trans('resource_saved', ['resource' => $this->getLabel()]));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entity = $this->getEntity($id);

        if (request()->wantsJson()) {
            return $entity;
        }

        return view("{$this->viewPath}.show")->with($this->getResourceName(), $entity);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $data = array_merge([
        //     // 'tabs' => TabManager::get($this->getModel()->getTable()),
        //     $this->getResourceName() => $this->getEntity($id),
        // ], $this->getFormData('edit', $id));

        $data = $this->getFormData('edit', $id);
        return view("{$this->viewPath}.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {

        $entity = $this->getEntity($id);
        $entity_second = $entity;

        $this->disableSearchSyncing();

        // $entity->update(
        //     $this->getRequest('update')->all()
        // );

        $update_variable = $this->getRequest('update')->all();
        if (isset($update_variable['blogdate'])) {
            $update_variable['blogdate'] = \Carbon\Carbon::createFromFormat('d/m/Y', $update_variable['blogdate'])->format('Y-m-d');
        }
        if (!isset($update_variable['status'])) {
            $update_variable['status'] = false;
        }
        if (!isset($update_variable['on_home'])) {
            $update_variable['on_home'] = false;
        }
        if (!isset($update_variable['on_footer'])) {
            $update_variable['on_footer'] = false;
        }
        if (!isset($update_variable['is_front'])) {
            $update_variable['is_front'] = false;
        }
        if (!isset($update_variable['is_subscribed'])) {
            $update_variable['is_subscribed'] = false;
        }


        try {
            $entity->update(
                $update_variable
            );
        } catch (\Exception $e) {
            // echo "<pre>";
            // print_r($e->getMessage());
            // exit;
            if (isset($update_variable['has_slug'])) {
                foreach ($update_variable as $key => $s_v) {
                    if (is_array($s_v)) {
                        // EXIT;
                        unset($update_variable[$key]['slug']);
                    }
                }
            }
            $entity->update(
                $update_variable
            );
        }


        $this->setOtherFile();
        $this->searchable($entity);

        $entity = $entity_second;
        if (method_exists($this, 'redirectTo')) {
            return redirect($this->redirectTo($entity, $update_variable))
                ->withSuccess(trans('resource_saved', ['resource' => $this->getLabel()]));
        }

        return redirect()->route("{$this->getRoutePrefix()}.index")
            ->withSuccess(trans('resource_saved', ['resource' => $this->getLabel()]));
    }


    public function setOtherFile()
    {
        if ($this->getRoutePrefix() == 'admin.variables') {
            $this->getModel()->saveInTranslationFile();
        } else if ($this->getRoutePrefix() == 'admin.settings') {
            $this->getModel()->saveConfig();
        }
    }

    /**
     * Destroy resources by given ids.
     *
     * @param string $ids
     * @return void
     */
    public function destroy($ids)
    {
        $this->getModel()
            ->withoutGlobalScope('active')
            ->whereIn('id', explode(',', $ids))
            ->delete();
    }

    /**
     * Get an entity by the given id.
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function getEntity($id)
    {
        return $this->getModel()
            ->with($this->relations())
            ->withoutGlobalScope('status')
            ->findOrFail($id);
    }

    /**
     * Get the relations that should be eager loaded.
     *
     * @return array
     */
    private function relations()
    {
        return collect($this->with ?? [])->mapWithKeys(function ($relation) {
            return [$relation => function ($query) {
                return $query->withoutGlobalScope('active');
            }];
        })->all();
    }

    /**
     * Get form data for the given action.
     *
     * @param string $action
     * @param mixed ...$args
     * @return array
     */
    protected function getFormData($action, ...$args)
    {
        if (method_exists($this, 'formData')) {
            return $this->formData(...$args);
        }

        if ($action === 'create' && method_exists($this, 'createFormData')) {
            return $this->createFormData();
        }

        if ($action === 'edit' && method_exists($this, 'editFormData')) {
            return $this->editFormData(...$args);
        }

        return [];
    }

    /**
     * Get name of the resource.
     *
     * @return string
     */
    protected function getResourceName()
    {
        if (isset($this->resourceName)) {
            return $this->resourceName;
        }

        return lcfirst(class_basename($this->model));
    }

    /**
     * Get label of the resource.
     *
     * @return void
     */
    protected function getLabel()
    {
        return trans($this->label);
    }

    /**
     * Get route prefix of the resource.
     *
     * @return string
     */
    protected function getRoutePrefix()
    {
        if (isset($this->routePrefix)) {
            return $this->routePrefix;
        }

        return "admin.{$this->getModel()->getTable()}";
    }

    /**
     * Get a new instance of the model.
     *
     * @return \Modules\Support\Eloquent\Model
     */
    protected function getModel()
    {
        return new $this->model;
    }

    /**
     * Get request object
     *
     * @param string $action
     * @return \Illuminate\Http\Request
     */
    protected function getRequest($action)
    {
        // echo "<pre>";
        // print_r($action);
        // exit;
        if (!isset($this->validation)) {
            return request();
        }

        if (isset($this->validation[$action])) {
            return resolve($this->validation[$action]);
        }

        return resolve($this->validation);
    }

    /**
     * Disable search syncing for the entity.
     *
     * @return void
     */
    protected function disableSearchSyncing()
    {
        if ($this->isSearchable()) {
            $this->getModel()->disableSearchSyncing();
        }
    }

    /**
     * Determine if the entity is searchable.
     *
     * @return bool
     */
    protected function isSearchable()
    {
        return in_array(Searchable::class, class_uses_recursive($this->getModel()));
    }

    /**
     * Make the given model instance searchable.
     *
     * @return void
     */
    protected function searchable($entity)
    {
        if ($this->isSearchable($entity)) {
            $entity->searchable();
        }
    }
}
