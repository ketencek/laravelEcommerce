<div class="">
    <form action="{{ $url }}" method="post" class="" id="photo-form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="table_name" value="{{ $table_name }}" />
        <input type="hidden" name="field" value="{{ $field }}" />
        <input type="hidden" name="folder_name" value="{{ $folder_name }}" />
        <input type="hidden" name="type" value="{{ $type }}" />
        <div id="drop" class="dropbox">
            <a class="btn btn-site image-link"><i class="fa fa-upload"></i> {{ __('Upload image') }} <i
                    class="fa fa-spin fa-spinner hide"></i></a>
            <input type="file" name="image" />
            <span class="photo_size">{{ $size }}</span>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <div class="alert alert-danger margin-top-10 hide upload_fail">
        </div>
    </form>
</div>
<div class="clearfix"></div>
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#drop a').click(function() {
                $(this).parent().find('input').click();
            });
            $('#photo-form').fileupload({
                start: function(e) {
                    $('.upload_fail').addClass('hide');
                    $(this).find('.fa-spinner').removeClass('hide');
                    $('.image-link').addClass('disabled');
                },
                done: function(e, data) {
                    data1 = data.result;
                    if (data1.status == 'success') {
                        $('.image-link .fa-spinner').addClass('hide');
                        $('.image-link').removeClass('disabled');
                        window.location = '';
                    } else {
                        $('.upload_fail').removeClass('hide');
                        $('.image-link .fa-spinner').addClass('hide');
                        $('.image-link').removeClass('disabled');
                    }
                }
            });
        });
    </script>
@endpush
