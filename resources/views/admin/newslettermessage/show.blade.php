<div class="modal-header">
  <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
  <h1 class="modal-title font-18"><i class="fa fa-check"></i> {{ __('View More') }}</h1>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-sm-12">
      <div><strong>{{ __('Subject') . ' : ' }}</strong>{{ $messages['subject'] }}</div>
      <div><strong>{{ __('Message') . ' : ' }}</strong>{{ html_entity_decode($messages['body']) }}</div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button data-dismiss="modal" class="btn btn-default">{{ __('Close') }}</button>
</div>










