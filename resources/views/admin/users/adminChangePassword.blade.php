@extends('layouts.admin')

@section('content')
<h3 class="page-title">{{ __('Change password') }} </h3>
<div class="row">
    <div class="col-sm-12 form_tabs">
        @if(isset($success))
        <div class="alert alert-success">{{ $success }}</div>
        @endif
        <form class="validate_form" action="{{ route('admin.admins.change-password') }}" method="post">
            @csrf
            <ul class="nav nav-tabs pull-left">
                <li class="pull-right"><button class="btn btn-site" type="submit"><i class="fa fa-plus"></i> {{ __('Save')}}</button></li>
                <li class="active"><a data-toggle="tab" href="#general">{{ __('General')}}</a></li>
            </ul>
            <div class="clearfix"></div>
            <div class="tab-content">
                <div class="col-sm-12 error_global hide">
                    <div class="alert alert-danger">{{ __('Fill all required fields')}}</div>
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
                        <div class="form-group  {{($errors->first('old_password')) ? 'has-error' :''}}">
                            <label class="control-label" for="adminUserOldPassword">{{ __('Old passwrod')}}</label> :<span class="require">*</span>
                            {!! Form::password('old_password', ['class'=>'form-control required', 'id'=>'adminUserOldPassword']) !!}
                            @if($errors->has('old_password'))
                            <span class="error" for="adminUserOldPassword">{{ $errors->first('old_password') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-4">
                        <div class="form-group  {{($errors->first('password')) ? 'has-error' :''}}">
                            <label class="control-label" for="adminUserPassword">{{ __('Passwrod')}}</label> :<span class="require">*</span>
                            {!! Form::password('password', ['class'=>'form-control required','id'=>"adminUserPassword", 'minlength' => '4', 'maxlength' => '20']) !!}
                            @if($errors->has('password'))
                            <span class="help-block m-b-none">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>
                    {{-- , 'equalTo' => '#adminUserPassword' --}}
                    <div class="clearfix"></div>
                    <div class="col-sm-4">
                        <div class="form-group  {{($errors->first('confirm_password')) ? 'has-error' :''}}">
                            <label class="control-label" for="adminUserconfirm_password">{{ __('Passwrod')}}</label> :<span class="require">*</span>
                            {!! Form::password('confirm_password' ,['class'=>'form-control required','id'=>"adminUsernewPassword", 'minlength' => '4', 'maxlength' => '20']) !!}
                            @if($errors->has('confirm_password'))
                            <span class="error" for="adminUsernewPassword">{{ $errors->first('confirm_password') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@include('admin.general.addForm')
