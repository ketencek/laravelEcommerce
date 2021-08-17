@extends('layouts.admin')

@section('content')
    @php
    $index_url = route('admin.discounts.index', ['type' => $type]);
    @endphp
    <h3 class="page-title">{{ __($type) . ' ' . $label }}
        <div class="pull-right">
            <a class="btn btn-site" role="button" href="{{ route('admin.discounts.create', ['type' => $type]) }}"><i
                    class="fa fa-plus"></i>{{ __('Add') }}</a>
        </div>
    </h3>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-sm-12">
            @if (Session::has('msg'))
                <div id="add_success" class="alert alert-success flash_notice">{{ Session::get('msg') }}</div>
            @endif
            <div class="table-responsive">
                <table id="table" class="table table-striped table-bordered table-hover">
                    <thead>
                        <th><input type="checkbox" id="selectall" /></th>
                        @if ($type == 'global/user')
                            <th class="text-center"> {{ __('Discount code') }}</th>
                        @endif
                        <th class="text-center"> {{ __('Discount percentage') }}</th>
                        <th class="text-center"> {{ __('Start date') }}</th>
                        <th class="text-center"> {{ __('End date') }}</th>
                        <th class="text-center"> {{ __('Status') }}</th>
                        <th class="text-center"> {{ __('Actions') }}</th>

                    </thead>
                    <tbody id="product_rows">

                    </tbody>
                </table>
            </div>
            <div class="clearfix"></div>
            @include('admin.general.changeMultiAction', array(
            'table_name' => 'discounts',
            'ajax_url'=> $index_url,
            'is_orderby'=> 'yes',
            'action' => array('change-status-1' => __('Active'), 'change-status-0' => __('Inactive'), 'delete' =>
            __('Delete'))
            ))
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="clearfix"></div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var opt2 = $.extend({}, options, {
            pageLength: 50,
            paging: true,
            destroy: true,
            ordering: false,
            bProcessing: true,
            serverSide: true,
            ajax: {
                url: "{{ $index_url }}", // json datasource
                type: "get", // type of method  , by default would be get
                error: function() { // error handling code

                }
            },
            fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {

                $(nRow).addClass(aData.class);
                return nRow;
            },
            columns: [{
                    "data": "checkbox",
                    "className": "text-center",
                    orderable: false
                },
                @if ($type == 'global/user')
                    {"data": "discount_code", "className": "text-center"},
                @endif {
                    "data": "discount_percentage",
                    "className": "text-center"
                },
                {
                    "data": "formated_discount_start_date",
                    "className": "text-center"
                },
                {
                    "data": "formated_discount_end_date",
                    "className": "text-center"
                },
                {
                    "data": "status",
                    "className": "text-center"
                },
                {
                    "data": "action",
                    "className": "action_div text-center"
                }
            ]
        });
        var table = $('.table').DataTable(opt2);
    </script>
@endpush
