@extends('layouts.admin')

@section('content')

<h3 class="page-title">{{ $label }}
	<div class="pull-right">
		<a class="btn btn-site" role="button" href="{{ route('admin.languages.create') }}"><i class="fa fa-plus"></i>{{ __('Add') }}</a>
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
						<th class="">{{ __('Name') }}</th>
						<th class="">{{ __('Lang code') }}</th>
						<th class="text-center status_td">{{ __('Is Front') }}</th>
						<th class="text-center status_td">{{ __('Status') }}</th>
						<th class="text-center">{{ __('Actions') }}</th>
					</tr>
				</thead>
				<tbody id="product_rows">
					@if(count($languages))
					@foreach ($languages as $k1 => $lang)
					<tr id="row-{{ $lang['id'] }}" class="row-move">
						<td class="text-center"><input type="checkbox" class="allcheckbox" value="{{$lang['id'] }}" /></td>
						<td>{{ $lang->name }}</td>
						<td>{{ $lang->lang_code }}</td>
						<td class="text-center">
							@php
							$icon = "fa-square-o";
							if($lang->is_front == 1) {
								$icon = "fa-check-square-o";
							}
							@endphp
							@include('admin.general.singlecheckbox', ['id' => $lang->id , 'column'=>'is_front', "value"=>$lang->is_front, 'icon_class'=>$icon, 'class'=>'green'])
						</td>
						<td class="text-center">
							@php
							$icon = "fa-square-o";
							if($lang->status == 1) {
								$icon = "fa-check-square-o";
							}
							@endphp
							@include('admin.general.singlecheckbox', ['id' => $lang->id , 'column'=>'status', "value"=>$lang->status, 'icon_class'=>$icon, 'class'=>'green'])

						</td>
						<td class="text-center action_div">
							@include('admin.general.action_btn', ['id' => $lang->id, 'route' => 'admin.languages'])
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
		'table_name' => 'languages',
		'ajax_url'=> '',
		'is_orderby'=> 'yes',
		'action' => array('change-status-1' => __('Active'), 'change-status-0' => __('Inactive'), 'delete' => __('Delete'))
		))
		<div class="clearfix"></div>
	</div>
</div>

<div class="clearfix"></div>
@endsection
