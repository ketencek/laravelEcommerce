@php
$selected_category = $product->categories->toArray();
$selected_category = array_column($selected_category, 'id');
@endphp
<style type="text/css">
    label {font-weight: 500!important}
</style>
<div class="col-sm-12">
    <form method="post" id="categoryproduct">
    @csrf
        <div class="pull-right">
            <button class="btn btn-site saveproductcategory" type="submit"><i class="fa fa-plus"></i> <?php echo __('Save') ?> <i class="fa fa-spinner fa-spin hide"></i></button>
        </div>
        <input type="hidden" name="product_id" value="{{ $product->id }}" />
        <input type="hidden" name="save_category_form" value="true" />
        <h2 class="page-title-small margin-bottom-20">{{ __('Category') }}</h2>

        <ul class="checkbox_list">
         @foreach($categories as $category)
            <li><input name="product[category][]" type="checkbox" value="{{ $category->id }}" id="product_category_list_{{ $category->id }}" @if(in_array($category->id, $selected_category)) checked="checked" @endif>
            &nbsp;<label for="product_category_list_{{ $category->id }}"> <b>{{ $category->name }}</b> </label>
            </li>
             @if(count($category->items))
            @include('admin.products.manageCategoryCheckbox',['items' => $category->items, 'selected_category'=>$selected_category, 'count'=>2])
            @endif
         @endforeach
    </form>
</div>
