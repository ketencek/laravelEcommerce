@if($result !='')
<input type="hidden" name="orderby_url" id="orderby_url" value="{{ route('admin.home.change-order') }}" />
@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui-1.10.3.custom.min.css')}}" />
@endpush
@push('scripts')
<link rel="stylesheet" href="{{ asset('plugins/fancybox/jquery.fancybox.css')}}" />
<script src="{{ asset('plugins/fileuploader/js/jquery.ui.widget.js')}}"></script>
<script src="{{ asset('plugins/fileuploader/js/jquery.fileupload.js')}}"></script>
<script type="text/javascript" src="{{ asset('plugins/fancybox/jquery.fancybox.pack.js')}}"></script>
<script type="text/javascript" src="{{ asset('plugins/fancybox/fancy-box.js')}}"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        FancyBox.initFancybox();
    });
</script>
<script type="text/javascript" src="{{ asset('plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js')}}"></script>
@endpush
@endif

@php
$i=1;
$langs = ['tr'=>'Turkish', 'en'=>'ENglish'];
@endphp

<ul class="nav nav-tabs pull-left">
    <li class="active"><a data-toggle="tab" class="" href="#general">{{ __('General') }} </a></li>
    @if ($result != '')
    <li><a data-toggle="tab" href="#tab-data" data-url="{{ route('admin.products.getCategoryTab') }}" class="tab-click" id="category">{{ __('Category') }} </a></li>
    @if($result->product_type != 'NoColorSize')
    @if($result->product_type == 'ColorBase' || $result->product_type == 'BOTH')
    <li><a data-toggle="tab" href="#tab-data" data-url="{{ route('admin.products.getColorTab') }}" class="tab-click" id="color">{{ __('Color') }} </a></li>
    @endif
    @if($result->product_type == 'SizeBase'|| $result->product_type == 'BOTH')
    <li><a data-toggle="tab" href="#tab-data" data-url="{{ route('admin.products.getSizeTab') }}" class="tab-click" id="size">{{ __('Size') }} </a></li>
    @endif
    @endif
    <li><a data-toggle="tab" href="#tab-data" data-url="{{ route('admin.products.getImageTab') }}" class="tab-click" id="imagetab">{{ __('Images') }} </a></li>
    <li><a data-toggle="tab" href="#tab-data" data-url="{{ route('admin.products.getAttributeTab') }}" class="tab-click" id="attribute">{{ __('Attribute') }} </a></li>
    <li><a data-toggle="tab" href="#tab-data" data-url="{{ route('admin.products.getInventoryTab') }}" class="tab-click" id="inventory">{{ __('Inventory') }} </a></li>
    <li><a data-toggle="tab" href="#tab-data" data-url="{{ route('admin.products.getPriceTab') }}" class="tab-click" id="price">{{ __('Price') }} </a></li>
    <li><a data-toggle="tab" href="#tab-data" data-url="{{ route('admin.products.getProductKeywordTab') }}" class="tab-click" id="keyword">{{ __('Product Keyword') }} </a></li>
    {{-- <li><a data-toggle="tab" href="#tab-data" data-url="{{ route('admin.products.getDiscountTab') }}" class="tab-click" id="discount">{{ __('Discount') }} </a></li> --}}
    <li><a data-toggle="tab" href="#bannerimage" id="bannertab" class="">{{ __('Banner Images') }} </a></li>
    @endif
</ul>
<div class="clearfix"></div>
<div class="tab-content">
    <div id="general" class="tab-pane fade in active">
        @include('admin.products.general',array('result' => $result, 'errors' => $errors, 'url'=>$url))
    </div>
    <div id="tab-data" class="tab-pane fade"></div>
    @if($result != '')
    <div id="bannerimage" class="tab-pane fade">
         <div class="col-sm-4">
          @include('admin.general.bannerImage',
            array(
            'bannersize' =>config('imageSize.BreadcrumbBanner.big') ? config('imageSize.BreadcrumbBanner.big') : 0,// $size,
            'page_id'=>$result['id'],
            'table_name'=>'products',
            'folder_name'=>'product',
            'type'=>'BreadcrumbBanner',
            'field'=>'banner_image',
            'url'=> route('admin.add-images')
            )
            )
          <div id="banner_display" class="image_view" ></div>
		  </div>
		  <div class="clearfix"></div>
    </div>
     @endif
    <div class="col-sm-12 text-center">
        <i style="font-size:30px;" class="tab_spinner fa fa-spinner fa-spin hide"></i>
    </div>
    <div class="clearfix"></div>
</div>

@include('admin.general.addForm')

@if($result != '')
@push('scripts')

<script type="text/javascript">
    $(document).ready(function() {

        $(document).on('click', '.tab-click', function() {
            $('#tab-data').html('');
            $('.tab-content').find('.fa-spinner').removeClass('hide');
            var id = $(this).attr('id');
            var product_id = '{{ $result->id }}';
            $.ajax({
                type: 'GET',
                url: $(this).attr('data-url'),
                data: 'product_id=' + product_id,
                dataType: 'html',
                success: function(data) {
                    var content_div = $('.tab-content').find('#tab-data').attr('id');
                    $('#' + content_div).html(data);
                    if (id === 'color') {
                        typehead('{{ route("admin.products.findProductColor")}}', '{{ route("admin.products.getColorTab")}}', "#prod-color", id);
                    } else if (id === 'size') {
                        typehead('{{ route("admin.products.findProductSize")}}', '{{ route("admin.products.getSizeTab")}}', "#prod-size", id);
                    } 
                   // $('.tab-click#'+id).attr('data-reload', 1);
                    $('.tab-content').find('.fa-spinner').addClass('hide');
                }

            });
            return false;
        });
    });
</script>
@if($result->product_type != 'NoColorSize')
<script src="{{ asset('plugins/typehead/typeahead.bundle.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    function typehead(get_data_url, save_data_url, from_id, refresh_id) {
        var product_id = '{{ $result->id}}';
        var from_air = new Bloodhound({
            limit: 100,
            datumTokenizer: function(d) {
                return d.tokens;
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: get_data_url,
                filter: function(caris) {
                    return $.map(caris, function(cari) {
                        return cari;
                        // return {
                        //     name: cari.Name,
                        //     id: cari.Id
                        // };
                    });
                },
                replace: function(url, query) {
                    return url + '#' + query;
                },
                ajax: {
                    type: "GET",
                    data: {
                        query: function() {
                            return $(from_id).val();
                        }
                    },
                    beforeSend: function(msg) {
                        $(from_id).addClass('spinner');
                    },
                    success: function(msg) {
                        $(from_id).removeClass('spinner');
                    }
                }
            }
        });
        $(from_id).typeahead({
            items: 100
        }, {
            name: "Search",
            displayKey: "Name",
            source: from_air.ttAdapter(),
            hint: false,
            templates: {
                suggestion: function(el) {
                    if (el.product_image) {
                        return '<div><span style="width:30%;float:left;"><img src="' + el.product_image + '" /></span><span style="width:70%;float:left;font-size:18px">' + el.Name + '</span></div><div class="clearfix"></div>';
                    } else {
                        return el.Name
                    }
                }
            }
        });
        from_air.initialize();
        $(from_id).on('typeahead:selected', function(evt, item) {
            $('.form_tabs').addClass('loading-data');
            $.ajax({
                type: 'GET',
                url: save_data_url,
                data: 'id=' + item.Id + '&product_id=' + product_id,
                dataType: 'json',
                success: function(data) {
                    if (data.status == "success") {
                        $.notify(data.message, {
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
                        $('#' + refresh_id).trigger('click');
                    }
                    $('.form_tabs').removeClass('loading-data');
                }

            });

        });
    }
</script>
@endif
<script type="text/javascript">
    //Get Category Script
    $(document).ready(function() {
        $(document).on('click', '.saveproductcategory', function() {
            $(this).find('.fa-spinner').removeClass('hide');
            $(this).addClass('disabled');
            var parent = $(this);
            $.ajax({
                type: 'post',
                url: '{{ route("admin.products.getCategoryTab") }}',
                data: $('#categoryproduct').serialize(),
                dataType: 'json',
                success: function(data) {
                    if (data.status == "success") {
                        $.notify(data.message, {
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
                    }
                    parent.find('.fa-spinner').addClass('hide');
                    parent.removeClass('disabled');
                }

            });
            return false;
        });

        //  Product option tab Jquery

        $(document).on('click', '.saveproductoptions', function() {
            $(this).find('.fa-spinner').removeClass('hide');
            $(this).addClass('disabled');
            var parent = $(this);
            $.ajax({
                type: 'post',
                url: '{{ route("admin.products.saveProductOptions") }}',
                data: $('#productoptions').serialize(),
                dataType: 'json',
                success: function(data) {
                    if (data.status == "success") {
                        $.notify(data.message, {
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
                    }

                    parent.find('.fa-spinner').addClass('hide');
                    parent.removeClass('disabled');
                }

            });
            return false;
        });
        //  PRODUCT Inventory tab jquery

        $(document).on('change', '.change-quantity', function() {
            var id = $(this).attr('id');
            var value = $('#' + id).val();
            var product_id = $('.product_id').val();
            var new_val = id.split('_');

            var color_id, size_id;
            if (new_val[0] === 'bothquantity') {
                color_id = new_val[1];
                size_id = new_val[2];
            } else if (new_val[0] === 'colorquantity') {
                color_id = new_val[1];
                size_id = 1;
            } else if (new_val[0] === 'sizequantity') {
                size_id = new_val[1];
                color_id = 1;
            } else {
                size_id = 1;
                color_id = 1;
            }
            var parent = $(this);
            parent.parent().parent().parent().addClass('loading-data');
            $.ajax({
                type: 'GET',
                url: '{{ route("admin.products.saveProductQuantity") }}',
                data: 'color_id=' + color_id + '&size_id=' + size_id + '&product_id=' + product_id + '&value=' + value,
                dataType: 'json',
                success: function(data) {
                    if (data.status == "success") {
                        $.notify(data.message, {
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
                        $(id).val(parseFloat(value).toFixed(2));
                        parent.parent().parent().parent().removeClass('loading-data');
                    }
                }
            });
        });
        //   Price tab jquery

        $(document).on('change', '.change-price', function() {
            var id = $(this).attr('id');
            var value = $('#' + id).val();
            var product_id = '{{ $result->id}}';
            var new_val = id.split('_');

            var color_id, size_id, price_type_id;
            if (new_val[0] === 'bothquantity') {
                color_id = new_val[1];
                size_id = new_val[2];
                price_type_id = new_val[3];
            } else if (new_val[0] === 'colorquantity') {
                color_id = new_val[1];
                price_type_id = new_val[2];
                size_id = 1;
            } else if (new_val[0] === 'sizequantity') {
                size_id = new_val[1];
                price_type_id = new_val[2];
                color_id = 1;
            } else {
                size_id = 1;
                color_id = 1;
                price_type_id = new_val[1];
            }
            var parent = $(this);
            parent.parent().parent().parent().addClass('loading-data');
            $.ajax({
                type: 'post',
                url: '{{ route("admin.products.saveProductPrice") }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: 'color_id=' + color_id + '&size_id=' + size_id + '&product_id=' + product_id + '&value=' + value + '&price_type_id=' + price_type_id,
                dataType: 'json',
                success: function(data) {
                    if (data.status == "success") {
                        $.notify(data.message, {
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
                        $(id).val(parseFloat(value).toFixed(2));
                        parent.parent().parent().parent().removeClass('loading-data');
                    }

                }

            });
        });

        $(document).on('change', '.change-all-price', function() {
            var value = $(this).val();
            var id = $(this).attr('id');
            var product_id = '{{ $result->id}}';
            $('.grey_bg').addClass('loading-data');
            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                url: '{{ route("admin.products.saveAllProductPrice") }}',
                data: 'product_id=' + product_id + '&value=' + value,
                dataType: 'json',
                success: function(data) {
                    if (data.status == "success") {
                        $('.change-price').val(value);
                        $.notify(data.message, {
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
                        $(id).val(parseFloat(value).toFixed(2));
                        $('.grey_bg').removeClass('loading-data');
                    }
                }
            });

        });

        //  keyword jquery
        $(document).on('click', '.saveproductkeyword', function() {
            var parent = $(this);
            if ($('#producKeyword').val() == '') {
                $('#producKeyword').parent().addClass('has-error');
            } else {
                $(this).find('.fa-spinner').removeClass('hide');
                $(this).addClass('disabled');
                $.ajax({
                    type: 'post',
                    url: $('#productKeywordForm').attr('action'),
                    data: $('#productKeywordForm').serialize(),
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == "success") {
                            $.notify(data.message, {
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
                            $('#keyword').trigger('click');
                        }
                        parent.find('.fa-spinner').addClass('hide');
                        parent.removeClass('disabled');
                    }

                });
            }
            return false;

        });


        //  remove discount Jquery

        $(document).on('click', '.remove_dicount ', function() {
            $(this).find('.fa-spinner').removeClass('hide');
            $(this).addClass('disabled');
            var parent = $(this);
            var product_id = '{{ $result->id}}';
            $.ajax({
                type: 'GET',
                url: $(this).attr('href'),
                data: 'ids=' + product_id + '&table_name=DiscountProduct',
                dataType: 'json',
                success: function(data) {
                    $.notify(data.message, {
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
                    parent.find('.fa-spinner').addClass('hide');
                    parent.removeClass('disabled');
                    $('.add_discount').prop('checked', false);
                }
            });
            return false;
        });

        //  COLOR POPUP
        $(document).on("click", ".color_popup", function(event) {
            var parent = $(this);
            parent.find('.fa-spin').removeClass('hide');
            parent.addClass('disabled');
            var color = $(this).attr('data-color');
            var product_id = '{{ $result->id}}';
            var id = $(this).attr('data-id');
            $.ajax({
                type: 'GET',
                url: $(this).attr('data-href'),
                data: {
                    color_id: color,
                    id: id,
                    product_id: product_id
                },
                dataType: 'json',
                success: function(data) {
                    $('.my-model').html(data.html);
                    $(".modal").modal('show');
                    parent.find('.fa-spin').addClass('hide');
                    parent.removeClass('disabled');

                },
            });

        });
        $(document).on("click", ".color-pro-save", function() {
            if ($(".sel_color_id").val() > 0) {
                $(this).find('.fa-spinner').removeClass('hide');
                $(this).addClass('disabled');
                var parent = $(this);

                $.ajax({
                    type: 'GET',
                    url: "{{ route("admin.products.saveImageColor") }}",
                    data: $('#colorSaveForm').serialize(),
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 'success') {
                            $(".modal").modal('hide');
                            $('*[data-id="' + data.id + '"]').attr('data-color', $(".sel_color_id").val());
                            $('*[data-id="' + data.id + '"]').html($(".sel_color_id option:selected").text());
                            $.notify(data.message, {
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
                        }
                        parent.find('.fa-spinner').addClass('hide');
                        parent.removeClass('disabled');

                    }
                });
            } else {
                $('.sel_color_id').parent().addClass('has-error');
            }
            return false;
        });

        $(document).on('click', '.removerow', function() {
            var id = $(this).attr('id');
            var cat_id = id.split('_');
            var cat_prod_id = cat_id[1];
            var parent = $(this);
            if (confirm('Are you sure ?')) {
                $(this).html('<i class="fa fa-spin fa-spinner"></i>');
                $(this).addClass('disabled');
                $.ajax({
                    type: 'GET',
                    url: $(this).attr('href'),
                    data: 'id=' + cat_prod_id,
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == "success") {
                            $('#row-' + cat_prod_id).remove();
                        }
                        $.notify(data.message, {
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
                    }
                });
            }
            return false;
        });
    });
</script>
@endpush
@endif