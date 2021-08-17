@extends('layouts.admin')

@section('content')
    @php
    $url = route('admin.newsletters.index');
    @endphp
    <h3 class="page-title">{{ $label }}
        <div class="pull-right">
            <a class="btn btn-site" role="button" href="{{ route('admin.newsletters.create') }}" id="add">
                <i class="fa fa-plus"></i> {{ __('Add') }}
            </a>
            <a class="btn btn-site" role="button" href="{{ route('admin.newsletters.import') }}" id="import">
                <i class="fa fa-upload"></i> {{ __('Import') }}
            </a>
            <a class="btn btn-site" role="button" href="{{ route('admin.newsletters.export') }}" id="add">
                <i class="fa fa-download"></i> {{ __('Export') }}
            </a>
        </div>
    </h3>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectall" /></th>
                            <th class="">{{ __('Email') }}</th>
                            <th class="">{{ __('Subscribed type') }}</th>
                            <th class="text-center status_td">{{ __('Is subscribed') }}</th>
                            <th class="text-center status_td">{{ __('Status') }}</th>
                            <th class="text-center">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>

            <div class="clearfix"></div>
            @include('admin.general.changeMultiAction', array(
            'table_name' => 'newsletters',
            'ajax_url'=> $url,
            'action' => array(
            'change-status-1' => __('Active'),
            'change-status-0' => __('Inactive'),
            'delete' => __('Delete'))
            ))
        </div>
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content my-model">
            </div>
        </div>
    </div>
    <div class="clearfix">
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        var opt2 = $.extend({}, options, {
            pageLength: 50,
            ordering: false,
            bProcessing: true,
            serverSide: true,
            ajax: {
                url: '{{ $url }}', // json datasource
                type: "get", // type of method  , by default would be get
                error: function() { // error handling code

                }
            },
            columns: [{
                    "data": "checkbox",
                    "className": "text-center"
                },
                {
                    "data": "email"
                },
                {
                    "data": "subscribed_type"
                },
                {
                    "data": "is_subscribed",
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
