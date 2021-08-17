<div class="row">
    <div id="product_rows2" class="grid-boxes margin-top-20 image_view">
        @if (count($images))
            @foreach ($images as $key => $banner)
                @php
                    $ext = explode('.', $banner['image']);
                    $ext = end($ext);
                @endphp
                <div id="row-{{ $banner['id'] }}" class="col-sm-2 item row-move">
                    <div class="image_layer text-center">
                        <div class="action_div">
                            <a id="status-{{ $banner['id'] }}" href="status-{{ $banner['status'] }}"
                                class="green change_status">
                                <i class="fa fa-{{ $banner['status'] == 1 ? 'check-square-o' : 'square-o' }}"></i>
                            </a>
                            <a href="del-{{ $banner['id'] }}" class="delete delete_row">
                                <i class="fa fa-times"></i>
                            </a>
                            <a class="handle" href="javascript:void(0)"><i class="fa fa-arrows"></i></a>
                        </div>
                        <div class="image_div">
                            <a href="{{ config('customconfig.path.url.newslettermessage') . 'attachment/' . $banner['image'] }}"
                                rel="gallery" class="fancybox" title="">
                                <img src=" {{ asset('images/extension/'.$ext.'.png') }}" class="img-thumbnail"
                                    alt="{{ $banner['image'] }}" />
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="clearfix"></div>
        @endif
    </div>
</div>

@include('admin.general.changeMultiAction', array(
'table_name' => 'newsletter_images',
'folder_name' => 'newslettermessage',
'ajax_url'=> '',
'action' => array()
))

<script type="text/javascript">
    $(document).ready(function() {
        $("#product_rows2").sortable({
            items: ".row-move",
            cursor: 'move',
            handle: ".handle",
            opacity: 0.5,
            update: function(event, ui) {
                jQuery.ajax({
                    type: 'POST',
                    dataType: 'html',
                    success: function(data) {},
                    data: $(this).sortable('serialize'),
                    url: $('#orderby_url').val() + '?table_name=' + $('#table_name').val()
                });
            }
        });
        $("#sortable").disableSelection();
    });
</script>
