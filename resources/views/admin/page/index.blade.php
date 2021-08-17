@extends('layouts.admin')

@section('content')

<h3 class="page-title">{{ $type }}
	<div class="pull-right">
		<a class="btn btn-site" role="button" href="{{ route('admin.static-page.create',['type'=>$type]) }}"><i class="fa fa-plus"></i>Add</a>
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
						<th class="">Title</th>
						<th class="text-center status_td">Status</th>
						<th class="text-center status_td">On Home</th>
						<th class="text-center">Actions</th>
					</tr>
				</thead>
				<tbody id="product_rows">

				</tbody>
			</table>
		</div>
		<div class="clearfix"></div>
		@include('admin.general.changeMultiAction', array(
		'table_name' => 'pages',
		'folder_name' => 'page',
		'ajax_url'=> route('admin.static-page.index',['type'=>$type]),
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
			url: "{{ route('admin.static-page.index',['type'=>$type]) }}", // json datasource
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
			{
				"data": "status",
				"className": "text-center"
			},
			{
				"data": "on_home",
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