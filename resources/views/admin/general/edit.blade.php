@extends('layouts.admin')

@section('content')

    @php
    $title = $data['title'];
    //$module = $data['module'];
    $resourcePath = $data['resourcePath'];
    $url = $data['url'];
    $route = $data['route'];
    $edit = $data['edit'];
    @endphp

    @php
    if (isset($data['type']) && isset($data['type2'])) {
        $index = route($route . '.index', ['type' => $data['type'], 'type2' => $data['type2']]);
    } elseif (isset($data['type'])) {
        $index = route($route . '.index', ['type' => $data['type']]);
    } else {
        $index = route($route . '.index');
    }
    @endphp

    <h3 class="page-title">{{ $title }}
        <div class="pull-right">
            <a class="btn btn-site" role="button" href="{{ $index }}" id="add"><i class="fa fa-list"></i>
                <?php echo __('List'); ?></a>
        </div>
    </h3>
    <div class="row">
        <div class="col-sm-12 form_tabs">
            @include($resourcePath.'._form', ['method'=>'PUT','url'=>$url, 'type'=>isset($data['type']) ? $data['type'] :
            '', 'is_edit'=>1, 'result'=>$edit,'category_array'=>isset($data['categories_select']) ?
            $data['categories_select'] : [], ])
        </div>
    </div>
@endsection
