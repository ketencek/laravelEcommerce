@extends('layouts.admin')

@section('content')

<h3 class="page-title">{{ $label }}
	<div class="pull-right">
		<a class="btn btn-site" role="button" href="{{ route('admin.contacts.create') }}"><i class="fa fa-plus"></i>{{ __('Add') }}</a>
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
						<th class="">{{ __('Title') }}</th>
						<th class="">{{ __('Email') }}</th>
						<th class="">{{ __('Address') }}</th>
						<th class="text-center status_td">{{ __('On footer') }}</th>
						<th class="text-center status_td">{{ __('Status') }}</th>
						<th class="text-center">{{ __('Actions') }}</th>
					</tr>
				</thead>
				<tbody id="product_rows">
					@if(count($contacts))
					@foreach ($contacts as $k1 => $contact)
					<tr id="row-{{ $contact['id'] }}" class="row-move">
						<td class="text-center"><input type="checkbox" class="allcheckbox" value="{{$contact['id'] }}" /></td>
						<td>{{ $contact->name }}</td>
						<td>{{ $contact->email }}</td>
						<td>{{ $contact->address }}</td>
						<td class="text-center">
							@php
							$icon = "fa-square-o";
							if($contact->on_footer == 1) {
								$icon = "fa-check-square-o";
							}
							@endphp
							@include('admin.general.singlecheckbox', ['id' => $contact->id , 'column'=>'on_footer', "value"=>$contact->on_footer, 'icon_class'=>$icon, 'class'=>'green'])
						</td>
						<td class="text-center">
							@php
							$icon = "fa-square-o";
							if($contact->status == 1) {
								$icon = "fa-check-square-o";
							}
							@endphp
							@include('admin.general.singlecheckbox', ['id' => $contact->id , 'column'=>'status', "value"=>$contact->status, 'icon_class'=>$icon, 'class'=>'green'])

						</td>
						<td class="text-center action_div">
							@include('admin.general.action_btn', ['id' => $contact->id, 'route' => 'admin.contacts'])
						</td>
					</tr>
					@endforeach
					@else
					<tr>
						<td colspan="7">
							{{__('No Record found') }}
						</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
		<div class="clearfix"></div>
		@include('admin.general.changeMultiAction', array(
		'table_name' => 'contacts',
		'folder_name' => 'contact',
		'ajax_url'=> '',
		'is_orderby'=> 'yes',
		'action' => array('change-status-1' => __('Active'), 'change-status-0' => __('Inactive'), 'delete' => __('Delete'))
		))
		<div class="clearfix"></div>
	</div>
</div>

<div class="clearfix"></div>
@endsection
