{!! Form::model($result, array('url' => $url, 'method' => $method, "enctype"=>"multipart/form-data",'class'=>'validate_form', 'autocomplete'=>'off')) !!}

<!-- <form class="validate_form" action="{{$url}}" method="post" enctype="multipart/form-data"> -->
@csrf
@php
$i=1;
$langs = ['tr'=>'Turkish', 'en'=>'ENglish'];
@endphp
<ul class="nav nav-tabs pull-left">
    <li class="pull-right"><button class="btn btn-site save_btn" type="submit"><i class="fa fa-plus"></i> {{ __('Save') }}</button></li>
    <li class="active"><a data-toggle="tab" href="#general">{{ __('General') }}</a></li>
</ul>
<div class="clearfix"></div>
<div class="tab-content">
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


        <div class="clearfix"></div>
        <div class="col-sm-4">
            <div class="form-group {{($errors->first('old_url')) ? 'has-error' :''}}">
                <label class="control-label" for="redirections_old_url">{{ __('Old url')}}</label> :<span class="require">*</span>
                {!! Form::text('old_url', ($result != '' ? $result->old_url : null) ,['class'=>'form-control required','id'=>"redirections_old_url"]) !!}
                @if($errors->has('old_url'))
                <span class="help-block m-b-none">{{ $errors->first('old_url') }}</span>
                @endif
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group {{($errors->first('new_url')) ? 'has-error' :''}}">
                <label class="control-label" for="redirections_new_url">{{ __('New url')}}</label> :<span class="require">*</span>
                {!! Form::text('new_url', ($result != '' ? $result->new_url : null) ,['class'=>'form-control required','id'=>"redirections_new_url"]) !!}
                @if($errors->has('new_url'))
                <span class="help-block m-b-none">{{ $errors->first('new_url') }}</span>
                @endif
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="control control--checkbox">
                    {{ Form::checkbox('status',1,($result != '' ? $result->status : true), array('id'=>'redirections_status')) }}
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