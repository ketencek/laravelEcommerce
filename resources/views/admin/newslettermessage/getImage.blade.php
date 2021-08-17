<div class="row">
    <div id="product_rows" class="grid-boxes margin-top-20 image_view">
        @if (count($images))
            @foreach ($images as $image)
                <div id="row-{{ $image['id'] }}" class="col-sm-2 item row-move">
                    <div class="image_layer text-center">
                        <div class="action_div">
                            <a id="status-{{ $image['id'] }}" href="status-{{ $image['status'] }}"
                                class="green change_status">
                                <i class="fa fa-{{ $image['status'] == 1 ? 'check-square-o' : 'square-o' }}"></i>
                            </a>
                            <a href="del-{{ $image['id'] }}" class="delete delete_row">
                                <i class="fa fa-times"></i>
                            </a>
                            <a class="handle" href="javascript:void(0)"><i class="fa fa-arrows"></i></a>
                        </div>
                        <div class="image_div">
                            <a href="{{ config('customconfig.path.url.newslettermessage') . 'medium/' . $image['image'] }}"
                                rel="gallery" class="fancybox" title="">
                                <img src="{{ config('customconfig.path.url.newslettermessage') . 'small/' . $image['image'] }}"
                                    class="img-thumbnail" alt="{{ $image['image'] }}" />
                            </a>
                        </div>
                        <form method="post" id="form-{{ $image['id'] }}">
                            @csrf
                            <input style="padding:6px 3px; margin-top:5px;margin-bottom: 5px" type="text" name="link"
                                id="link-{{ $image['id'] }}" placeholder="{{ __('Title') }}"
                                class="form-control txt-focus required" value="{{ $image['link'] }}" />
                            <button class="btn btn-sm btn-site name-save btn-block" type="submit"
                                id="record-{{ $image['id'] }}">{{ __('Save') }} <i
                                    class="fa fa-spin fa-spinner hide"></i></button>
                        </form>
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
        $("#product_rows").sortable({
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
<script type="text/javascript">
    $(document).ready(function() {
        $('.form-control').focus(function() {
            $(this).removeClass('error');
        });
        $(document).on("click", ".name-save", function() {
            id = this.id.split("-");
            var div_id = this.id;
            link = $('#link-' + id[1]).val();
            if (link == '') {
                $('#link-' + id[1]).addClass('error');
            } else {
                parent = $(this);
                parent.find('.fa-spinner').removeClass('hide');
                parent.addClass('disabled');
                $.ajax({
                    type: 'GET',
                    data: ($('#form-' + id[1]).serialize() + '&id=' + id[1]),
                    url: "{{ route('admin.newsletter-messages.saveLink') }}",
                    dataType: 'json',
                    success: function(data) {
                        if (data.success == 0) {
                            $.notify('{{ __('Record not found') }}', {
                                type: "danger",
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
                        } else {
                            $.notify('{{ __('Save Successfully') }}', {
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

                        }
                        parent.find('.fa-spinner').addClass('hide');
                        parent.removeClass('disabled');
                    }
                });
            }
            return false;
        });

    });
</script>
