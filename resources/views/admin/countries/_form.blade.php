{!! Form::model($result, array('url' => $url, 'method' => $method, "enctype"=>"multipart/form-data",'class'=>'validate_form', 'autocomplete'=>'off')) !!}
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
    @if($errors->any())
    <div class="col-sm-12">
        <div class="alert alert-danger">
            {!! implode('', $errors->all('<p>:message</p>')) !!}
        </div>
    </div>
    @endif

    <div id="general" class="tab-pane fade in active">
        <div class="col-sm-6">
            <div class="form-group {{($errors->first('name')) ? 'has-error' :''}}">
                <label class="control-label" for="countries_name">{{ __('Name')}}</label> :<span class="require">*</span>
                {!! Form::text('name', ($result != '' ? $result->name : null) ,['class'=>'form-control required','id'=>"countries_name"]) !!}
                @if($errors->has('name'))
                <span class="error" for="countries_name">{{ $errors->first('name') }}</span>
                @endif
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group {{($errors->first('country_code')) ? 'has-error' :''}}">
                <label class="control-label" for="countries_country_code">{{ __('Code')}}</label> :<span class="require">*</span>
                {!! Form::text('country_code', ($result != '' ? $result->country_code : null) ,['class'=>'form-control required','id'=>"countries_country_code"]) !!}
                @if($errors->has('country_code'))
                <span class="error" for="countries_country_code">{{ $errors->first('country_code') }}</span>
                @endif
            </div>
        </div>
        <div class="clearfix"></div>


        <div class="clearfix"></div>
        <div class="col-sm-2">
            <div class="form-group">
                <label class="control control--checkbox">
                    {{ Form::checkbox('status', 1, $result != '' ? $result->status : true, ['id' => 'countries_status']) }}
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
