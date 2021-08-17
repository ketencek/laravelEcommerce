@extends('layouts.admin')

@section('content')

@php
if(isset($type) && isset($type2)){
$index= route($route.'.index',array('type'=>$type,'type2'=>$type2));
$store=route($route.'.store',array('type'=>$type,'type2'=>$type2));
}elseif(isset($type) ){
$index= route($route.'.index',array('type'=>$type));
$store=route($route.'.store',array('type'=>$type));
}else {
$index= route($route.'.index');
$store=route($route.'.store');
}
@endphp
<h3 class="page-title">{{ $title }}
    <div class="pull-right">
        <a class="btn btn-site" role="button" href="{{ $index }}" id="add"><i class="fa fa-list"></i> <?php echo __('List') ?></a>
    </div>
</h3>
<div class="row">
    <div class="col-sm-12 form_tabs">
        @include($resourcePath.'._form',
        [
        'method'=>'POST',
        'url'=>$store,
        'type'=>isset($type) ? $type : '',
        'result'=>'',
        'category_array'=>isset($categories_select) ? $categories_select : [], 
        ])
    </div>
</div>
@endsection
