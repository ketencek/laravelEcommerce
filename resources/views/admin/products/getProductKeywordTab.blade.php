<form method="post" id="productKeywordForm" action="{{ route('admin.products.saveProductKeywords') }}">
    @csrf
    <div class="col-sm-12">
        <div class="row">
            <div class="clearfix"></div>
            <input type="hidden" name="product_id" value="{{  $product_id }}" class="product_id" />
            <div class="col-sm-6">
                <div class="form-group">
                    <textarea name="producKeyword" id="producKeyword" class="form-control required product_keywords">{{ $keywords }}</textarea>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-3">
                <button class="btn btn-site saveproductkeyword" type="submit"><i class="fa fa-plus"></i> {{ __('Save') }} <i class="fa fa-spinner fa-spin hide"></i></button>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</form>
<div class="clearfix"></div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.form-control').focus(function() {
            $(this).parent().removeClass('has-error');
            $(this).parent().find('span.error').html('');
        });
    });

</script>
