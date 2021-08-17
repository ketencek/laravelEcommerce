<div class="">
    <form action="{{ $url }}" method="post" class="" id="photo-banner-form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="page_id" value="{{ $page_id }}" />
        <div id="dropbanner" class="dropbox">
            <a class="btn btn-site banner-link"><i class="fa fa-upload"></i> {{ __('Upload file') }} <i
                    class="fa fa-spin fa-spinner hide"></i></a>
            <input type="file" name="photo" multiple="" />
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <div class="alert alert-danger margin-top-10 hide upload_fail_banner">
        </div>
    </form>
</div>
<div class="clearfix"></div>

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        function call_banner() {
            $('#banner_display').html('<i class="fa fa-spin fa-spinner"></i>');
            $.ajax({
                type: 'GET',
                url: '{{ route('admin.newsletter-messages.get-attachment') }}',
                data: 'page_id={{ $page_id }}',
                dataType: 'html',
                success: function(data2) {
                    $('#banner_display').html(data2);
                }

            });
        }
        call_banner();

        $('#dropbanner a').click(function() {
            $(this).parent().find('input').click();
        });
        $('#photo-banner-form').fileupload({
            start: function(e) {
                $('.upload_fail_banner').addClass('hide');
                $(this).find('.fa-spinner').removeClass('hide');
                $('.banner-link').addClass('disabled');
            },
            done: function(e, data) {
                data1 = data.result;
                if (data1.status == 'success') {
                    $.notify(data1.message, {
                        type: "success",
                        delay: 3000,
                        placement: {
                            from: "top",
                            align: "right"
                        },
                        animate: {
                            enter: 'animated fadeInRight',
                            exit: 'animated fadeOutRight'
                        }
                    });
                    $('.banner-link .fa-spinner').addClass('hide');
                    $('.banner-link').removeClass('disabled');
                    call_banner();

                } else {
                    $('.upload_fail_banner').removeClass('hide');
                    $('.banner-link .fa-spinner').addClass('hide');
                    $('.banner-link').removeClass('disabled');
                }
            }
        });
    });
</script>
@endpush
