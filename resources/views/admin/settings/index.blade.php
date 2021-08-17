@extends('layouts.admin')

@section('content')
@php
$add_url = route('admin.settings.index',['type'=>$type]);
$create_url = route('admin.settings.create',['type'=>$type]) ;
@endphp

<h3 class="page-title">{{ __('Settings') }}
	<div class="pull-right">
		<a class="btn btn-site" role="button" href="{{ $create_url }}"><i class="fa fa-plus"></i>Add</a>
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
						<th class=""> {{ __('Title') }}</th>
						<th class="">{{ __('Value') }}</th>
						<th class="text-center status_td">{{ __('Status')}}</th>
						<th class="text-center">{{ __('Actions') }}</th>
					</tr>
				</thead>
				<tbody id="product_rows">
					@if(count($settings))
					@foreach ($settings as $k => $setting)
					<tr id="row-{{ $setting['id'] }}" class="row-move">
						<td class="text-center"><input type="checkbox" class="allcheckbox" value="{{$setting['id'] }}" /></td>
						<td>{{$setting['name']}}</td>
						<td>{{substr($setting['value'], 0, 70)}}</td>
						<td class="text-center">
							@php
							$icon = "fa-square-o";
							if($setting->status == 1) {
								$icon = "fa-check-square-o";
							}
							@endphp
							@include('admin.general.singlecheckbox', ['id' => $setting->id , 'column'=>'status', "value"=>$setting->status, 'icon_class'=>$icon, 'class'=>'green'])

						</td>
						<td class="text-center action_div">
						@include('admin.general.action_btn', ['id' => $setting->id, 'route' => 'admin.settings','type'=>$type])
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
		'table_name' => 'settings',
		'ajax_url'=> '',
		'action' => array('change-status-1' => __('Active'), 'change-status-0' => __('Inactive'), 'delete' => __('Delete'))
		))
	</div>
</div>

<div class="clearfix"></div>
@endsection