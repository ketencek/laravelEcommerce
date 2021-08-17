@if ($result != '')
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
    @endpush
@endif

{!! Form::model($result, ['url' => $url, 'method' => $method, 'enctype' => 'multipart/form-data', 'class' => 'validate_form', 'id' => 'form_validate', 'autocomplete' => 'off']) !!}

<!-- <form class="validate_form" action="{{ $url }}" method="post" enctype="multipart/form-data"> -->
@csrf
<input type="hidden" value="yes" name="has_slug">
<input type="hidden" value="{{ $type }}" name="cat_type">
@php
$i = 1;
$langs = ['tr' => 'Turkish', 'en' => 'ENglish'];
@endphp
<ul class="nav nav-tabs pull-left">
    <li class="pull-right"><button class="btn btn-site save_btn" type="submit"><i class="fa fa-plus"></i>
            {{ __('Save') }}</button></li>
    @php
    @endphp
    <?php
    $i = 1;
    foreach ($langs as $k => $lang) :
    ?>
    <li class="{{ $i == 1 ? 'active' : '' }}"><a data-toggle="tab"
            href="#{{ $k }}">{{ $lang }}</a></li>
    <?php
        $i++;
    endforeach;
    ?>
    <li><a data-toggle="tab" class="" href="#general"><?php echo __('General'); ?></a></li>
    <?php if ($result != '') : ?>
    <li><a data-toggle="tab" href="#bannerimage" class="clickbannerimagetab"><?php echo __('Banner Images'); ?></a></li>
    <?php endif; ?>
</ul>
<div class="clearfix"></div>
<div class="tab-content">
    <div class="col-sm-12 error_global hide">
        <div class="alert alert-danger">{{ __('Fill all required fields') }}</div>
    </div>
    @if ($errors->any())
        <div class="col-sm-12">
            <div class="alert alert-danger">
                {!! implode('', $errors->all('<p>:message</p>')) !!}
            </div>
        </div>
    @endif

    @php
        $i = 1;
    @endphp
    @foreach ($langs as $lable => $lang)

        <div id="{{ $lable }}" class="tab-pane fade in {{ $i == 1 ? 'active' : '' }}">
            <div class="col-sm-8">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->first($lable . '.name') ? 'has-error' : '' }}">
                            <label for="contact_{{ $lable }}_name">{{ __('Name') }}</label> :<span
                                class="require">*</span>
                            {!! Form::text($lable . '[name]', $result != '' ? $result->translate($lable)->name : null, ['class' => 'form-control required contact_name', 'id' => 'contact_' . $lable . '_name']) !!}
                            @if ($errors->has($lable . '.name'))
                                <span class="help-block m-b-none">{{ $errors->first($lable . '.name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-sm-6">
                        <div
                            class="form-group {{ $errors->first($lable . '.short_description') ? 'has-error' : '' }}">
                            <label
                                for="contact_{{ $lable }}_short_description">{{ __('Short description') }}</label>
                            :
                            {!! Form::textarea($lable . '[short_description]', $result != '' ? $result->translate($lable)->short_description : null, ['class' => 'form-control', 'rows' => 4, 'cols' => 30, 'id' => 'contact_' . $lable . '_short_description']) !!}
                            @if ($errors->has($lable . '.short_description'))
                                <span
                                    class="help-block m-b-none">{{ $errors->first($lable . '.short_description') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 border-left">
                @include('admin.general.titleAndSlug', array('lable' => $lable, 'class_name' => 'contact_name',
                'model_name'=>'contact_', 'result'=>$result))
            </div>
            <div class="clearfix"></div>
        </div>
        @php
            $i++;
        @endphp
    @endforeach
    <div id="general" class="tab-pane fade">

        <div class="col-sm-4">
            <div class="form-group {{ $errors->first('address') ? 'has-error' : '' }}">
                <label class="control-label" for="contact_address">{{ __('Address') }}</label> :<span
                    class="require">*</span>
                {!! Form::textarea('address', $result != '' ? $result->address : null, ['class' => 'form-control required', 'id' => 'contact_address', 'rows' => 4, 'cols' => 30]) !!}
                @if ($errors->has('address'))
                    <span class="error" for="contact_address">{{ $errors->first('address') }}</span>
                @endif
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group {{ $errors->first('city') ? 'has-error' : '' }}">
                <label class="control-label" for="contact_city">{{ __('City') }}</label> :<span
                    class="require">*</span>
                {!! Form::text('city', $result != '' ? $result->city : null, ['class' => 'form-control required', 'id' => 'contact_city']) !!}
                @if ($errors->has('city'))
                    <span class="error" for="contact_city">{{ $errors->first('city') }}</span>
                @endif
            </div>
            <div class="form-group {{ $errors->first('email') ? 'has-error' : '' }}">
                <label class="control-label" for="contact_email">{{ __('Email') }}</label> :
                {!! Form::text('email', $result != '' ? $result->email : null, ['class' => 'form-control email', 'id' => 'contact_email']) !!}
                @if ($errors->has('email'))
                    <span class="error" for="contact_email">{{ $errors->first('email') }}</span>
                @endif
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="col-sm-3">
            <div class="form-group {{ $errors->first('phone') ? 'has-error' : '' }}">
                <label class="control-label" for="contact_phone">{{ __('Phone') }}</label> :
                {!! Form::text('phone', $result != '' ? $result->phone : null, ['class' => 'form-control phone', 'id' => 'contact_phone']) !!}
                @if ($errors->has('phone'))
                    <span class="error" for="contact_phone">{{ $errors->first('phone') }}</span>
                @endif
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group {{ $errors->first('mobile') ? 'has-error' : '' }}">
                <label class="control-label" for="contact_mobile">{{ __('Mobile') }}</label> :
                {!! Form::text('mobile', $result != '' ? $result->mobile : null, ['class' => 'form-control phone', 'id' => 'contact_mobile']) !!}
                @if ($errors->has('mobile'))
                    <span class="error" for="contact_mobile">{{ $errors->first('mobile') }}</span>
                @endif
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group {{ $errors->first('faxs') ? 'has-error' : '' }}">
                <label class="control-label" for="contact_faxs">{{ __('faxs') }}</label> :
                {!! Form::text('faxs', $result != '' ? $result->faxs : null, ['class' => 'form-control phone', 'id' => 'contact_faxs']) !!}
                @if ($errors->has('faxs'))
                    <span class="error" for="contact_faxs">{{ $errors->first('faxs') }}</span>
                @endif
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="col-sm-3">
            <div class="form-group {{ $errors->first('latitude') ? 'has-error' : '' }}">
                <label class="control-label" for="contact_latitude">{{ __('Latitude') }}</label> :
                {!! Form::text('latitude', $result != '' ? $result->latitude : null, ['class' => 'form-control', 'id' => 'contact_latitude']) !!}
                @if ($errors->has('latitude'))
                    <span class="error" for="contact_latitude">{{ $errors->first('latitude') }}</span>
                @endif
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group {{ $errors->first('longitude') ? 'has-error' : '' }}">
                <label class="control-label" for="contact_longitude">{{ __('Longitude') }}</label> :
                {!! Form::text('longitude', $result != '' ? $result->longitude : null, ['class' => 'form-control', 'id' => 'contact_longitude']) !!}
                @if ($errors->has('longitude'))
                    <span class="error" for="contact_longitude">{{ $errors->first('longitude') }}</span>
                @endif
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group {{ $errors->first('link') ? 'has-error' : '' }}">
                <label class="control-label" for="contact_link">{{ __('Link') }}</label> :
                {!! Form::textarea('link', $result != '' ? $result->link : null, ['class' => 'form-control', 'id' => 'contact_link', 'rows' => 4, 'cols' => 30]) !!}
                @if ($errors->has('link'))
                    <span class="error" for="contact_link">{{ $errors->first('link') }}</span>
                @endif
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-2">
            <div class="form-group">
                <label class="control control--checkbox">
                    {{ Form::checkbox('status', 1, $result != '' ? $result->status : true, ['id' => 'contact_status']) }}
                    {{ __('Status') }}
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label class="control control--checkbox">
                    {{ Form::checkbox('on_footer', 1, $result != '' ? $result->on_footer : false, ['id' => 'contact_on_footer']) }}
                    {{ __('On footer') }}
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>
        {!! Form::close() !!}
        <div class="clearfix"></div>
        @if ($result != '')
            <div class="col-sm-4">
                @include('admin.general.image',
                array(
                'size' =>(config('imageSize.Contact.big') ? config('imageSize.Contact.big') : 0),// $size,
                'page_id'=>$result['id'],
                'table_name'=>'contacts',
                'folder_name'=>'contact',
                'type'=>'Contact',
                'field'=>'image',
                'url'=> route('admin.add-images')
                )
                )
                <div id="image_display" class="image_view"></div>
            </div>
            <div class="clearfix"></div>
        @endif
    </div>
    @if ($result != '')
        <div id="bannerimage" class="tab-pane fade">
            <div class="col-sm-4">
                @include('admin.general.bannerImage',
                array(
                'bannersize' =>config('imageSize.BreadcrumbBanner.big'),// $size,
                'page_id'=>$result['id'],
                'table_name'=>'contacts',
                'folder_name'=>'contact',
                'type'=>'BreadcrumbBanner',
                'field'=>'banner_image',
                'url'=> route('admin.add-images')
                )
                )
                <div id="banner_display" class="image_view"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    @endif
</div>

@include('admin.general.addForm')
