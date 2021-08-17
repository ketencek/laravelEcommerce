@extends('layouts.admin')

@section('content')

@php
$create_url = route('admin.banner.create',['type'=>$type]) ;
@endphp
<h3 class="page-title">{{ __($type) }}
    <div class="pull-right">
        <a class="btn btn-site" role="button" href="{{ $create_url }}" id="add"><i class="fa fa-plus"></i> {{ __('Add') }}</a>
    </div>
</h3>
<div class="clearfix"></div>
<div class="row">
    <div class="col-sm-12">
        <div class="table-responsive">
            <table id="table" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center"><input type="checkbox" id="selectall" /></th>
                        <th class="text-center">{{ __('Image') }}</th>
                        <th class="">{{ __('Title') }}</th>
                        <th class="">{{ __('Language') }}</th>
                        <th class="text-center">{{ __('Status') }}</th>
                        <th class="text-center">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody id="product_rows">
                    @if(count($banners))
                    @foreach($banners as $k => $banner)
                    <tr id="row-{{ $banner['id']}}" class="row-move">
                        <td class="text-center"><input type="checkbox" class="allcheckbox" value="{{ $banner['id'] }}" /></td>
                        <td class="text-center">
                            @php
                            if (is_file(config('customconfig.path.doc.banner'). 'small/' . $banner->image)) {
                            $path = config('customconfig.path.url.banner'). 'small/' . $banner->image;
                            } else {
                            $path = asset('images/logo.png');//"/assets/images/logo/banner_small.png";
                            }
                            @endphp
                            <img class="img-responsive img-thumbnail" style="height:40px" src="{{ $path }}" alt="banner" />
                        </td>
                        <td>{{ $banner['name'] }}</td>
                        <td>{{ $banner['lang'] }}</td>
                        <td class="text-center">
                            @php
                            $icon = "fa-square-o";
                            if($banner->status == 1) {
                            $icon = "fa-check-square-o";
                            }
                            @endphp
                            @include('admin.general.singlecheckbox', ['id' => $banner->id , 'column'=>'status', "value"=>$banner->status, 'icon_class'=>$icon, 'class'=>'green'])
                        </td>
                        <td class="text-center action_div">
                            @include('admin.general.action_btn', ['id' => $banner->id, 'route' => 'admin.banner', 'type'=>$type])
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="clearfix"></div>
        @include('admin.general.changeMultiAction', array(
        'table_name' => 'banners',
        'folder_name' => 'banner',
        'ajax_url'=> '',
        'is_orderby'=> 'yes',
        'action' => array('change-status-1' => __('Active'), 'change-status-0' => __('Inactive'), 'delete' => __('Delete'))
        ))
    </div>
</div>
<div class="clearfix"></div>
@endsection