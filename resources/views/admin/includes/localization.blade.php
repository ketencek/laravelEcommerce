<script type="text/javascript">
	$('#change_lang').on('change', function(event) {
		var lang = $(this).val();
		$.ajax({
			url: '{{url('admin/change-lang')}}',
			type: 'POST',
			dataType: 'json',
			data: {
				_token : window.Laravel.csrfToken,
				language: lang
			},
		})
		.success(function(responce) {
			console.log("success");
			fnToastSuccess(responce.message);
			setTimeout(function(){
				location.reload();
			}, 2000);

		})
		.error(function (xhr, status, error) {
	        ajaxError(xhr, status, error);
	    });
		
	});	
	
</script>