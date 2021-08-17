@extends('layouts.admin')

@section('content')

<h3 class="page-title">{{ $label }}
	<div class="pull-right">
		<a class="btn btn-site" role="button" href="{{ route('admin.redirections.create') }}"><i class="fa fa-plus"></i>{{ __('Add') }}</a>
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
						<th class=""> {{ __('Old Url')  }}</th>
						<th class="">{{__('New Url')}}</th>
						<th class="">{{__('Status')}}</th>
						<th class="text-center">{{ __('Actions') }}</th>
					</tr>
				</thead>
				<tbody id="product_rows">
					@if(count($redirections))
					@foreach ($redirections as $k1 => $redirection)
					<tr id="row-{{ $redirection['id'] }}" class="row-move">
						<td class="text-center"><input type="checkbox" class="allcheckbox" value="{{$redirection['id'] }}" /></td>
						<td>{{$redirection->old_url }}</td>
						<td>{{ $redirection->new_url }}</td>
						<td class="text-center">
							@php
							$icon = "fa-square-o";
							if($redirection->status == 1) {
								$icon = "fa-check-square-o";
							}
							@endphp
							@include('admin.general.singlecheckbox', ['id' => $redirection->id , 'column'=>'status', "value"=>$redirection->status, 'icon_class'=>$icon, 'class'=>'green'])

						</td>
						<td class="text-center action_div">
							@include('admin.general.action_btn', ['id' => $redirection->id, 'route' => 'admin.redirections', 'is_not_ord'=>'yes'])
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
		'table_name' => 'redirections',
		'ajax_url'=> '',
		'is_orderby'=> 'yes',
		'action' => array('change-status-1' => __('Active'), 'change-status-0' => __('Inactive'), 'delete' => __('Delete'))
		))
		<div class="clearfix"></div>
	</div>
</div>

<div class="clearfix"></div>
@endsection
