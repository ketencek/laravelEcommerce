@if ($images && $images->$field != '' && is_file(config('customconfig.path.doc.'.$folder_name). 'big/' . $images->$field))
    <div class="grid-boxes">
        <div class="item" id="img-{{ $images->id }}">
            <div class="image_layer text-center">
                <div class="action_div">
                @php    
                if ($field == 'banner_image'){
                        $class = 'bannerdelete';
                }else{
                        $class = 'imagedelete';
                }
                @endphp
                    <a href="{{ route('admin.imagedelete', array('table_name'=>$table_name, 'folder_name'=>$folder_name, 'field'=>$field, 'id'=>$images->id)) }}" id="{{ $images->id }}"  class="delete {{ $class }}"><i class="fa fa-times" ></i></a>
                </div>
                <div class="image_div">
                    <a class="fancybox" rel="gallery" href="{{ config('customconfig.path.url.'.$folder_name). 'big/' . $images->$field }}">
                        <img src="{{ config('customconfig.path.url.'.$folder_name). 'small/' . $images->$field  }}" class="img-thumbnail img-responsive" alt="" />
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    @endif