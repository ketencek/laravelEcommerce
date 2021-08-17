@extends('layouts.admin')

@section('content')
@php
$add_url = route('admin.states.index',['type'=>$type]);
$create_url = route('admin.states.create',['type'=>$type]) ;
@endphp

<h3 class="page-title">{{ __('States') }}
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
						<th class="col-sm-2">{{ __('State') }}</th>
                        <th class="col-sm-4">{{ __('Country') }}</th>
                        <th class="col-sm-2">{{ __('City') }}</th>
                        <th class="col-sm-1 text-center">{{ __('Status') }}</th>
                        <th class="col-sm-2 text-center">{{ __('Actions') }}</th>
					</tr>
				</thead>
				<tbody id="product_rows">
					@if(count($states))

					@foreach ($states as $k => $state)
					
					<tr id="row-{{ $state['id'] }}" class="row-move">
						<td class="text-center"><input type="checkbox" class="allcheckbox" value="{{$state['id'] }}" /></td>
						<td>{{$state->name}}</td>
						<td>{{$state->allCountry->name}}</td>
						<td>
							<a href="{{ route('admin.cities.index',array('type'=>$type,'type2' =>$state->id)) }}" >
								<?php echo __('City') ?>
							</a>
						</td>
						<td class="text-center">
							@php
							$icon = "fa-square-o";
							if($state->status == 1) {
								$icon = "fa-check-square-o";
							}
							@endphp
							@include('admin.general.singlecheckbox', ['id' => $state->id , 'column'=>'status', "value"=>$state->status, 'icon_class'=>$icon, 'class'=>'green'])

						</td>
						<td class="text-center action_div">
						@include('admin.general.action_btn', ['id' => $state->id, 'route' => 'admin.states','type'=>$type])
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