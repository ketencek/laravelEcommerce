{!! Form::model($result, ['url' => $url, 'method' => $method, 'enctype' => 'multipart/form-data', 'class' => 'validate_form', 'id' => 'form_validate', 'autocomplete' => 'off']) !!}
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
        <div class="col-sm-6">
            <div class="form-group {{ $errors->first('email') ? 'has-error' : '' }}">
                <label class="control-label" for="newsletter_email">{{ __('Email') }}</label> :<span
                    class="require">*</span>
                {!! Form::text('email', $result != '' ? $result->email : null, ['class' => 'form-control email', 'id' => 'newsletter_email']) !!}
                @if ($errors->has('email'))
                    <span class="error" for="newsletter_email">{{ $errors->first('email') }}</span>
                @endif
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="col-sm-6">
            <div class="form-group {{ $errors->first('subscribed_type') ? 'has-error' : '' }}">
                @php
                    $settings = \App\Models\Setting::where('label', 'Setting_newsletter_type')
                        ->pluck('value', 'name')
                        ->toArray();
                    $setting_array = ['' => __('Select')];
                    $setting_array = array_merge_recursive($setting_array, $settings);
                    
                @endphp
                <label class="control-label" for="newsletter_subscribed_type">{{ __('Type') }}</label> :<span
                    class="require">*</span>
                {!! Form::select('subscribed_type', $setting_array, $result != '' ? $result->subscribed_type : $type, ['class' => 'form-control required']) !!}
                @if ($errors->has('subscribed_type'))
                    <span class="error"
                        for="newsletter_subscribed_type">{{ $errors->first('subscribed_type') }}</span>
                @endif
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="col-sm-2">
            <div class="form-group">
                <label class="control control--checkbox">
                    {{ Form::checkbox('status', 1, $result != '' ? $result->status : true, ['id' => 'newsletter_status']) }}
                    {{ __('Status') }}
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label class="control control--checkbox">
                    {{ Form::checkbox('is_subscribed', 1, $result != '' ? $result->is_subscribed : true, ['id' => 'newsletter_is_subscribed']) }}
                    {{ __('Is subscribed') }}
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
{!! Form::close() !!}
@include('admin.general.addForm')
