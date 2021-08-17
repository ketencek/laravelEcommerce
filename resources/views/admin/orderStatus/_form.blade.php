{!! Form::model($result, array('url' => $url, 'method' => $method, "enctype"=>"multipart/form-data",'class'=>'validate_form', 'autocomplete'=>'off')) !!}
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

    @foreach ($langs as $lable => $lang)
        <div class="col-sm-4">
            <div class="form-group {{($errors->first($lable.'.name')) ? 'has-error' :''}}">
                <label class="control-label" for="order_status_name">{{ __('Name')}} {{ '('.$lang.')' }}</label> :<span class="require">*</span>
                {!! Form::text($lable.'[name]', ($result != '' ? $result->translate($lable)->name : null) ,['class'=>'form-control required','id'=>"order_status_name"]) !!}
                @if($errors->has($lable.'.name'))
                <span class="help-block m-b-none">{{ $errors->first($lable.'.name') }}</span>
                @endif
            </div>
        </div>
        @endforeach

        <div class="clearfix"></div>
        @foreach ($langs as $lable => $lang)
        <div class="col-sm-4">
            <div class="form-group {{($errors->first($lable.'.subject')) ? 'has-error' :''}}">
                <label class="control-label" for="order_status_subject">{{ __('Subject')}} {{ '('.$lang.')' }}</label> :<span class="require">*</span>
                {!! Form::text($lable.'[subject]', ($result != '' ? $result->translate($lable)->subject : null) ,['class'=>'form-control required','id'=>"order_status_subject"]) !!}
                @if($errors->has($lable.'.subject'))
                <span class="help-block m-b-none">{{ $errors->first($lable.'.subject') }}</span>
                @endif
            </div>
        </div>
        @endforeach
        
        <div class="clearfix"></div>

        <div class="col-sm-3">
            <div class="form-group">
                <label class="control control--checkbox">
                    {{ Form::checkbox('status',1,($result != '' ? $result->status : true), array('id'=>'order_status_status')) }}
                    {{ __('Status') }}
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="control control--checkbox">
                    {{ Form::checkbox('show_on_timeline',1,($result != '' ? $result->show_on_timeline : true), array('id'=>'order_status_show_on_timeline')) }}
                    {{ __('Show on timeline') }}
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
{!! Form::close() !!}

@include('admin.general.addForm')