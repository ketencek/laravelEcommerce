<div class="modal-header">
    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
    <h1 class="modal-title font-18"><i class="fa fa-check"></i> {{ __('Save Color') }} </h1>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <form method="post" id="colorSaveForm" class="validate_form">
                <input type="hidden" name="product_id" value="{{ $product_id }}"/>
                <input type="hidden" name="id" value="{{ $id }}"/>
                <div class="form-group">
                    <select name="color_id" class="sel_color_id form-control">
                        <option value="">{{ __('Select') }}</option>
                        @foreach ($colors as $color)
                            <option value="{{ $color['id'] }}" 
                            {{  ($color['id'] == $color_id) ? "selected='selected'" : ""}}
                           >
                            {{  $color['name'] }}</option>
                         @endforeach
                    </select>
                </div>
                <button class="btn btn-sm btn-site btn-block color-pro-save" type="submit" id="record-{{  $id }}">{{  __('Save') }} <i class="fa fa-spin fa-spinner hide"></i></button>
            </form>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="modal-footer">
    <button data-dismiss="modal" class="btn btn-default">{{  __('Close') }}</button>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.form-control').focus(function() {
            $(this).parent().removeClass('has-error');
        });

    });
</script>