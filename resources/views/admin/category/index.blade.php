@extends('layouts.admin')

@section('content')
<h3 class="page-title">{{ __('Category')}}
    <div class="pull-right">
        <a class="btn btn-site" role="button" href="{{ route('admin.category.create') }}"><i class="fa fa-plus"></i>{{ __('Add') }}</a>
        <!-- <a class="btn btn-site" role="button" href="{{ route('admin.category.manageCategory') }}" id="add"><i class="fa fa-refresh"></i> {{  __('Change Order') }}</a> -->
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
                        <th class="">{{  __('Title')}} </th>
                        <th class="">{{  __('Main Code')}} </th>
                        <!--<th class="text-center">{{  __('View product')}} </th>-->
                        <th class="text-center status_td">{{  __('On home')}} </th>
                        <th class="text-center status_td">{{  __('Status')}} </th>
                        <th class="text-center">{{  __('Actions')}} </th>
                    </tr>
                </thead>
                <tbody id="product_rows">
                </tbody>
            </table>
        </div>
        <div class="clearfix"></div>
        @include('admin.general.changeMultiAction', array(
		'table_name' => 'categories',
		'folder_name' => 'category',
		'ajax_url'=> route('admin.category.index'),
		'is_orderby'=> '',
		'action' => array('')
		))
    </div>
</div>
<div class="clearfix"></div>
@endsection

@push('scripts')
<!-- <script>
    $(document).ready(function() {
        $(document).on("click", ".change_cat_status", function() {
            var parent = $(this);
            var ids = [];
            var idrow = this.id.split('-');
            var id = idrow[1];
            $('.cat-' + id).find('.change_cat_status').addClass('disabled');
            $('.cat-' + id).find('.change_cat_status').html('<i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                type: 'GET',
                url: $(this).attr('href'),
                dataType: 'html',
                success: function(data) {
                    window.location = '';
                },
            });
            return false;
        });
    });
</script> -->
<script type="text/javascript">
	var opt2 = $.extend({}, options, {
		destroy: true,
		pageLength: 100,
		paging: true,
		bProcessing: true,
		serverSide: true,
		ajax: {
			url: "{{ route('admin.category.index') }}", // json datasource
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
				"data": "code"
			},
            {
				"data": "on_home",
				"className": "text-center"
			},
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