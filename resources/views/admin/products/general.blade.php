@php
$i = 1;
$langs = ['tr' => 'Turkish', 'en' => 'ENglish'];
@endphp
<div class="col-sm-12 error_global hide">
    <div class="alert alert-danger"><?php echo __('Fill all required fields'); ?></div>
</div>
@if ($errors->any())
    <div class="col-sm-12">
        <div class="alert alert-danger">
            {!! implode('', $errors->all('<p>:message</p>')) !!}
        </div>
    </div>
@endif

{!! Form::model($result, ['url' => $url, 'method' => $method, 'enctype' => 'multipart/form-data', 'class' => 'validate_form', 'id' => 'form_validate', 'autocomplete' => 'off']) !!}
@csrf
<input type="hidden" value="yes" name="has_slug">

<div class="col-sm-8">
    <div class="row">
        @foreach ($langs as $lable => $lang)
            <div class="col-sm-6">
                <div class="form-group {{ $errors->first($lable . '.name') ? 'has-error' : '' }}">
                    <label for="products_{{ $lable }}_name">{{ __('Name') }} {{ '(' . $lang . ')' }}</label>
                    :<span class="require">*</span>
                    {!! Form::text($lable . '[name]', $result != '' ? $result->translate($lable)->name : null, ['class' => 'form-control required products', 'id' => 'products_' . $lable . '_name']) !!}
                    @if ($errors->has($lable . '.name'))
                        <span class="help-block m-b-none">{{ $errors->first($lable . '.name') }}</span>
                    @endif
                </div>
            </div>
        @endforeach
        <div class="col-sm-4">
            <div class="form-group  {{ $errors->first('product_code') ? 'has-error' : '' }}">
                <label class="control-label" for="products_product_code">{{ __('Product code') }}</label> :<span
                    class="require">*</span>
                {!! Form::text('product_code', $result != '' ? $result->product_code : null, ['class' => 'form-control required', 'id' => 'products_product_code']) !!}
                @if ($errors->has('product_code'))
                    <span class="help-block m-b-none">{{ $errors->first('product_code') }}</span>
                @endif
            </div>
        </div>
        @php
            $product_type = ['ColorBase' => 'ColorBase', 'SizeBase' => 'SizeBase', 'BOTH' => 'BOTH', 'NoColorSize' => 'NoColorSize'];
        @endphp
        <div class="col-sm-4">
            <div class="form-group {{ $errors->first('product_type') ? 'has-error' : '' }}">
                <label class="control-label" for="products_product_type">{{ __('Type') }}</label> :<span
                    class="require">*</span>
                {!! Form::select('product_type', $product_type, $result != '' ? $result->product_type : $type, ['class' => 'form-control required', 'id' => 'products_product_type']) !!}
                @if ($errors->has('product_type'))
                    <span class="help-block m-b-none">{{ $errors->first('product_type') }}</span>
                @endif
            </div>
        </div>
        @foreach ($langs as $lable => $lang)
            <div class="col-sm-6">
                <div class="form-group {{ $errors->first($lable . '.short_description') ? 'has-error' : '' }}">
                    <label for="products_{{ $lable }}_short_description">{{ __('Short description') }}
                        {{ '(' . $lang . ')' }}</label> :
                    {!! Form::textarea($lable . '[short_description]', $result != '' ? $result->translate($lable)->short_description : null, ['class' => 'form-control', 'rows' => 4, 'cols' => 30, 'id' => 'products_' . $lable . '_short_description']) !!}
                    @if ($errors->has($lable . '.short_description'))
                        <span class="help-block m-b-none">{{ $errors->first($lable . '.short_description') }}</span>
                    @endif
                </div>
            </div>
        @endforeach

        @foreach ($langs as $lable => $lang)
            <div class="col-sm-12">
                <div class="col-sm-12">
                    <div class="form-group {{ $errors->first($lable . '.description') ? 'has-error' : '' }}">
                        <label for="products_{{ $lable }}_description">{{ __('Description') }}
                            {{ '(' . $lang . ')' }}</label> :<span class="require">*</span>
                        {!! Form::textarea($lable . '[description]', $result != '' ? $result->translate($lable)->description : null, ['class' => 'form-control required', 'rows' => 4, 'cols' => 30, 'id' => 'products_' . $lable . '_description']) !!}
                        @if ($errors->has($lable . '.description'))
                            <span class="help-block m-b-none">{{ $errors->first($lable . '.description') }}</span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        <div class="clearfix"></div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="control control--checkbox">
                    {{ Form::checkbox('status', 1, $result != '' ? $result->status : true, ['id' => 'products_status']) }}
                    {{ __('Status') }} <div class="control__indicator"></div>
                </label>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="control control--checkbox">
                    {{ Form::checkbox('is_new', 1, $result != '' ? $result->is_new : false, ['id' => 'products_is_new']) }}
                    {{ __('Is new') }} <div class="control__indicator"></div>
                </label>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="control control--checkbox">
                    {{ Form::checkbox('on_home', 1, $result != '' ? $result->on_home : false, ['id' => 'products_on_home']) }}
                    {{ __('On home') }}
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                <label class="control control--checkbox">
                    {{ Form::checkbox('is_visible_price', 1, $result != '' ? $result->is_visible_price : true, ['id' => 'products_is_visible_price']) }}
                    {{ __('Is visible price') }}
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="control control--checkbox">
                    {{ Form::checkbox('free_shipping', 1, $result != '' ? $result->free_shipping : false, ['id' => 'products_free_shipping']) }}
                    {{ __('Free shipping') }}
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-3">
            <button class="btn btn-site" type="submit"><i class="fa fa-plus"></i> <?php echo __('Save'); ?></button>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="col-sm-4 border-left">
    @foreach ($langs as $lable => $lang)
        @include('admin.general.titleAndSlug', array('lable' => $lable, 'class_name' => 'products',
        'model_name'=>'products_', 'result'=>$result))
        <div style="border-top: 1px solid #000000;margin-bottom: 10px"></div>
    @endforeach
</div>
{!! Form::close() !!}
@php
foreach ($langs as $lable => $lang):
    $names[] = 'products_' . $lable . '_description';
endforeach;
@endphp
@include('admin.general.ckEditor', array('names' => $names, 'folder' => 'product'))
