@extends('layouts.admin')

@section('content')

<h3 class="page-title">{{ __('Color') }}
	<div class="pull-right">
		<a class="btn btn-site" role="button" href="{{ route('admin.colors.create') }}"><i class="fa fa-plus"></i>{{ __('Add') }}</a>
	</div>
</h3>
<div class="clearfix"></div>
<div class="row">
	<div class="col-sm-12">
		@if(Session::has('msg'))
		<div id="add_success" class="alert alert-success flash_notice">{{ Session::get('msg') }}</div>
		@endif
		<div class="table-responsive">
			<table id="table" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th class=""><input type="checkbox" id="selectall" /></th>
						<th class=""> {{ __('Name')  }}</th>
						<th class="">{{__('Code')}}</th>
						<th class="">{{__('Status')}}</th>
						<th class="text-center">{{ __('Actions') }}</th>
					</tr>
				</thead>
				<tbody id="product_rows">
					@if(count($colors))
					@foreach ($colors as $k1 => $color)
					<tr id="row-{{ $color['id'] }}" class="row-move">
						<td class="text-center"><input type="checkbox" class="allcheckbox" value="{{$color['id'] }}" /></td>
						<td>{{ isset($color->translate(config('settingconfig.admin_default_language'))->name) ? $color->translate(config('settingconfig.admin_default_language'))->name : ''}}</td>
						<td>{{ $color->code }}</td>
						<td class="text-center">
							@php
							$icon = "fa-square-o";
							if($color->status == 1) {
								$icon = "fa-check-square-o";
							}
							@endphp
							@include('admin.general.singlecheckbox', ['id' => $color->id , 'column'=>'status', "value"=>$color->status, 'icon_class'=>$icon, 'class'=>'green'])

						</td>
						<td class="text-center action_div">
							@include('admin.general.action_btn', ['id' => $color->id, 'route' => 'admin.colors'])
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
		'table_name' => 'colors',
		'ajax_url'=> '',
		'is_orderby'=> 'yes',
		'action' => array('change-status-1' => __('Active'), 'change-status-0' => __('Inactive'), 'delete' => __('Delete'))
		))
		<div class="clearfix"></div>
	</div>
</div>

<div class="clearfix"></div>
@endsection
