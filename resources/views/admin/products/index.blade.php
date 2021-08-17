@extends('layouts.admin')

@section('content')

<h3 class="page-title">{{ __("Products") }}
	<div class="pull-right">
		<a class="btn btn-site" role="button" href="{{ route('admin.products.create') }}"><i class="fa fa-plus"></i>{{ __('Add') }}</a>
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
						<th class="">{{ __('Title')}}</th>
						<th class="">{{ __('Code')}}</th>
						<!-- <th class="text-center">{{ __('Wish list')}}</th> -->
						<th class="text-center">{{ __('On home')}}</th>
						<th class="text-center">{{ __('Is new')}}</th>
						<th class="text-center">{{ __('Status')}}</th>
						<th class="text-center">{{ __('Actions')}}</th>
					</tr>
				</thead>
				<tbody id="product_rows">

				</tbody>
			</table>
		</div>
		<div class="clearfix"></div>
		@include('admin.general.changeMultiAction', array(
		'table_name' => 'products',
		'folder_name' => 'product',
		'ajax_url'=> route('admin.products.index'),
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
    pageLength: 100,
    paging: true,
    ordering: true,
    order: [
      [0, "asc"]
    ],
    bProcessing: true,
    serverSide: true,
    ajax: {
      url: "{{  route('admin.products.index') }}", // json datasource
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
        "data": "product_code"
      },
      {
        "data": "on_home",
        "className": "text-center status_td"
      },
      {
        "data": "is_new",
        "className": "text-center status_td"
      },
      {
        "data": "status",
        "className": "text-center status_td"
      },
      {
        "data": "action",
        "className": "text-center action_div"
      },
    ]
  });

  var table = $('.table').DataTable(opt2);
</script>
@endpush