@extends('layouts.admin')

@section('content')

<h3 class="page-title">{{ __('Size') }}
	<div class="pull-right">
		<a class="btn btn-site" role="button" href="{{ route('admin.sizes.create') }}"><i class="fa fa-plus"></i>{{ __('Add') }}</a>
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
					@if(count($sizes))
					@foreach ($sizes as $k1 => $size)
					<tr id="row-{{ $size['id'] }}" class="row-move">
						<td class="text-center"><input type="checkbox" class="allcheckbox" value="{{$size['id'] }}" /></td>
						<td>{{ isset($size->translate(config('settingconfig.admin_default_language'))->name) ? $size->translate(config('settingconfig.admin_default_language'))->name : ''}}</td>
						<td>{{$size->code}}</td>
						<td class="text-center">
							@php
							$icon = "fa-square-o";
							if($size->status == 1) {
								$icon = "fa-check-square-o";
							}
							@endphp
							@include('admin.general.singlecheckbox', ['id' => $size->id , 'column'=>'status', "value"=>$size->status, 'icon_class'=>$icon, 'class'=>'green'])

						</td>
						<td class="text-center action_div">
							@include('admin.general.action_btn', ['id' => $size->id, 'route' => 'admin.sizes'])
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
		'table_name' => 'sizes',
		'ajax_url'=> '',
		'is_orderby'=> 'yes',
		'action' => array('change-status-1' => __('Active'), 'change-status-0' => __('Inactive'), 'delete' => __('Delete'))
		))
		<div class="clearfix"></div>
	</div>
</div>

<div class="clearfix"></div>
@endsection
