@extends('layouts.admin')

@section('content')

<h3 class="page-title">{{ $label }}
	<div class="pull-right">
		<a class="btn btn-site" role="button" href="{{ route('admin.order-statuses.create') }}"><i class="fa fa-plus"></i>{{ __('Add') }}</a>
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
						<th class="">{{ __('Title')  }}</th>
						<th class="text-center status_td">{{__('Status')}}</th>
						<th class="text-center">{{ __('Actions') }}</th>
					</tr>
				</thead>
				<tbody id="product_rows">
					@if(count($order_statuses))
					@foreach ($order_statuses as $k1 => $os)
					<tr id="row-{{ $os['id'] }}" class="row-move">
						<td class="text-center"><input type="checkbox" class="allcheckbox" value="{{$os['id'] }}" /></td>
						<td>{{$os->name }}</td>
						<td class="text-center">
							@php
							$icon = "fa-square-o";
							if($os->status == 1) {
								$icon = "fa-check-square-o";
							}
							@endphp
							@include('admin.general.singlecheckbox', ['id' => $os->id , 'column'=>'status', "value"=>$os->status, 'icon_class'=>$icon, 'class'=>'green'])

						</td>
						<td class="text-center action_div">
							@include('admin.general.action_btn', ['id' => $os->id, 'route' => 'admin.order-statuses', 'is_not_ord'=>'yes'])
						</td>
					</tr>
					@endforeach
					@else
					<tr>
						<td colspan="4">
							{{__('No Record found') }}
						</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
		<div class="clearfix"></div>
		@include('admin.general.changeMultiAction', array(
		'table_name' => 'order_statuses',
		'ajax_url'=> '',
		'is_orderby'=> 'yes',
		'action' => array('change-status-1' => __('Active'), 'change-status-0' => __('Inactive'), 'delete' => __('Delete'))
		))
		<div class="clearfix"></div>
	</div>
</div>

<div class="clearfix"></div>
@endsection
