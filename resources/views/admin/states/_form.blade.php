{!! Form::model($result, ['url' => $url, 'method' => $method, 'enctype' => 'multipart/form-data', 'class' => 'validate_form', 'autocomplete' => 'off']) !!}
<ul class="nav nav-tabs pull-left">
    <li class="pull-right"><button class="btn btn-site save_btn" type="submit"><i class="fa fa-plus"></i>
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
        @php
           $country_array = \App\Models\Country::pluck('name','id');
        @endphp
        <div class="col-sm-6">
            <div class="form-group {{($errors->first('country_id')) ? 'has-error' :''}}">
                <label class="control-label" for="states_country_id">{{__('Type')}}</label> :<span class="require">*</span>
                {!! Form::select('country_id', $country_array,($result!=''? $result->country_id : $type), array('class' => 'form-control required','id'=>'states_country_id')) !!}
                @if($errors->has('country_id'))
                <span class="help-block m-b-none">{{ $errors->first('country_id') }}</span>
                @endif
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group {{($errors->first('name')) ? 'has-error' :''}}">
                <label class="control-label" for="states_name">{{ __('Name')}}</label> :<span class="require">*</span>
                {!! Form::text('name', ($result != '' ? $result->name : null) ,['class'=>'form-control required','id'=>"states_name"]) !!}
                @if($errors->has('name'))
                <span class="help-block m-b-none">{{ $errors->first('name') }}</span>
                @endif
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group {{($errors->first('state_code')) ? 'has-error' :''}}">
                <label class="control-label" for="state_states_code">{{ __('Code')}}</label> :
                {!! Form::text('state_code', ($result != '' ? $result->state_code : null) ,['class'=>'form-control ','id'=>"state_states_code"]) !!}
                @if($errors->has('state_code'))
                <span class="help-block m-b-none">{{ $errors->first('state_code') }}</span>
                @endif
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="clearfix"></div>
        <div class="col-sm-2">
            <div class="form-group">
                <label class="control control--checkbox">
                    {{ Form::checkbox('status',1,($result != '' ? $result->status : true), array('id'=>'sizes_status')) }}
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
