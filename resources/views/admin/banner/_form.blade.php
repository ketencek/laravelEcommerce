
@push('scripts')
<link rel="stylesheet" href="{{ asset('plugins/fancybox/jquery.fancybox.css')}}" />
<script src="{{ asset('plugins/fileuploader/js/jquery.ui.widget.js')}}"></script>
<script src="{{ asset('plugins/fileuploader/js/jquery.fileupload.js')}}"></script>
@endpush

{!! Form::model($result, ['url' => $url, 'method' => $method, 'enctype' => 'multipart/form-data', 'class' => 'validate_form', 'id' => 'form_validate', 'autocomplete' => 'off']) !!}
<input type="hidden" value="{{ $type }}" name="redirect_extra_param">
<input type="hidden" value="{{ $type }}" name="type">
@csrf
<ul class="nav nav-tabs pull-left">
    <li class="pull-right"><button class="btn btn-site banner-save" type="submit"><i class="fa fa-plus"></i> {{ __('Save') }}</button></li>
    <li class="active"><a data-toggle="tab" href="#general">{{ __('General') }}</a></li>
</ul>
<div class="clearfix"></div>
<div class="tab-content">

    <div class="col-sm-12 error_global error-image" style="color: red"></div>
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

    <div id="general" class="tab-pane fade in active">
        <div class="col-sm-7">
            <div class="row">
                <div class="col-sm-6">
                        <div class="form-group {{($errors->first('name')) ? 'has-error' :''}}">
                            <label class="control-label" for="banner_name">{{ __('Name')}}</label> :<span class="require">*</span>
                            {!! Form::text('name', ($result != '' ? $result->name : null) ,['class'=>'form-control required','id'=>"banner_name"]) !!}
                            @if($errors->has('name'))
                            <span class="error" for="banner_name">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-3">
                    <div class="form-group  {{($errors->first('lang')) ? 'has-error' :''}}">
                        @php
                        $banner_language = ['tr'=>'tr', 'en'=>'en'];
                        @endphp
                        <label class="control-label" for="banner_lang">{{__('Lang')}}</label> :<span class="require">*</span>
                        {!! Form::select('lang', $banner_language,($result!=''? $result->lang : $type), array('class' => 'form-control required', 'id'=>'banner_lang')) !!}
                        @if($errors->has('lang'))
                        <span class="error" for="banner_lang">{{ $errors->first('lang') }}</span>
                        @endif
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="form-group {{($errors->first('image_alt')) ? 'has-error' :''}}">
                            <label class="control-label" for="banner_image_alt">{{ __('Image alt')}}</label> :
                            {!! Form::text('image_alt', ($result != '' ? $result->image_alt : null) ,['class'=>'form-control ','id'=>"banner_image_alt"]) !!}
                            @if($errors->has('image_alt'))
                            <span class="error" for="banner_image_alt">{{ $errors->first('image_alt') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-10">
                    <div class="form-group  {{($errors->first('text')) ? 'has-error' :''}}">
                        <label class="control-label" for="banner_text">{{ __('text')}}</label> :
                        {!! Form::textarea('text', ($result != '' ? $result->text : null) ,['class'=>'form-control','id'=>"banner_text", 'rows' => 4, 'cols' => 30]) !!}
                        @if($errors->has('text'))
                        <span class="error" for="banner_text">{{ $errors->first('text') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-10">
                    <div class="form-group">
                        <div class="form-group {{($errors->first('link')) ? 'has-error' :''}}">
                            <label class="control-label" for="banner_link">{{ __('Image alt')}}</label> :
                            {!! Form::text('link', ($result != '' ? $result->link : null) ,['class'=>'form-control','id'=>"banner_link"]) !!}
                            @if($errors->has('link'))
                            <span class="error" for="banner_link">{{ $errors->first('link') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="control control--checkbox">
                            {{ Form::checkbox('status', 1, $result != '' ? $result->status : true, ['id' => 'products_status']) }}
                            {{ __('Status') }}
                            <div class="control__indicator"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}

        @if ($result != '')
        <div class="col-sm-5">
            @include('admin.general.image',
            array(
            'size' => config('imageSize.Banner.big'),// $size,
            'page_id'=>$result['id'],
            'table_name'=>'banners',
            'folder_name'=>'banner',
            'type'=>$type,
            'field'=>'image',
            'url'=> route('admin.add-images')
            )
            )
            <div id="image_display" class="image_view"></div>
        </div>
        @endif
        <div class="clearfix"></div>
    </div>
</div>
<div class="clearfix"></div>
@include('admin.general.addForm')
