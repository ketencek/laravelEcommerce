{!! Form::model($result, array('url' => $url, 'method' => $method, "enctype"=>"multipart/form-data",'class'=>'validate_form','id'=>'form_validate', 'autocomplete'=>'off')) !!}
@csrf
<ul class="nav nav-tabs pull-left">
    <li class="pull-right"><button class="btn btn-site save_btn" type="submit"><i class="fa fa-plus"></i> {{ __('Save') }}</button></li>
    <li class="active"><a data-toggle="tab" href="#general"><?php echo __('General') ?></a></li>
</ul>
<div class="clearfix"></div>
<div class="tab-content">
    <div class="col-sm-12 error_global hide">
        <div class="alert alert-danger"><?php echo __('Fill all required fields'); ?></div>
    </div>
    @if($errors->any())
    <div class="col-sm-12">
        <div class="alert alert-danger">
            {!! implode('', $errors->all('<p>:message</p>')) !!}
        </div>
    </div>
    @endif
    <div id="general" class="tab-pane fade in active">
        @php
        $module_name = config('customconfig.image.module_name');
        $thumb_folder = config('customconfig.image.thumb_folder');
        @endphp
        <div class="col-sm-3">
            <div class="form-group {{($errors->first('module_name')) ? 'has-error' :''}}">
                <label class="control-label" for="optimise_module">{{__('Module Name')}}</label> :<span class="require">*</span>
                {!! Form::select('module_name', $module_name,($result!=''? $result['module_name'] : ''), array('class' => 'form-control required valid', 'id'=>'optimise_module')) !!}
                @if($errors->has('module_name'))
                <span class="help-block m-b-none">{{ $errors->first('module_name') }}</span>
                @endif
            </div>
        </div>
        <div class="col-sm-3 ratio-div">
            <div class="form-group  {{($errors->first('crop_ratio')) ? 'has-error' :''}}">
                <label class="control-label" for="optimise_ratio">{{ __('Crop Ratio')}}</label> :<span class="require">*</span>
                {!! Form::text('crop_ratio', ($result != '' ? $result['crop_ratio'] : null) ,['class'=>'form-control','id'=>"optimise_ratio"]) !!}
                @if($errors->has('crop_ratio'))
                <span class="help-block m-b-none">{{ $errors->first('crop_ratio') }}</span>
                @endif
            </div>
        </div>
        <div class="clearfix"></div>
        @php
        $type = 'cropper';
        $checked = 'checked="checked"';
        if (isset($result['type'])) {
        $type = $result['type'];
        }
        @endphp
        <div class="col-sm-12 margin-bottom-5">
            <!-- <label class="control control--radio">
                <input class="upload_type" type="radio" name="optimise_type" id="optimise_w" {{ ($type == 'width' ? $checked : '') }} value="width" />{{ __('Fixed Width')}}
                <div class="control__indicator"></div>
            </label> -->
            <label class="control control--radio">
                <input class="upload_type" type="radio" name="optimise_type" id="optimise_c" {{ ($type == 'cropper' ? $checked : '') }} value="cropper" /> {{ __('Cropper')}}
                <div class="control__indicator"></div>
            </label>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-8">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover optimize-checkbox">
                    <thead>
                        <tr>
                            <th class="text-center">{{ __('No.') }}</th>
                            <th class="">{{ __('Thumb') }}</th>
                            <th class="">{{ __('Width') }}</th>
                            <th class="">{{ __('Height') }}</th>
                            <th class="text-center">{{ __('Optimise') }}</th>
                            <th class="text-center">{{ __('Clear') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 0 @endphp
                        @foreach ($thumb_folder as $key => $value)
                        <tr>
                            @php
                            $i++;
                            $width = '';
                            $height = '';
                            $checked = '';
                            if (isset($result['thumbs'][$value])) {
                            $width = $result['thumbs'][$value]['width'];
                            $height = $result['thumbs'][$value]['height'];
                            if ($result['thumbs'][$value]['is_optimise'] == 1) {
                            $checked = 'checked="checked"';
                            }
                            }
                            @endphp
                            <td>{{ $i}}</td>
                            <td>
                                <input type="text" class="form-control" name="thumb_folder[]" id="optimise_thumbfolder_{{$key}}" readonly="readonly" value="{{$value}}" />
                            </td>
                            <td>
                                <input type="text" class="form-control calculate_ratio val_w_{{$key}} m_width" name="width[{{$key}}]" id="optimise_width_{{$key}}" value="{{$width}}" />
                            </td>
                            <td>
                                <input type="text" readonly="readonly" class="form-control val_h_{{$key}} m_height" name="height[{{$key}}]" id="optimise_height_{{$key}}" value="{{$height}}" />
                            </td>
                            <td class="text-center">
                                <label class="control control--checkbox">
                                    <input type="checkbox" name="is_optimise[{{$key}}]" id="optimise_is_optimise_{{$key}}" {{$checked}} />
                                    <div class="control__indicator"></div>
                                </label>
                                <div class="clearfix"></div>
                            </td>
                            <td class="text-center">
                                <a class="fa fa-times delete clear-val" clr_num="{{$key}}" title="{{__('Delete')}}" href="javascript:void(0)"></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
{!! Form::close() !!}

@include('admin.general.addForm')
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('blur', '.calculate_ratio', function() {
            var cur_id = $(this).attr('id');
            var ratio = $('#optimise_ratio').val();
            var arr = cur_id.split('_');
            var count = arr[arr.length - 1];
            var height = $('.val_h_' + count).val();
            var width = $('.val_w_' + count).val();
            $('.table').addClass('loading-data');

            if( !$.isNumeric(width)&& width != '') {
                width = 0
            } else if ((width == '' || width == 0) && ratio != '') {
                width = height * ratio;
                width = Math.round(width);
            }
            // if ((height == '' || height == 0) && ratio != '') {
            if( !$.isNumeric(height) && height != '') {
                height = 0
            } else if( ratio != '') {
                height = width / ratio;
                height = Math.round(height);
            }

            if (ratio == '' || ratio == 0) {
                ratio = width / height;
                ratio = ratio.toFixed(2);
            }

            width =(width == '' ? 0 : width);
            height =(height == '' ? 0 : height);

            $('#optimise_ratio').val(ratio);
            $('.val_w_' + count).val(width);
            $('.val_h_' + count).val(height);
            $('.table').removeClass('loading-data');
        });
        $(document).on('change', '.upload_type', function() {
            var value = $(this).val();
            if (value == 'width') {
                $('.ratio-div').addClass('hidden');
            } else {
                $('.ratio-div').removeClass('hidden');
            }
        });

        $(document).on("click", ".clear-val", function() {
            var number = $(this).attr('clr_num');
            $('.val_w_' + number).val('');
            $('.val_h_' + number).val('');
            return false;
        });
    });
</script>

@endpush