@if ($result != '')
    @push('scripts')
        <link rel="stylesheet" href="{{ asset('plugins/fancybox/jquery.fancybox.css') }}" />
        <script src="{{ asset('plugins/fileuploader/js/jquery.ui.widget.js') }}"></script>
        <script src="{{ asset('plugins/fileuploader/js/jquery.fileupload.js') }}"></script>
        <script type="text/javascript" src="{{ asset('plugins/fancybox/jquery.fancybox.pack.js') }}"></script>
        <script type="text/javascript" src="{{ asset('plugins/fancybox/fancy-box.js') }}"></script>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                FancyBox.initFancybox();
            });
        </script>
    @endpush
@endif

{!! Form::model($result, ['url' => $url, 'method' => $method, 'enctype' => 'multipart/form-data', 'class' => 'validate_form', 'id' => 'form_validate', 'autocomplete' => 'off']) !!}

@csrf
<input type="hidden" value="yes" name="has_slug">
@php
$i = 1;
$langs = ['tr' => 'Turkish', 'en' => 'ENglish'];
@endphp
<ul class="nav nav-tabs pull-left">
    <li class="pull-right"><button class="btn btn-site save_btn" type="submit"><i class="fa fa-plus"></i>
            {{ __('Save') }}</button></li>
    @php
    @endphp
    <?php
    $i = 1;
    foreach ($langs as $k => $lang) :
    ?>
    <li class="{{ $i == 1 ? 'active' : '' }}"><a data-toggle="tab"
            href="#{{ $k }}">{{ $lang }}</a></li>
    <?php
        $i++;
    endforeach;
    ?>
    <li><a data-toggle="tab" class="" href="#general"><?php echo __('General'); ?></a></li>
    <?php if ($result != '') : ?>
    <li><a data-toggle="tab" href="#bannerimage" class="clickbannerimagetab"><?php echo __('Banner Images'); ?></a></li>
    <?php endif; ?>
</ul>
<div class="clearfix"></div>
<div class="tab-content">
    <div class="col-sm-12 error_global hide">
        <div class="alert alert-danger">{{ __('Fill all required fields') }}</div>
    </div>
    @if ($errors->any())
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

        <div id="{{ $lable }}" class="tab-pane fade in {{ $i == 1 ? 'active' : '' }}">
            <div class="col-sm-8">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->first($lable . '.name') ? 'has-error' : '' }}">
                            <label for="blog_category_{{ $lable }}_name">{{ __('Name') }}</label> :<span
                                class="require">*</span>
                            {!! Form::text($lable . '[name]', $result != '' ? $result->translate($lable)->name : null, ['class' => 'form-control required blogcategory', 'id' => 'blog_category_' . $lable . '_name']) !!}
                            @if ($errors->has($lable . '.name'))
                                <span class="help-block m-b-none">{{ $errors->first($lable . '.name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-sm-6">
                        <div
                            class="form-group {{ $errors->first($lable . '.short_description') ? 'has-error' : '' }}">
                            <label
                                for="blog_category_{{ $lable }}_short_description">{{ __('Short description') }}</label>
                            :
                            {!! Form::textarea($lable . '[short_description]', $result != '' ? $result->translate($lable)->short_description : null, ['class' => 'form-control', 'rows' => 4, 'cols' => 30, 'id' => 'blog_category_' . $lable . '_short_description']) !!}
                            @if ($errors->has($lable . '.short_description'))
                                <span
                                    class="help-block m-b-none">{{ $errors->first($lable . '.short_description') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 border-left">
                @include('admin.general.titleAndSlug', array('lable' => $lable, 'class_name' => 'blogcategory',
                'model_name'=>'blog_category_', 'result'=>$result))
            </div>
            <div class="clearfix"></div>
        </div>
        @php
            $i++;
        @endphp
    @endforeach
    <div id="general" class="tab-pane fade">
        <div class="col-sm-2">
            <div class="form-group">
                <label class="control control--checkbox">
                    {{ Form::checkbox('status', 1, $result != '' ? $result->status : true, ['id' => 'blog_category_status']) }}
                    {{ __('Status') }}
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>
        {!! Form::close() !!}
        <div class="clearfix"></div>
        @if ($result != '')
            <div class="col-sm-4">
                @include('admin.general.image',
                array(
                'size' =>(config('imageSize.BlogCategory.big') ? config('imageSize.BlogCategory.big') : 0),// $size,
                'page_id'=>$result['id'],
                'table_name'=>'blog_categories',
                'folder_name'=>'blogcat',
                'type'=>'BlogCategory',
                'field'=>'image',
                'url'=> route('admin.add-images')
                )
                )
                <div id="image_display" class="image_view"></div>
            </div>
            <div class="clearfix"></div>
        @endif
    </div>
    @if ($result != '')
        <div id="bannerimage" class="tab-pane fade">
            <div class="col-sm-4">
                @include('admin.general.bannerImage',
                array(
                'bannersize' =>config('imageSize.BreadcrumbBanner.big'),// $size,
                'page_id'=>$result['id'],
                'table_name'=>'blog_categories',
                'folder_name'=>'blogcat',
                'type'=>'BreadcrumbBanner',
                'field'=>'banner_image',
                'url'=> route('admin.add-images')
                )
                )
                <div id="banner_display" class="image_view"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    @endif
</div>

@include('admin.general.addForm')
