    <script>

        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 5000
        };

        @if(\Session::has('error'))
            toastr.error('{{ \Session::get('error') }}', 'Error');
        @endif
        @if(\Session::has('success'))
            toastr.success('{{ \Session::get('success') }}', 'Success');
        @endif

        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>

        function deleteRecordByAjax(deleteUrl, moduleName, dataTablesName, appendMsg) {
            appendMsg = appendMsg || '';
            var deleteAlertStr = "{{ __('admin/general.delete_confirm_msg') }}"+" "+moduleName+"? "+appendMsg;

            swal({
                    title: "{{ __('admin/general.are_you_sure') }}",
                    text: deleteAlertStr,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{ __('admin/general.yes') }}",
                    cancelButtonText: "{{ __('admin/general.no') }}",
                    showLoaderOnConfirm: true,
                    allowOutsideClick:false,
                    allowEscapeKey:false,
                    preConfirm: function (email) {
                        return new Promise(function (resolve, reject) {
                            setTimeout(function() {
                                jQuery.ajax({
                                    url: deleteUrl,
                                    type: 'DELETE',
                                    dataType: 'json',
                                    data: {
                                        "_token": window.Laravel.csrfToken
                                    },
                                    success: function (result) {
                                        dataTablesName.draw();
                                        swal({
                                          type: 'success',
                                          title: '{{ __('admin/general.success') }}',
                                          confirmButtonText: '{{ __('admin/general.ok') }}',
                                          html: moduleName+' '+'{{ __('admin/general.delete_success_msg') }}'
                                        });
                                        fnToastSuccess(result.message);
                                    },
                                    error: function (xhr, status, error) {
                                        if(xhr.responseJSON && xhr.responseJSON.message!=""){
                                            swal({
                                              type: 'error',
                                              title: '{{ __('admin/general.ohh_snap') }}',
                                              confirmButtonText: '{{ __('admin/general.ok') }}',
                                              html: xhr.responseJSON.message
                                            });
                                        } else {
                                            swal({
                                              type: 'error',
                                              title: '{{ __('admin/general.ohh_snap') }}',
                                              confirmButtonText: '{{ __('admin/general.ok') }}',
                                              html: '{{ __('admin/general.error_msg') }}'
                                            });
                                        }
                                        ajaxError(xhr, status, error);
                                    }
                                });      
                            }, 0)
                        })
                    },
                });
        }

        function changeStatusByAjax(changeStatusUrl, id, dataTablesName) {
            $.ajax({
                url: changeStatusUrl,
                type: 'POST',
                dataType: 'json',
                data: {
                    "_token": window.Laravel.csrfToken,
                    id : id
                },
                success: function (result) {
                    dataTablesName.draw();
                    swal({
                      type: 'success',
                      title: '{{ __('admin/general.success') }}',
                      confirmButtonText: '{{ __('admin/general.ok') }}',
                      html: result.message
                    });
                    fnToastSuccess(result.message);
                },
                error: function (xhr, status, error) {
                    if(xhr.responseJSON && xhr.responseJSON.message!=""){
                        swal({
                          type: 'error',
                          title: '{{ __('admin/general.ohh_snap') }}',
                          confirmButtonText: '{{ __('admin/general.ok') }}',
                          html: xhr.responseJSON.message
                        });
                    } else {
                        swal({
                          type: 'error',
                          title: '{{ __('admin/general.ohh_snap') }}',
                          confirmButtonText: '{{ __('admin/general.ok') }}',
                          html: '{{ __('admin/general.error_msg') }}'
                        });
                    }
                    ajaxError(xhr, status, error);
                }
            });
        }

        function fnToastSuccess(message) {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 4000
            };
            toastr.success(message);
        }

        function fnToastError(message) {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 4000
            };
            toastr.error(message);
        }

        function ajaxError(xhr, status, error) {
            if(xhr.status ==401){
                fnToastError("{{ __('admin/general.login_error') }}");
            }else if(xhr.status == 403){
                fnToastError("{{ __('admin/general.permission_error') }}");
            }else if(xhr.responseJSON && xhr.responseJSON.message!=""){
                fnToastError(xhr.responseJSON.message);
            }else{
                fnToastError("{{ __('admin/general.default_error') }}");
            }
        }

        function displayImageOnFileSelect(input, thumbElement) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(thumbElement).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function nl2br (str, is_xhtml) {
            var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
            return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
        }

        function convertToSlug(Text)
        {
            return Text
                .toLowerCase()
                .replace(/ /g,'-')
                .replace(/[^\w-]+/g,'')
                ;
        }


        // reset select2
    $('.filters').on('select2:unselecting', function() {
            $(this).data('unselecting', true);
    }).on('select2:opening', function(e) {
        if ($(this).data('unselecting')) {
                $(this).removeData('unselecting');
                e.preventDefault();
        }
    });


    // button loading
    function simpleLoad(btn, state,button_text) {
        button_text=typeof button_text==undefined?'Save':button_text;
        if (state) {
                btn.children().first().addClass('fa fa-spinner fa-spin');
                btn.contents().last().replaceWith(" Loading");
                btn.prop('disabled',true);
        } else {
            btn.children().first().removeClass('fa fa-spinner fa-spin');
            btn.contents().last().replaceWith(button_text);
            btn.prop('disabled',false);
        }
    }
    // disable chartacter in text box
    $('.disable_char').on('keydown',function(e){
        -1!==$.inArray(e.keyCode,[46,8,9,27,13,110])||(/65|67|86|88/.test(e.keyCode)&&(e.ctrlKey===true||e.metaKey===true))&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()
    });

    setTimeout(function(){
        $('.has-error').find('.help-block').hide();
        $('.form-group.has-error').removeClass('has-error');
    },8000);
    
    </script>