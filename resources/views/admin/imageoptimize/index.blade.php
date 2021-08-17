@extends('layouts.admin')

@push('styles')
<style type="text/css">
    .grey {
        background-color: #F9F9F9 !important;
    }

    .white {
        background-color: #FFFFFF !important;
    }
</style>
@endpush

@section('content')
@php
$add_url = route('admin.image-optimizes.index');
$create_url = route('admin.image-optimizes.create') ;
@endphp

<h3 class="page-title">{{ __('Image optimize') }}
    <div class="pull-right">
        <a class="btn btn-site" role="button" href="{{ $create_url }}"><i class="fa fa-plus"></i>{{ __('Add') }}</a>
    </div>
</h3>
<div class="clearfix"></div>
<div class="row">
    <div class="col-sm-12">
        <div class="table-responsive">
            <table id="table" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="">{{ __('No')  }}</th>
                        <th class=""> {{ __('Module') }}</th>
                        <th class="text-center">{{ __('Ratio') }}</th>
                        <th class="text-center">{{ __('Thumb')}}</th>
                        <th class="text-center">{{ __('Width x Height') }}</th>
                        <th class="text-center action_div">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody id="product_rows">
                    @if(count($i_o_array))
                    @php $class = 'grey' @endphp
                    @foreach ($i_o_array as $k => $setting)
                    @foreach($setting['thumbs'] as $key => $value)
                    <tr class="row-{{$setting['module_name']}} {{ $class}}">
                        @if($key == 0)
                        <td rowspan="{{ count($setting['thumbs'])}}">
                            {{ $k + 1}}
                        </td>
                        <td rowspan="{{ count($setting['thumbs'])}}">
                            {{ $setting['module_name']}}
                        </td>
                        <td rowspan="{{ count($setting['thumbs'])}}" class="text-center">
                            {{ $setting['crop_ratio']}}
                        </td>
                        @endif
                        <td class="text-center">
                            {{ $value['thumb_folder'] }}
                        </td>
                        <td class="text-center">
                            {{ $value['width'] . 'x' . $value['height'] }}
                        </td>
                        @if($key==0)
                        <td rowspan="{{count($setting['thumbs']) }}" class="text-center action_div">
                            <a class="edit" href="{{ route('admin.image-optimizes.edit', ['id' => $setting['module_name']]) }}"><i class="fa fa-pencil"></i></a>
                            <a class="delete" title="{{ __('Delete') }}" href="{{ route('admin.image-optimizes.destroy', ['id' => $setting['module_name']]) }}"><i class="fa fa-times"></i></a>
                        </td>
                        @endif

                    </tr>
                    @endforeach
                    @php $class = (($class == 'grey') ? 'white' : 'grey') @endphp
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7">
                            {{__('No Record found') }}
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="clearfix"></div>
        @include('admin.general.changeMultiAction', array(
        'table_name' => 'image_optimizes',
        'ajax_url'=> '',
        'action' => array()
        ))
    </div>
</div>

<div class="clearfix"></div>
@endsection

@push('scripts')

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on("click", ".delete", function() {
            if (confirm('Are you sure ?')) {
                var parent = $(this);
                parent.addClass('disabled');
                parent.html('<i class="fa fa-spinner fa-spin"></i>');
                $.ajax({
                    type: 'GET',
                    url: $(this).attr('href'),
                    dataType: 'json',
                    success: function(data) {
                        $('.row-' + data.id).slideUp(300, function() {
                            $(this).remove();
                        });

                    }
                });
            }
            return false;
        });
    });
</script>
@endpush