@foreach($items as $item)
<li><input name="product[category][]" type="checkbox" value="{{ $item->id }}" id="product_category_list_{{ $item->id }}" @if(in_array($item->id, $selected_category)) checked="checked" @endif>
    &nbsp;<label for="product_category_list_{{ $item->id }}"> @for($i=1;$i<=$count;$i++) &nbsp;&nbsp;&nbsp; @endfor {{ $item->name }} </label>
</li>
@if(count($item->items))
@include('admin.products.manageCategoryCheckbox',['items' => $item->items, 'selected_category'=>$selected_category, 'count'=> $count + 2])
@endif
@endforeach
