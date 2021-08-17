@if($result != '')
<div class="col-sm-8">
    <div class="row">
        @endif
        {!! Form::model($result, array('url' => $url, 'method' => $method, "enctype"=>"multipart/form-data",'class'=>'validate_form')) !!}
        @csrf
        <input hidden="type" name="role" value="{{ $type }}">
        <ul class="nav nav-tabs pull-left">
            <li class="pull-right"><button class="btn btn-site" type="submit"><i class="fa fa-plus"></i> {{ __('Save')}}</button></li>
            <li class="active"><a data-toggle="tab" href="#general">{{ __('General')}}</a></li>
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
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-group  {{($errors->first('first_name')) ? 'has-error' :''}}">
                            <label class="control-label" for="users_first_name">{{ __('First name')}}</label> :<span class="require">*</span>
                            {!! Form::text('first_name', ($result != '' ? $result->first_name : null) ,['class'=>'form-control required','id'=>"users_first_name"]) !!}
                            @if($errors->has('first_name'))
                            <span class="help-block m-b-none">{{ $errors->first('first_name') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-group  {{($errors->first('last_name')) ? 'has-error' :''}}">
                            <label class="control-label" for="users_last_name">{{ __('Last name')}}</label> :<span class="require">*</span>
                            {!! Form::text('last_name', ($result != '' ? $result->last_name : null) ,['class'=>'form-control required','id'=>"users_last_name"]) !!}
                            @if($errors->has('last_name'))
                            <span class="help-block m-b-none">{{ $errors->first('last_name') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-group  {{($errors->first('username')) ? 'has-error' :''}}">
                            <label class="control-label" for="users_username">{{ __('Username')}}</label> :<span class="require">*</span>
                            {!! Form::text('username', ($result != '' ? $result->username : null) ,['class'=>'form-control required','id'=>"users_username"]) !!}
                            @if($errors->has('username'))
                            <span class="help-block m-b-none">{{ $errors->first('username') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-group  {{($errors->first('email')) ? 'has-error' :''}}">
                            <label class="control-label" for="users_email">{{ __('Email')}}</label> :<span class="require">*</span>
                            {!! Form::text('email', ($result != '' ? $result->email : null) ,['class'=>'form-control required','id'=>"users_email"]) !!}
                            @if($errors->has('email'))
                            <span class="help-block m-b-none">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @if ($type == 'client')
                <div class="company">
                    <div class="col-sm-4">
                        <div class="form-group  {{($errors->first('company')) ? 'has-error' :''}}">
                            <label class="control-label" for="users_company">{{ __('Company')}}</label> :
                            {!! Form::text('company', ($result != '' ? $result->company : null) ,['class'=>'form-control required','id'=>"users_company"]) !!}
                            @if($errors->has('company'))
                            <span class="help-block m-b-none">{{ $errors->first('company') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group  {{($errors->first('vat_no')) ? 'has-error' :''}}">
                            <label class="control-label" for="users_vat_no">{{ __('Vat no')}}</label> :
                            {!! Form::text('vat_no', ($result != '' ? $result->vat_no : null) ,['class'=>'form-control','id'=>"users_vat_no"]) !!}
                            @if($errors->has('vat_no'))
                            <span class="help-block m-b-none">{{ $errors->first('vat_no') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group  {{($errors->first('vat_daire')) ? 'has-error' :''}}">
                            <label class="control-label" for="users_vat_daire">{{ __('Vat daire')}}</label> :
                            {!! Form::text('vat_daire', ($result != '' ? $result->vat_daire : null) ,['class'=>'form-control','id'=>"users_vat_daire"]) !!}
                            @if($errors->has('vat_daire'))
                            <span class="help-block m-b-none">{{ $errors->first('vat_daire') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group  {{($errors->first('tc_kimlik_no')) ? 'has-error' :''}}">
                            <label class="control-label" for="users_tc_kimlik_no">{{ __('Tc kimlik no')}}</label> :
                            {!! Form::text('tc_kimlik_no', ($result != '' ? $result->tc_kimlik_no : null) ,['class'=>'form-control','id'=>"users_tc_kimlik_no"]) !!}
                            @if($errors->has('tc_kimlik_no'))
                            <span class="help-block m-b-none">{{ $errors->first('tc_kimlik_no') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group mobile_error {{($errors->first('mobile')) ? 'has-error' :''}}">
                        <label class="control-label" for="users_mobile">{{ __('Mobile')}}</label> : :<span class="require">*</span>
                        @if (config('settingconfig.Mobile format'))
                        <div class="input-group">
                            <div class="input-group-addon" style="border-radius:0px">{{ config('settingconfig.Mobile format') }}</div>
                            @endif
                            {!! Form::text('mobile', ($result != '' ? $result->mobile : null) ,['class'=>'form-control required','id'=>"users_mobile", 'minlength' => '10']) !!}
                            @if (config('settingconfig.Mobile format'))
                        </div>
                        @endif
                        @if($errors->has('mobile'))
                        <span class="help-block m-b-none">{{ $errors->first('mobile') }}</span>
                        @endif
                    </div>
                </div>
                <div class="clearfix"></div>
                @endif
                @if($result == '')
                <div class="col-sm-4">
                        <div class="form-group  {{($errors->first('password')) ? 'has-error' :''}}">
                            <label class="control-label" for="users_password">{{ __('Passwrod')}}</label> :<span class="require">*</span>
                            {!! Form::password('password',['class'=>'form-control required','id'=>"users_password", 'minlength' => '4', 'maxlength' => '20']) !!}
                            @if($errors->has('password'))
                            <span class="help-block m-b-none">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                </div>
                <div class="col-sm-4">
                        <div class="form-group  {{($errors->first('password_confirmation')) ? 'has-error' :''}}">
                            <label class="control-label" for="users_password_confirmation">{{ __('Passwrod confirmation')}}</label> :<span class="require">*</span>
                            {!! Form::password('password_confirmation',['class'=>'form-control required','id'=>"users_password_confirmation", 'equalTo' => '#users_password', 'minlength' => '4', 'maxlength' => '20']) !!}
                            @if($errors->has('password_confirmation'))
                            <span class="help-block m-b-none">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                        </div>
                </div>
                @endif
                <div class="clearfix"></div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control control--checkbox">
                            {{ Form::checkbox('is_company',1,($result != '' ? $result->is_company : false), array('id'=>'users_is_company')) }}
                            {{ __('Business') }}
                            <div class="control__indicator"></div>
                        </label>
                    </div>
                </div>
               @if($result == '')
                <div class="col-sm-4">
                    <div class="form-group">
                    <label class="control control--checkbox">
                            {{ Form::checkbox('status',1,($result != '' ? $result->status : true), array('id'=>'users_status')) }}
                            {{ __('Status') }}
                            <div class="control__indicator"></div>
                        </label>
                    </div>
                </div>
               @endif

                <div class="clearfix"></div>
            </div>
        </div>
        {!! Form::close() !!}
        @if($result != '')
    </div>
</div>
@endif
@if($result != '')
<div class="col-sm-4 border-left">
    @include('admin.users.changePassword', array('user_id' => $result['id']))
</div>
@endif
@include('admin.general.addForm')
<script>
    companyChecked();
    $(document).on("click", "input[name='is_company']", function() {
        companyChecked();
    });

    function companyChecked() {
        var flag = 0;
        if ($("input[name='is_company']").is(':checked')) {
            $('.company').removeClass('hide');
            //$('.individual').addClass('hide');
            flag = 1;
        } else {
            $('.company').addClass('hide');
           // $('.individual').removeClass('hide');
        }
        $('#users_is_company').val(flag);
    }

</script>
