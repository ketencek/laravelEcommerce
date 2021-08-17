<form id="frm_changepassword" class="validate_form1" method="POST" action="{{ route('admin.users.change-password') }}">
    <h3 class="page-title">{{ __('Change password') }} </h3>
    @csrf
    <input type="hidden" value="{{ $user_id }}" name="user_id">
    <div class="col-sm-12">
        <div class="form-group  {{($errors->first('new_password')) ? 'has-error' :''}}">
            <label class="control-label" for="change_password_new_password">{{ __('New password')}}</label> :<span class="require">*</span>
            {!! Form::password('new_password', ['class'=>'form-control required','id'=>"change_password_new_password", 'minlength' => '4', 'maxlength' => '20']) !!}
            <span  class="error" id="err_new_password">
            @if($errors->has('new_password'))
            {{ $errors->first('new_password') }}
            @endif
            </span>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group  {{($errors->first('confirm_new_password')) ? 'has-error' :''}}">
            <label class="control-label" for="change_password_confirm_new_password">{{ __('Confirm new password')}}</label> :<span class="require">*</span>
            {!! Form::password('confirm_new_password', ['class'=>'form-control required','id'=>"change_password_confirm_new_password", 'minlength' => '4', 'maxlength' => '20']) !!}
            <span  class="error" id="err_confirm_new_password">
            @if($errors->has('confirm_new_password'))
            {{ $errors->first('confirm_new_password') }}
            @endif
            </span>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="form-group pull-right">
        <button class="btn btn-site commentbtnsave" type="submit"><i class="fa fa-edit"></i> {{ __('Update') }} <i class="fa fa-spinner fa-spin hide"></i></button>
    </div>
    <div class="clearfix"></div>
</form>

<script type="text/javascript">
    jQuery(document).ready(function() {

        $(document).on('submit', '#frm_changepassword', function() {

            $('.has-error').removeClass('has-error');
            $('.commentbtnsave').find('.fa-spinner').removeClass('hide');
            $('.commentbtnsave').addClass('disabled');
            $('#frm_changepassword .error').html('');
            var url = $(this).attr('action');
            var parent = $(this);
            $.ajax({
                type: 'post'
                , url: url
                , data: $('#frm_changepassword').serialize()
                , dataType: 'json'
                , success: function(data) {
                    if (data.status == 'success') {
                        $('#frm_changepassword')[0].reset();
                        $.notify(data.message, {
                            type: "success"
                            , delay: 3000
                            , placement: {
                                from: "top"
                                , align: "right"
                            }
                            , animate: {
                                enter: 'animated fadeInRight'
                                , exit: 'animated fadeOutRight'
                            }
                        });
                    } else {
                        $.each(data, function(i, j) {
                            if (i != 'status') {
                                $('#err_' + i).parent().addClass('has-error');
                                $('#err_' + i).html(j);
                            }
                        });
                    }
                    $('.commentbtnsave').find('.fa-spinner').addClass('hide');
                    $('.commentbtnsave').removeClass('disabled');
                },
                error :function( data ) {
                    if(data.status === 422) {
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors.errors, function (key, value) {
                            $('#err_' + key).parent().addClass('has-error');
                                $('#err_' + key).html(value);
                        });
                         $('.commentbtnsave').find('.fa-spinner').addClass('hide');
                    $('.commentbtnsave').removeClass('disabled');
                    }
                }
            });
            return false;
        });
    });

</script>
