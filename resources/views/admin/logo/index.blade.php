
@extends('layouts.admin')

@section('content')
@php
$caregory_array = ['References', 'Certificate'];
@endphp
<h3 class="page-title">{{ __($type) }}</h3>

<div class="row">
    <div class="col-sm-12">
        @include('admin.logo.image',
        array(
        'size' =>(config('imageSize.Certificate.big') ? config('imageSize.Certificate.big') :0),// $size,
        'table_name'=>'client_logos',
        'folder_name'=>'logo',
        'type'=>$type,
        'field'=>'image',
        'url'=> route('admin.logos.add-logo-images')
        )
        )

        <div class="row">
            <div id="product_rows" class="grid-boxes margin-top-20 image_view">
                @if (count($logos))
                    @foreach ($logos as $key => $banner)
                        <div id="row-{{ $banner['id'] }}" class="col-sm-2 item row-move">

                            <div class="image_layer text-center">
                                <div class="action_div">
                                    <a id="on_home-{{ $banner['id'] }}" href="on_home-{{ $banner['on_home'] }}"
                                        class="on_home change_status" title="on home">
                                        <i class="fa fa-home {{ $banner['on_home'] == 1 ? 'green' : 'black' }}"></i>
                                    </a>
                                    <a id="status-{{ $banner['id'] }}" href="status-{{ $banner['status'] }}"
                                        class="green change_status">
                                        <i
                                            class="fa fa-{{ $banner['status'] == 1 ? 'check-square-o' : 'square-o' }}"></i>
                                    </a>
                                    <a href="del-{{ $banner['id'] }}" class="delete delete_row">
                                        <i class="fa fa-times"></i>
                                    </a>
                                    <a class="handle" href="javascript:void(0)"><i class="fa fa-arrows"></i></a>
                                </div>
                                <div class="image_div">
                                    <a href="{{ config('customconfig.path.url.logo') . 'medium/' . $banner['image'] }}"
                                        rel="gallery" class="fancybox" title="">
                                        <img src="{{ config('customconfig.path.url.logo') . 'small/' . $banner['image'] }}"
                                            class="img-thumbnail" alt="{{ $banner['image'] }}" />
                                    </a>
                                </div>
                                @if (in_array($type, $caregory_array))

                                    @php
                                        $place_holder = __('Link');
                                        if ($type == 'representations'):
                                            $place_holder = 'http://www.';
                                        endif;
                                    @endphp

                                    <form method="post" id="form-{{ $banner['id'] }}">
                                        @csrf
                                        <input style="padding:6px 3px; margin-top:5px;margin-bottom: 5px" type="text"
                                            name="name-tr" id="name-{{ $banner['id'] . '-tr' }}"
                                            placeholder="{{ $place_holder }}" class="form-control txt-focus required"
                                            value="{{ $banner['link'] }}" />
                                        <button class="btn btn-sm btn-site name-save btn-block" type="submit"
                                            id="record-{{ $banner['id'] }}">{{ __('Save') }} <i
                                                class="fa fa-spin fa-spinner hide"></i></button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    <div class="clearfix"></div>
                @endif
            </div>
        </div>
        <div class="clearfix"></div>

        @include('admin.general.changeMultiAction', array(
        'table_name' => 'client_logos',
        'folder_name' => 'logo',
        'ajax_url'=> '',
        'orderby_url' => 'yes',
        'action' => array()
        ))
    </div>
</div>
@endsection
@push('scripts')
    <link rel="stylesheet" href="{{ asset('plugins/fancybox/jquery.fancybox.css') }}" />
    <script src="{{ asset('plugins/fileuploader/js/jquery.ui.widget.js') }}"></script>
    <script src="{{ asset('plugins/fileuploader/js/jquery.fileupload.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/fancybox/jquery.fancybox.pack.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/fancybox/fancy-box.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            FancyBox.initFancybox();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            $(document).on("click", ".name-save", function() {
                id = this.id.split("-");
                var div_id = this.id;
                name = $('#name-' + id[1]).val();
                $('#' + div_id + ' .fa').removeClass('hide');
                parent = $(this);
                parent.find('.fa-spinner').removeClass('hide');
                parent.addClass('disabled');
                $.ajax({
                    type: 'GET',
                    data: ($('#form-' + id[1]).serialize() + '&id=' + id[1]),
                    url: "{{ route('admin.logos.addName') }}",
                    dataType: 'json',
                    success: function(data) {
                        if (data.success == 0) {
                            $.notify('{{ __('Record not found') }}', {
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
                        } else {
                            $.notify('{{ __('Save Successfully') }}', {
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

        });
    </script>

@endpush
