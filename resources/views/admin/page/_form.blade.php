@if($result !='')
@push('scripts')
	<link rel="stylesheet" href="{{ asset('plugins/fancybox/jquery.fancybox.css')}}" />
	<script src="{{ asset('plugins/fileuploader/js/jquery.ui.widget.js')}}"></script>
	<script src="{{ asset('plugins/fileuploader/js/jquery.fileupload.js')}}"></script>
	<script type="text/javascript" src="{{ asset('plugins/fancybox/jquery.fancybox.pack.js')}}"></script>
	<script type="text/javascript" src="{{ asset('plugins/fancybox/fancy-box.js')}}"></script>
	<script type="text/javascript">
	    jQuery(document).ready(function () {
	      FancyBox.initFancybox();
	    });
	</script>
    @endpush
@endif

{!! Form::model($result, array('url' => $url, 'method' => $method, "enctype"=>"multipart/form-data",'class'=>'validate_form','id'=>'form_validate', 'autocomplete'=>'off')) !!}

<!-- <form class="validate_form" action="{{$url}}" method="post" enctype="multipart/form-data"> -->
@csrf
<input type="hidden" value="yes" name="has_slug">
<input type="hidden" value="{{$type}}" name="cat_type">
@php
$i=1;
$langs = ['tr'=>'Turkish', 'en'=>'ENglish'];
@endphp
<ul class="nav nav-tabs pull-left">
    <li class="pull-right"><button class="btn btn-site save_btn" type="submit"><i class="fa fa-plus"></i> {{ __('Save') }}</button></li>
    @php
    @endphp
    <?php
    $i = 1;
    foreach ($langs as $k => $lang) :
    ?>
        <li class="{{ ($i == 1) ? 'active' : '' }}"><a data-toggle="tab" href="#{{ $k }}">{{ $lang }}</a></li>
    <?php
        $i++;
    endforeach;
    ?>
    <li><a data-toggle="tab" class="" href="#general">{{ __('General') }}</a></li>
    <?php if ($result != '') : ?>
        <li><a data-toggle="tab" href="#bannerimage" class="clickbannerimagetab">{{ __('Banner Images') }}</a></li>
    <?php endif; ?>
</ul>
<div class="clearfix"></div>
<div class="tab-content">
    <div class="col-sm-12 error_global hide">
        <div class="alert alert-danger">{{ __('Fill all required fields')}}</div>
    </div>
    @if($errors->any())
    <div class="col-sm-12">
        <div class="alert alert-danger">
            {!! implode('', $errors->all('<p>:message</p>')) !!}
        </div>
    </div>
    @endif

    @php
    $i = 1;
    @endphp
    @foreach ($langs as $lable => $lang)

    <div id="{{ $lable }}" class="tab-pane fade in {{ ($i == 1) ? 'active' : '' }}">
        <div class="col-sm-8">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group {{($errors->first($lable.'.title')) ? 'has-error' :''}}">
                        <label for="static_page_{{ $lable }}_title">Başlık</label> :<span class="require">*</span>
                        {!! Form::text($lable."[title]", ($result != '' ? $result->translate($lable)->title : null) ,['class'=>'form-control required static_page','id'=>"static_page_".$lable."_title"]) !!}
                        @if($errors->has($lable.'.title'))
                        <span class="help-block m-b-none">{{ $errors->first($lable.'.title') }}</span>
                        @endif
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group {{($errors->first($lable.'.sub_title')) ? 'has-error' :''}}">
                        <label for="static_page_{{ $lable }}_sub_title">Alt yazı</label> :<span class="require">*</span>
                        {!! Form::textarea($lable."[sub_title]",($result != '' ? $result->translate($lable)->sub_title : null) ,['class'=>'form-control required', 'rows' => 4, 'cols' => 30, 'id'=>"static_page_".$lable."_sub_title"]) !!}
                        @if($errors->has($lable.'.sub_title'))
                        <span class="help-block m-b-none">{{ $errors->first($lable.'.sub_title') }}</span>
                        @endif
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group {{($errors->first($lable.'.short_description')) ? 'has-error' :''}}">
                        <label for="static_page_{{ $lable }}_short_description">Kısa Açıklama</label> :
                        {!! Form::textarea($lable."[short_description]",($result != '' ? $result->translate($lable)->short_description : null),['class'=>'form-control', 'rows' => 4, 'cols' => 30, 'id'=>"static_page_".$lable."_short_description"]) !!}
                        @if($errors->has($lable.'.short_description'))
                        <span class="help-block m-b-none">{{ $errors->first($lable.'.short_description') }}</span>
                        @endif
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-6">
                    <div class="form-group {{($errors->first($lable.'.image_alt')) ? 'has-error' :''}}">
                        <label for="static_page_{{ $lable }}_image_alt">Image alt</label> :
                        {!! Form::text($lable."[image_alt]",($result != '' ? $result->translate($lable)->image_alt : null),['class'=>'form-control', 'id'=>"static_page_".$lable."_image_alt"]) !!}
                        @if($errors->has($lable.'.image_alt'))
                        <span class="help-block m-b-none">{{ $errors->first($lable.'.image_alt') }}</span>
                        @endif
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="col-sm-12">
                    <div class="form-group {{($errors->first($lable.'.description')) ? 'has-error' :''}}">
                        <label for="static_page_{{ $lable }}_description">Açıklama</label> :<span class="require">*</span>
                        {!! Form::textarea($lable."[description]",($result != '' ? $result->translate($lable)->description : null),['class'=>'form-control required', 'rows' => 4, 'cols' => 30, 'id'=>"static_page_".$lable."_description"]) !!}
                        @if($errors->has($lable.'.description'))
                        <span class="help-block m-b-none">{{ $errors->first($lable.'.description') }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 border-left">
            @include('admin.general.titleAndSlug', array('lable' => $lable, 'class_name' => 'static_page', 'model_name'=>'static_page_', 'result'=>$result))
        </div>
        <div class="clearfix"></div>
    </div>
    @php
    $i ++;
    @endphp
    @endforeach
    <div id="general" class="tab-pane fade">
        <div class="clearfix"></div>
        <div class="col-sm-2">
            <div class="form-group">
                <label class="control control--checkbox">
                    {{ Form::checkbox('status',1,($result != '' ? $result->status : true), array('id'=>'static_page_status')) }}
                    Durum 
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label class="control control--checkbox">
                    {{ Form::checkbox('on_home',1,($result != '' ? $result->on_home : false), array('id'=>'static_page_on_home')) }}
                    Anasayfa 
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>
        {!! Form::close() !!}
        <div class="clearfix"></div>
        @if($result != '')
        <div class="col-sm-4">
            @include('admin.general.image',
            array(
            'size' =>(config('imageSize.'.$type.'.big') != '' ? config('imageSize.'.$type.'.big') : config('imageSize.AboutUs.big')),// $size,
            'page_id'=>$result['id'],
            'table_name'=>'pages',
            'folder_name'=>'page',
            'type'=>$type,
            'field'=>'image',
            'url'=> route('admin.add-images')
            )
            )
            <div id="image_display" class="image_view"></div>
        </div>
        <div class="clearfix"></div>
        @endif
    </div>
    @if($result != '')
    <div id="bannerimage" class="tab-pane fade">
		  <div class="col-sm-4">
          @include('admin.general.bannerImage',
            array(
            'bannersize' =>config('imageSize.BreadcrumbBanner.big'),// $size,
            'page_id'=>$result['id'],
            'table_name'=>'pages',
            'folder_name'=>'page',
            'type'=>'BreadcrumbBanner',
            'field'=>'banner_image',
            'url'=> route('admin.add-images')
            )
            )
          <div id="banner_display" class="image_view" ></div>
		  </div>
		  <div class="clearfix"></div>
		</div>
    @endif
</div>


@php
foreach ($langs as $lable => $lang):
$names[] = "static_page_" . $lable . "_description";
endforeach;
@endphp

@include('admin.general.ckEditor', array('names' => $names, 'folder' => 'staticpage'))
@include('admin.general.addForm')