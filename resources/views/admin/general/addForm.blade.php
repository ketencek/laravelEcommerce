@push('styles')
<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css" />
@endpush

@push('scripts')
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>
<script src="{{ asset('admins/js/add.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/jquery.validate.js') }}" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(".validate_form").validate({
			errorPlacement: function(error, element) {
				error.appendTo(element.parent().addClass("has-error"));
				$('.error_global').removeClass('hide');
				$(this).find('.hide').removeClass('hide');
			},
			success: function(label) {
				label.parent().removeClass("has-error");
				label.remove();
				$('.error_global').addClass('hide');
			},
		});
	});
</script>
@endpush