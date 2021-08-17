{!! Form::model($result, array('url' => $url, 'method' => $method, "enctype"=>"multipart/form-data",'class'=>'validate_form')) !!}

<!-- <form class="validate_form" action="{{$url}}" method="post" enctype="multipart/form-data"> -->
@csrf

<ul class="nav nav-tabs pull-left">
    <li class="pull-right"><button class="btn btn-site submit" type="submit"><i class="fa fa-plus"></i> {{ __('Save') }}</button></li>
    <li class="active"><a data-toggle="tab" href="#general">{{__('General') }}</a></li>
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

        <div class="col-sm-4">
            <div class="form-group {{($errors->first('name')) ? 'has-error' :''}}">
                <label class="control-label" for="settings_name">{{ __('Name')}}</label> :<span class="require">*</span>

                @if($result!='')
                {!! Form::text('name', ($result != '' ? $result->name : null) ,['class'=>'form-control required','id'=>"settings_name", 'readonly'=>'readonly']) !!}
                @else
                {!! Form::text('name', ($result != '' ? $result->name : null) ,['class'=>'form-control required','id'=>"settings_name"]) !!}
                @endif

                @if($errors->has('name'))
                <span class="help-block m-b-none">{{ $errors->first('name') }}</span>
                @endif
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="col-sm-4">
            <div class="form-group {{($errors->first('label')) ? 'has-error' :''}}">
                @php
                $settings = config('customconfig.settings_type');
                $setting_array = [''=>'Select'];
                foreach ($settings as $k => $setting){
                $setting_array[$setting] = __($setting);
                }
                @endphp
                <label class="control-label" for="settings_label">{{__('Type')}}</label> :<span class="require">*</span>
                {!! Form::select('label', $setting_array,($result!=''? $result->label : $type), array('class' => 'form-control required')) !!}
                @if($errors->has('label'))
                <span class="help-block m-b-none">{{ $errors->first('label') }}</span>
                @endif
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="col-sm-4">
            <div class="form-group  {{($errors->first('value')) ? 'has-error' :''}}">
                <label class="control-label" for="settings_value">{{ __('Value')}}</label> :<span class="require">*</span>
                {!! Form::text('value', ($result != '' ? $result->value : null) ,['class'=>'form-control required','id'=>"settings_value"]) !!}
                @if($errors->has('value'))
                <span class="help-block m-b-none">{{ $errors->first('value') }}</span>
                @endif
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="control control--checkbox">
                    {{ Form::checkbox('status',1,($result != '' ? $result->status : true), array('id'=>'static_page_status')) }}
                    {{ __('Status') }}
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
{!! Form::close() !!}
@include('admin.general.addForm')
