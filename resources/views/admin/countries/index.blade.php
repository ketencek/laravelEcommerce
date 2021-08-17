@extends('layouts.admin')

@section('content')

<h3 class="page-title">{{ __('Country') }}
	<div class="pull-right">
		<a class="btn btn-site" role="button" href="{{ route('admin.countries.create') }}"><i class="fa fa-plus"></i>{{ __('Add') }}</a>
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
						<th class="col-sm-1 text-center"><input type="checkbox" id="selectall" /></th>
                        <th class="col-sm-5">{{ __('Name') }}</th>
                        <th class="col-sm-1">{{ __('Country Code') }}</th>
                        <th class="col-sm-3">{{ __('State') }}</th>
                        <th class="col-sm-1 text-center">{{ __('Status') }}</th>
                        <th class="col-sm-2 text-center">{{ __('Actions') }}</th>
					</tr>
				</thead>
				<tbody id="product_rows">
					@if(count($countries))
					@foreach ($countries as $k1 => $country)
					<tr id="row-{{ $country['id'] }}" class="row-move">
						<td class="text-center"><input type="checkbox" class="allcheckbox" value="{{$country['id'] }}" /></td>
						<td>{{ $country->name }}</td>
						<td>{{ $country->country_code }}</td>
						<td class="text-center">
							<a href="{{ route('admin.states.index', array('type'=>$country['id'])) }}">
								<?php echo __('State') ?>
							</a>
						</td>
						<td class="text-center">
							@php
							$icon = "fa-square-o";
							if($country->status == 1) {
								$icon = "fa-check-square-o";
							}
							@endphp
							@include('admin.general.singlecheckbox', ['id' => $country->id , 'column'=>'status', "value"=>$country->status, 'icon_class'=>$icon, 'class'=>'green'])

						</td>
						<td class="text-center action_div">
							@include('admin.general.action_btn', ['id' => $country->id, 'route' => 'admin.countries','is_not_ord'=>'yes'])
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
		'table_name' => 'countries',
		'ajax_url'=> '',
		'action' => array('change-status-1' => __('Active'), 'change-status-0' => __('Inactive'), 'delete' => __('Delete'))
		))
		<div class="clearfix"></div>
	</div>
</div>

<div class="clearfix"></div>
@endsection
