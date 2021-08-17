@extends('layouts.admin')

@section('content')
@php
$add_url = route('admin.cities.index',['type'=>$type,'type2'=>$type2]);
$create_url = route('admin.cities.create',['type'=>$type,'type2'=>$type2]) ;
@endphp

<h3 class="page-title"{{ __('City') }}>
	<div class="pull-right">
		<a class="btn btn-site" role="button" href="{{ $create_url }}"><i class="fa fa-plus"></i>{{ __('Add') }}</a>
	</div>
</h3>
<div class="clearfix"></div>
<div class="row">
	<div class="col-sm-12">
		<div class="table-responsive">
			<table id="table" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th class=""><input type="checkbox" id="selectall" /></th>
                        <th class="col-sm-2">{{ __('City') }}</th>
						<th class="col-sm-2">{{ __('State') }}</th>
                        <th class="col-sm-4">{{ __('Country') }}</th>                        
                        <th class="col-sm-1 text-center">{{ __('Status') }}</th>
                        <th class="col-sm-2 text-center">{{ __('Actions') }}</th>
					</tr>
				</thead>
				<tbody id="product_rows">
					@if(count($cities))

					@foreach ($cities as $k => $city)
                    					
					<tr id="row-{{ $city['id'] }}" class="row-move">
						<td class="text-center"><input type="checkbox" class="allcheckbox" value="{{$city['id'] }}" /></td>
						<td>{{$city->name}}</td>
                        <td>{{$city->allState->name}}</td>
						<td>{{$city->allCountry->name}}</td>
						<td class="text-center">
							@php
							$icon = "fa-square-o";
							if($city->status == 1) {
								$icon = "fa-check-square-o";
							}
							@endphp
							@include('admin.general.singlecheckbox', ['id' => $city->id , 'column'=>'status', "value"=>$city->status, 'icon_class'=>$icon, 'class'=>'green'])

						</td>
						<td class="text-center action_div">
						@include('admin.general.action_btn', ['id' => $city->id, 'route' => 'admin.cities','type'=>$type,'type'=>$type2,'is_not_ord'=>'yes'])
						</td>
					</tr>
					@endforeach
					@else
					<tr>
						<td colspan="6">
							{{__('No Record found') }}
						</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
		<div class="clearfix"></div>
		@include('admin.general.changeMultiAction', array(
		'table_name' => 'states',
		'ajax_url'=> '',
		'action' => array('change-status-1' => __('Active'), 'change-status-0' => __('Inactive'), 'delete' => __('Delete'))
		))
	</div>
</div>

<div class="clearfix"></div>
@endsection