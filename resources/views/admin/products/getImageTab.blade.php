<div class="col-sm-12">
    @include('admin.products.image',
    array(
    'size' =>(config('imageSize.Product.big') ? config('imageSize.Product.big') :0),// $size,
    'page_id'=>$product->id,
    'table_name'=>'product_images',
    'folder_name'=>'product',
    'type'=>'Product',
    'field'=>'image',
    'url'=> route('admin.products.add-product-images')
    )
    )
</div>
<div class="clearfix"></div>
<div id="product_rows" class="grid-boxes margin-top-20 image_view">
    @if (count($images))
    @foreach ($images as $image)
    <div id="row-{{ $image['id'] }}" class="col-sm-2 item row-move">
        <div class="image_layer text-center">
            <div class="action_div">
                <a id="status-{{ $image['id'] }}" href="status-{{ $image['status'] }}" class="green change_status">
                    <i class="fa fa-{{ (($image['status'] == 1) ? "check-square-o" : "square-o") }}"></i>
                </a>
                <a href="del-{{ $image['id'] }}" class="delete delete_row">
                    <i class="fa fa-times"></i>
                </a>
                <a class="handle" href="javascript:void(0)"><i class="fa fa-arrows"></i></a>
            </div>
            <div class="image_div">
                <a href="{{ config('customconfig.path.url.product'). 'big/' . $image['image'] }}" rel="gallery" class="fancybox" title="">
                    <img src="{{ config('customconfig.path.url.product'). 'small/' . $image['image'] }}" class="img-thumbnail" alt="{{ $image['image'] }}" />
                </a>
            </div>
            @php
            $color_name = __('Select color');
            foreach ($colors as $color) {
            if ($color['id'] == $image['color_id']) {
            $color_name = $color['name'];
            }
            }
            @endphp
            <button class="btn btn-sm btn-site btn-block color_popup" data-href="{{ route('admin.products.getColorPopUp') }}" data-color="{{ $image['color_id']}}" type="button" data-id="{{ $image['id'] }}">{{ $color_name }} <i class="fa fa-spin fa-spinner hide"></i></button>
        </div>
    </div>
    @endforeach
    <div class="clearfix"></div>
    @endif
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content my-model">

        </div>
    </div>
</div>
@include('admin.general.changeMultiAction', array(
'table_name' => 'product_images',
'folder_name' => 'product',
'ajax_url'=> '',
'action' => array()
))

<script type="text/javascript">
    $(document).ready(function() {
        $("#product_rows").sortable({
            items: ".row-move"
            , cursor: 'move'
            , handle: ".handle"
            , opacity: 0.5
            , update: function(event, ui) {
                jQuery.ajax({
                    type: 'POST'
                    , dataType: 'html'
                    , success: function(data) {}
                    , data: $(this).sortable('serialize')
                    , url: $('#orderby_url').val() + '?table_name=' + $('#table_name').val()
                });
            }
        });
        $("#sortable").disableSelection();
    });

</script>
