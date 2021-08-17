<h3 class="page-title-small"><?php echo __('SEO') . " [" . $lable . "]" ?></h3>

@if(!isset($is_product))
<div class="form-group">
    <label for="{{$model_name.$lable}}_slug">Slug</label> :
    {!! Form::text($lable."[slug]", ($result != '' ? $result->translate($lable)->slug : null) ,['class'=>'form-control','id'=>$model_name.$lable."_slug"]) !!}
</div>
@endif

@if(!isset($only_slug))
<div class="form-group">
    <label for="{{$model_name.$lable}}_meta_title">Page Title OR Meta Title</label> : <small id="meta_title_count_error">(Character Limit : 55)</small>
    {!! Form::text($lable."[meta_title]", ($result != '' ? $result->translate($lable)->meta_title : null) ,['class'=>'form-control meta_title_count','id'=>$model_name.$lable."_meta_title"]) !!}
</div>

<div class="form-group">
    <label for="{{$model_name.$lable}}_meta_keyword">Meta keyword</label> : <small>(Maximum Five Keyword)</small>
    {!! Form::text($lable."[meta_keyword]", ($result != '' ? $result->translate($lable)->meta_keyword : null) ,['class'=>'form-control meta_keyword_count','data-role'=>'tagsinput','id'=>$model_name.$lable."_meta_keyword"]) !!}
    <div id="meta_keyword_count_error"></div>
</div>

<div class="form-group">
    <label for="{{$model_name.$lable}}_meta_description">Meta description</label> : <small id="meta_desc_count_error">(Character Limit : 155)</small>
    {!! Form::textarea($lable."[meta_description]",($result != '' ? $result->translate($lable)->meta_description : null) ,['class'=>'form-control meta_desc_count', 'rows' => 4, 'cols' => 30, 'id'=>$model_name.$lable."_meta_description"]) !!}
</div>
@endif

<input type="hidden" name="class_name" id="class_name" value="{{ $class_name }}" />
