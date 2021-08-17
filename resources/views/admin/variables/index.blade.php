@extends('layouts.admin')

@section('content')

<h3 class="page-title">{{ $type }}
	<div class="pull-right">
		<a class="btn btn-site" role="button" href="{{ route('admin.variables.create',['type'=>$type]) }}"><i class="fa fa-plus"></i>{{ __('Add') }}</a>
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
						<th class=""> {{ __('Title')  }}</th>
						@php
						$i=1;
						$langs = ['tr'=>'Turkish', 'en'=>'ENglish'];
						@endphp
						@foreach($langs as $k=>$l_name)
						<th class="">{{__($l_name)}}</th>
						@endforeach
						<th class="text-center">{{ __('Actions') }}</th>
					</tr>
				</thead>
				<tbody id="product_rows">
					@if(count($variables))
					@foreach ($variables as $k1 => $variable)
					<tr id="row-{{ $variable['id'] }}" class="row-move">
						<td class="text-center"><input type="checkbox" class="allcheckbox" value="{{$variable['id'] }}" /></td>
						<td>{{$variable['name']}}</td>
						@foreach($langs as $k=>$l_name)
						<td>{{ isset($variable->translate($k)->value) ? $variable->translate($k)->value : ''}}</td>
						@endforeach
						<td class="text-center action_div">
							@include('admin.general.action_btn', ['id' => $variable->id, 'route' => 'admin.variables','type'=>$type, 'is_not_order'=>'yes'])
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
		'table_name' => 'variables',
		'ajax_url'=> '',
		'action' => array('change-status-1' => __('Active'), 'change-status-0' => __('Inactive'), 'delete' => __('Delete'))
		))
		<div class="clearfix"></div>
		<div class="col-sm-12">
			<div class="well text-right">
				<a class="btn btn-site margin-bottom-0" role="button" href="{{ route('admin.variables.generateTranslationFile') }}" id="add"><i class="fa fa-plus"></i> {{ __('Generate translation file') }}</a>
				<a class="btn btn-site export_btn margin-bottom-0" href="{{ route('admin.variables.export') }}" id="add"><i class="fa fa-download"></i> {{ __('Export Variables') }}</a>
				<a class="btn btn-site upload_button margin-bottom-0"><i class="fa fa-upload"></i> {{ __('Import Variables') }} <i class="fa fa-spin fa-spinner hide"></i></a>
				<form action="{{ route('admin.variables.import') }}" method="post" id="image-form" enctype="multipart/form-data">
					@csrf
					<div id="drop" class="dropbox" style="padding:0px; border: none">
						<input type="file" name="upl" />
					</div>
					<div class="clearfix"></div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="clearfix"></div>
@endsection

@push('scripts')
<script src="{{ asset('plugins/fileuploader/js/jquery.fileupload.js') }}"></script>
<script type="text/javascript">
	$(function() {
		$('.upload_button').click(function() {
			$(this).parent().find('input').click();
		});
		$('#image-form').fileupload({
			start: function(e) {
				$('.upload_button').find('.fa-spinner').removeClass('hide');
				$('.upload_button').addClass('disabled');
			},
			done: function(e, data) {
				// console.log(data);
				// console.log(data.result);
				data1 = data.result; //JSON.parse(data.result);
				if (data1.status == 'success') {
					$.notify(data1.message, {
						type: "success",
						delay: 3000,
						placement: {
							from: "top",
							align: "right"
						},
						animate: {
							enter: 'animated fadeInRight',
							exit: 'animated fadeOutRight'
						}
					});
					window.location.reload();
				} else {
					$.notify(data1.message, {
						type: "danger",
						delay: 3000,
						placement: {
							from: "top",
							align: "right"
						},
						animate: {
							enter: 'animated fadeInRight',
							exit: 'animated fadeOutRight'
						}
					});
				}
				$('.upload_button').find('.fa-spinner').addClass('hide');
				$('.upload_button').removeClass('disabled');
			},
			fail: function(e, data) {
				$.notify('{{ __("Something went Wrong") }}', {
					type: "danger",
					delay: 3000,
					placement: {
						from: "top",
						align: "right"
					},
					animate: {
						enter: 'animated fadeInRight',
						exit: 'animated fadeOutRight'
					}
				});
				$('.upload_button').find('.fa-spinner').addClass('hide');
				$('.upload_button').removeClass('disabled');
			}
		});

	});
</script>
@endpush