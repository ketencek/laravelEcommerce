@extends('layouts.admin')

@section('content')
@php
$add_url = route('admin.option-values.index',['type'=>$type]);
$create_url = route('admin.option-values.create',['type'=>$type]) ;
@endphp

<h3 class="page-title">{{ __('Option Value') }}
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
						<th class="">{{ __('Code') }}</th>
						<th class="text-center status_td">{{ __('Status')}}</th>
						<th class="text-center">{{ __('Actions') }}</th>
					</tr>
				</thead>
				<tbody id="product_rows">
					@if(count($optionvalues))
					@foreach ($optionvalues as $k => $ov)
					<tr id="row-{{ $ov['id'] }}" class="row-move">
						<td class="text-center"><input type="checkbox" class="allcheckbox" value="{{$ov['id'] }}" /></td>
						<td>{{ isset($ov->translate(config('settingconfig.admin_default_language'))->name) ? $ov->translate(config('settingconfig.admin_default_language'))->name : ''}}</td>
						<td>{{ $ov->code }}</td>
						<td class="text-center">
							@php
							$icon = "fa-square-o";
							if($ov->status == 1) {
								$icon = "fa-check-square-o";
							}
							@endphp
							@include('admin.general.singlecheckbox', ['id' => $ov->id , 'column'=>'status', "value"=>$ov->status, 'icon_class'=>$icon, 'class'=>'green'])

						</td>
						<td class="text-center action_div">
						@include('admin.general.action_btn', ['id' => $ov->id, 'route' => 'admin.option-values','type'=>$type])
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
		'table_name' => 'option_values',
		'ajax_url'=> '',
		'is_orderby'=>'yes',
		'action' => array('change-status-1' => __('Active'), 'change-status-0' => __('Inactive'), 'delete' => __('Delete'))
		))
	</div>
</div>

<div class="clearfix"></div>
@endsection