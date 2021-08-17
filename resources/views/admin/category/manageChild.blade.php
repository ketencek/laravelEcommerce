<ul>
@foreach($items as $item)
   <li>
       {{ $item->name }}
       @if(count($item->items))
            @include('admin.category.manageChild',['items' => $item->items])
        @endif
   </li>
@endforeach
</ul>