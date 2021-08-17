@if ($result != '')
    <input type="hidden" name="orderby_url" id="orderby_url" value="{{ route('admin.home.change-order') }}" />
    @push('styles')
        <link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui-1.10.3.custom.min.css') }}" />
    @endpush
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
        <script type="text/javascript" src="{{ asset('plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js') }}"></script>
    @endpush
@endif
{!! Form::model($result, ['url' => $url, 'method' => $method, 'enctype' => 'multipart/form-data', 'class' => 'validate_form', 'id' => 'form_validate', 'autocomplete' => 'off']) !!}
@csrf
<ul class="nav nav-tabs pull-left">
    <li class="pull-right"><button class="btn btn-site" type="submit"><i class="fa fa-plus"></i>
            {{ __('Save') }}</button></li>
    <li class="active"><a data-toggle="tab" href="#general">{{ __('General') }}</a></li>
    @if ($result != '')
        <li><a data-toggle="tab" href="#image" class="clickimagetab">{{ __('Images') }}</a></li>
        <li><a data-toggle="tab" href="#bannerimage" class="clickbannerimagetab">{{ __('Attachment') }}</a></li>
    @endif
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
    <div id="general" class="tab-pane fade in active">
        <div class="col-sm-8">
            <div class="form-group {{ $errors->first('subject') ? 'has-error' : '' }}">
                <label class="control-label" for="newsletter_subject">{{ __('subject') }}</label> :<span
                    class="require">*</span>
                {!! Form::text('subject', $result != '' ? $result->subject : null, ['class' => 'form-control required', 'id' => 'newsletter_subject']) !!}
                @if ($errors->has('subject'))
                    <span class="error" for="newsletter_subject">{{ $errors->first('subject') }}</span>
                @endif
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="col-sm-4">
            <div class="form-group {{ $errors->first('subscribed_type') ? 'has-error' : '' }}">
                @php
                    $settings = \App\Models\Setting::where('label', 'Setting_newsletter_type')
                    ->pluck('value', 'name')
                        ->toArray();
                    $setting_array = ['' => __('Select')];
                    $setting_array = array_merge_recursive($setting_array, $settings);
                    
                @endphp
                <label class="control-label" for="newsletter_subscribed_type">{{ __('Type') }}</label> :<span
                    class="require">*</span>
                {!! Form::select('subscribed_type', $setting_array, $result != '' ? $result->subscribed_type : $type, ['class' => 'form-control required']) !!}
                @if ($errors->has('subscribed_type'))
                    <span class="error"
                        for="newsletter_subscribed_type">{{ $errors->first('subscribed_type') }}</span>
                @endif
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="col-sm-12">
            <div class="form-group {{ $errors->first('body') ? 'has-error' : '' }}">
                <label class="control-label" for="newsletter_body">{{ __('Body') }}</label> :<span
                    class="require">*</span>
                {!! Form::textarea('body', $result != '' ? $result->body : null, ['class' => 'form-control required textareaheight', 'id' => 'newsletter_body', 'style' => 'height:500px', 'rows' => 4, 'cols' => 30]) !!}
                @if ($errors->has('body'))
                    <span class="error" for="newsletter_body">{{ $errors->first('body') }}</span>
                @endif
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="control control--checkbox">
                    {{ Form::checkbox('status', 1, $result != '' ? $result->status : true, ['id' => 'newsletter_status']) }}
                    {{ __('Status') }}
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    {!! Form::close() !!}

    @if ($result != '')
        <div id="image" class="tab-pane fade">
            <div class="col-sm-12">
                @include('admin.newslettermessage.image',
                array(
                'size' =>(config('imageSize.Newsletter_image.big') ? config('imageSize.Newsletter_image.big') :0),//
                'page_id'=>$result->id,
                'table_name'=>'newsletter_images',
                'folder_name'=>'newslettermessage',
                'type'=>'Newsletter_image',
                'field'=>'image',
                'url'=> route('admin.newsletter-messages.add-images')
                )
                )
                <div id="image_display" class="image_view"></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div id="bannerimage" class="tab-pane fade">
            <div class="col-sm-12">
                @include('admin.newslettermessage.attachment',
                array(
                'page_id'=>$result->id,
                'table_name'=>'newsletter_images',
                'url'=> route('admin.newsletter-messages.add-attachment')
                )
                )
                <div id="banner_display" class="image_view"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    @endif
</div>
