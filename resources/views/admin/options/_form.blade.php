{!! Form::model($result, array('url' => $url, 'method' => $method, "enctype"=>"multipart/form-data",'class'=>'validate_form', 'autocomplete'=>'off')) !!}

<!-- <form class="validate_form" action="{{$url}}" method="post" enctype="multipart/form-data"> -->
@csrf
@php
$i=1;
@endphp
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


        <div class="clearfix"></div>
        <div class="col-sm-4">
            <div class="form-group {{($errors->first('name')) ? 'has-error' :''}}">
                <label class="control-label" for="options_name">{{ __('name')}}</label> :<span class="require">*</span>
                {!! Form::text('name', ($result != '' ? $result->name : null) ,['class'=>'form-control required','id'=>"options_name"]) !!}
                @if($errors->has('name'))
                <span class="help-block m-b-none">{{ $errors->first('name') }}</span>
                @endif
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="control control--checkbox">
                    {{ Form::checkbox('status',1,($result != '' ? $result->status : true), array('id'=>'options_status')) }}
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