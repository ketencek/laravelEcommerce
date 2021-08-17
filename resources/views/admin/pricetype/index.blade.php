@extends('layouts.admin')

@section('content')
@php
$add_url = route('admin.price-type.index');
$create_url = route('admin.price-type.create') ;
@endphp

<h3 class="page-title">{{ __('Price Type') }}
	<div class="pull-right">
		<a class="btn btn-site" role="button" href="{{ $create_url }}"><i class="fa fa-plus"></i>{{ __('Add')  }}</a>
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
						<th class="">{{ __('Description') }}</th>
						<!-- <th class="text-center status_td">{{ __('Status')}}</th> -->
						<th class="text-center">{{ __('Actions') }}</th>
					</tr>
				</thead>
				<tbody id="product_rows">
					@if(count($priceTypes))
					@foreach ($priceTypes as $k => $pt)
					<tr id="row-{{ $pt['id'] }}" class="row-move">
						<td class="text-center"><input type="checkbox" class="allcheckbox" value="{{$pt['id'] }}" /></td>
						<td>{{$pt['name']}}</td>
						<td>{{$pt['description']}}</td>
						<td class="text-center action_div">
						@include('admin.general.action_btn', ['id' => $pt->id, 'route' => 'admin.price-type','is_not_ord'=>'yes', 'not_delete'=>'yes'])
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
		'table_name' => 'pts',
		'ajax_url'=> '',
		'action' => array('change-status-1' => __('Active'), 'change-status-0' => __('Inactive'), 'delete' => __('Delete'))
		))
	</div>
</div>

<div class="clearfix"></div>
@endsection