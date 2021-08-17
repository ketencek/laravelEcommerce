<div class="">
  <form action="{{ $url }}" method="post" class="" id="photo-form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="product_id" value="{{ $page_id }}" />
    <input type="hidden" name="folder_name" value="{{ $folder_name }}" />
    <input type="hidden" name="type" value="{{ $type }}" />
    <div id="drop" class="dropbox">
      <a class="btn btn-site image-link"><i class="fa fa-upload"></i> {{ __('Upload image')}} <i class="fa fa-spin fa-spinner hide"></i></a>
      <input type="file" name="image" />
      <span class="photo_size">{{ $size }}</span>
      <div class="clearfix"></div>
    </div>

    <div class="alert alert-danger margin-top-10 hide upload_fail">
    </div>
  </form>
</div>
<div class="clearfix"></div>
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
        //   data1 = JSON.parse(data.result);
        if (data1.status == 'success') {
          $('#imagetab').trigger('click');
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
          $('.image-link .fa-spinner').addClass('hide');
          $('.image-link').removeClass('disabled');
        } else {
          $('.upload_fail').html(data1.message);
          $('.upload_fail').removeClass('hide');
          $('.image-link .fa-spinner').addClass('hide');
          $('.image-link').removeClass('disabled');
        }
      }
    });
  });
</script>