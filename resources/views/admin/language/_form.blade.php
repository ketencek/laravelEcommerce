{!! Form::model($result, ['url' => $url, 'method' => $method, 'enctype' => 'multipart/form-data', 'class' => 'validate_form', 'id' => 'form_validate', 'autocomplete' => 'off']) !!}

<!-- <form class="validate_form" action="{{ $url }}" method="post" enctype="multipart/form-data"> -->
@csrf


<ul class="nav nav-tabs pull-left">
    <li class="pull-right"><button class="btn btn-site" type="submit"><i class="fa fa-plus"></i>
            {{ __('Save') }}</button></li>
    <li class="active"><a data-toggle="tab" href="#general">{{ __('General') }}</a></li>
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

    <div id="general" class="tab-pane fade in active">
        <div class="col-sm-4">
            <div class="form-group {{ $errors->first('name') ? 'has-error' : '' }}">
                <label class="control-label" for="language_name">{{ __('Name') }}</label> :<span
                    class="require">*</span>
                {!! Form::text('name', $result != '' ? $result->name : null, ['class' => 'form-control phone', 'id' => 'language_name']) !!}
                @if ($errors->has('name'))
                    <span class="error" for="language_name">{{ $errors->first('name') }}</span>
                @endif
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-4">
            <div class="form-group {{ $errors->first('lang_code') ? 'has-error' : '' }}">
                <label class="control-label" for="language_lang_code">{{ __('Lang code') }}</label> :<span
                    class="require">*</span>
                {!! Form::text('lang_code', $result != '' ? $result->lang_code : null, ['class' => 'form-control phone', 'id' => 'language_lang_code']) !!}
                @if ($errors->has('lang_code'))
                    <span class="error" for="language_lang_code">{{ $errors->first('lang_code') }}</span>
                @endif
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-2">
            <div class="form-group">
                <label class="control control--checkbox">
                    {{ Form::checkbox('status', 1, $result != '' ? $result->status : true, ['id' => 'language_status']) }}
                    {{ __('Status') }}
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label class="control control--checkbox">
                    {{ Form::checkbox('is_front', 1, $result != '' ? $result->is_front : true, ['id' => 'language_is_front']) }}
                    {{ __('Is Front') }}
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
{!! Form::close() !!}
@include('admin.general.addForm')
