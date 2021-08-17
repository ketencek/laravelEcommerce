@php
if(isset($type) && isset($type2)) {
$edit=route($route.'.edit', ['id' => $id, 'type'=>$type, 'type2'=>$type2]);
}else if(isset($type)) {
$edit=route($route.'.edit', ['id' => $id, 'type'=>$type]);
} else {
$edit=route($route.'.edit', ['id' => $id]);
}   
@endphp

<a class="edit" href="{{ $edit }}"><i class="fa fa-pencil"></i></a>
@if(!isset($not_delete))
<a class="delete delete_row" href="del-{{$id }}"><i class="fa fa-times"></i></a>
@endif

@if(!isset($is_not_ord))
<a class="handle" href="javascript:void(0)"><i class="fa fa-arrows"></i></a>
@endif
