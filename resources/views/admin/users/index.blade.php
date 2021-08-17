@extends('layouts.admin')

@section('content')

<h3 class="page-title">{{ __($type).' ' . __('Users')}}
	<div class="pull-right">
		<a class="btn btn-site" role="button" href="{{ route('admin.users.create',['type'=>$type]) }}"><i class="fa fa-plus"></i>Add</a>
	</div>
</h3>
<div class="clearfix"></div>
<div class="row">
	<div class="col-sm-12">
		<div class="table-responsive">
			<table id="table" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						  <th class=""><input type="checkbox"  id="selectall"  /></th>
							<th class="">{{ __('Fullname')}}</th>
							<th class="">{{ __('Mobile')}}</th>
							<th class="">{{ __('Username')}}</th>
							<th class="">{{ __('Created at')}}</th>
							<th class="text-center status_td">{{ __('Status')}}</th>
							<th class="text-center">{{ __('Actions')}}</th>
					</tr>
				</thead>
				<tbody id="product_rows">

				</tbody>
			</table>
		</div>
		<div class="clearfix"></div>
		@include('admin.general.changeMultiAction', array(
		'table_name' => 'users',
		'folder_name' => 'user',
		'ajax_url'=> route('admin.users.index',['type'=>$type]),
		'is_orderby'=> 'yes',
		'action' => array('change-status-1' => __('Active'), 'change-status-0' => __('Inactive'), 'delete' => __('Delete'))
		))
	</div>
</div>

<div class="clearfix"></div>
@endsection

@push('scripts')
<script type="text/javascript">
	var opt2 = $.extend({}, options, {
		destroy: true,
		pageLength: 100,
		paging: true,
		ordering: false,
		order: [
			[4, "asc"]
		],
		bProcessing: true,
		serverSide: true,
		ajax: {
			url: "{{ route('admin.users.index',['type'=>$type]) }}", // json datasource
			type: "GET", // type of method  , by default would be get
			error: function() { // error handling code

			}
		},
		fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
			$(nRow).addClass(aData.class);
			return nRow;
		},
		columns: [{
				"data": "checkbox",
				"className": "text-center"
			},
			{
				"data": "name"
			},
			{"data": "mobile"},
			{"data": "username"},
		{"data": "created_at"},
			{
				"data": "status",
				"className": "text-center"
			},
			{
				"data": "action",
				"className": "text-center action_div"
			}
		]
	});
	var table = $('.table').DataTable(opt2);
</script>
@endpush