@if(count($action))
<form action="#" class="margin-top-10" method="POST">
    <div class="row">
        <div class="form-group col-xs-12 col-sm-8">
            <select name="action" id="action" class="action">
                <option value="">{{ __('Select') }}</option>
                @foreach ($action as $key => $value)
                <option value="{{ $key }}">{{$value }}</option>
                @endforeach
            </select>
            <a class="btn btn-default" href="javascript:void(0)" id="multi-action">{{ __('Apply') }} <i class="fa fa-spin fa-spinner hide"></i></a>
        </div>
    </div>
</form>
@endif
<input type="hidden" name="status_url" id="status_url" value="{{ route('admin.home.change-multiple-status') }}" />
<input type="hidden" name="delete_url" id="delete_url" value="{{ route('admin.home.delete-multiple') }}" />
<input type="hidden" name="discount_url" id="discount_url" value="{{ route('admin.home.discount-multiple') }}" />
<input type="hidden" name="discount_list_url" id="discount_list_url" value="<?php //echo url_for('home/discountList'); 
                                                                            ?>" />
<input type="hidden" name="orderby_url" id="orderby_url" value="{{ route('admin.home.change-order') }}" />
@if(isset($folder_name))
<input type="hidden" name="folder_name" id="folder_name" value="{{ $folder_name }}" />
@endif


@if(isset($table_name))
<input type="hidden" name="table_name" id="table_name" value="{{ $table_name }}" />
@endif

@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui-1.10.3.custom.min.css') }}" />
@endpush

@push('scripts')
<script type="text/javascript" src="{{ asset('plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js') }}"></script>

@if(isset($is_orderby) && $is_orderby == 'yes')
<script type="text/javascript">
    $(document).ready(function() {
        $("#product_rows").sortable({
            items: ".row-move",
            cursor: 'move',
            handle: ".handle",
            opacity: 0.5,
            update: function(event, ui) {
                jQuery.ajax({
                    type: 'POST',
                    dataType: 'html',
                    success: function(data) {},
                    data: $(this).sortable('serialize'),
                    url: $('#orderby_url').val() + '?table_name=' + $('#table_name').val()
                });
            }
        });
        $("#sortable").disableSelection();
    });
</script>
@endif
@if (!isset($include_table))
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.1/css/fixedHeader.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.0.2/css/responsive.dataTables.min.css" />

<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.1/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.0.2/js/dataTables.responsive.min.js"></script>
<script type="text/javascript">
    if ($("body").hasClass('top_panel')) {
        var height = $('.navbar').height();
    } else {
        var height = $('.nav_user').height();
    }

    var options = {
        responsive: true,
        paging: true,
        processing: true,
        autoWidth: false,
        lengthMenu: [
            [25, 50, 100, 500, -1],
            [25, 50, 100, 500, "<?php echo __('All') ?>"]
        ],
        columnDefs: [{
            "targets": 0,
            "orderable": false,
            "searchable": false
        }],
        fixedHeader: {
            headerOffset: height,
        },
        language: {
            search: "<?php echo __('Search'); ?>",
            loadingRecords: "<?php echo __('Processing'); ?>",
            processing: "<?php echo __('Processing'); ?>",
            zeroRecords: "<?php echo __('No record found'); ?>",
            emptyTable: "<?php echo __('No record found'); ?>",
            lengthMenu: "<?php echo __('Show'); ?> _MENU_",
            info: "<?php echo __('Showing'); ?> _START_ <?php echo __('To'); ?> _END_ <?php echo __('Of'); ?> _TOTAL_ <?php echo __('Entries'); ?>",
            infoPostFix: "",
            decimal: ",",
            thousands: ".",
            paginate: {
                first: "<?php echo __('First'); ?>",
                previous: "<?php echo __('Previous'); ?>",
                next: "<?php echo __('Next'); ?>",
                last: "<?php echo __('Last'); ?>"
            },
        },
    };
</script>
@if ($ajax_url == '') 
    <script type="text/javascript">
        var opt1 = $.extend({}, options, {
            pageLength: 50
        });
        var table = $('#table').DataTable(opt1);
    </script>
@endif
<script type="text/javascript">
    $(document).ready(function() {
        $('.toogle_bar').on('click', function() {
            refresh_table();
        });
    });

    function refresh_table() {
        setTimeout(function() {
            table.fixedHeader.adjust();
        }, 1000);

        setTimeout(function() {
            table.fixedHeader.adjust();
        }, 3000);

    }
</script>
@endif
@endpush