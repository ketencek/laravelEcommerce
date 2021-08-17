<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//TR" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="tr" xml:lang="tr">

<head>
	<?php// include_http_metas() ?>
	<?php //include_metas() ?>
	<meta name="language" content="tr" />
	<title> Admin Panel</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<?php// include_partial('global/favicon'); ?>
	<link rel='stylesheet' href='{{ asset("admins/css/layout.min.css")}}' type='text/css' media='all' />
	<link rel='stylesheet' href='{{ asset("admins/css/admin_form.min.css")}}' type='text/css' media='all' />
</head>

<body>
	<div class="container">
		<div class="form-container">
			<img class="logo" src="{{ asset('images/logo.svg')}} " alt="hummel" style="max-width: 100%" />

            <form class="form-signin" method="post" action="{{ route('admin.login.post') }}"  id="LoginForm" onsubmit="onSubmitSignin">
            {{ csrf_field() }}
            <label for="signin_username">Kullanıcı adı</label>  
            <input class="form-control"  name="email"  class="form-control required" type="text" placeholder='{{__("admin/login.email_username")}}' value="{{ old('email') }}" id="signin_username" autofocus/>  
          
            <div class="form-group">
                <label for="signin_password">Şifre</label>    
            <input type="password" name="password" class="form-control required" minlength="4" maxlength="20" placeholder='{{__("admin/login.password")}}' id="signin_password" />    <span toggle="#signin_password" class="fa fa-eye-slash toggle-password" style="float: right;
                margin-top: -25px;
                margin-right: 5px;
                position: relative;
                z-index: 2;"></span>
                </div>
                <button class="btn btn-site" type="submit"><i class="fa fa-lock"></i> Giriş <i class="fa fa-spin fa-spinner hide"></i></button>
            </form>		
		</div>
	</div>
	@include('admin.includes.footer')

    <script type="text/javascript" src="{{ asset('admins/js/jquery-1.11.0.min.js')}}"></script>
	<!--[if lt IE 7]>
  <script src="/assets/js/html5shiv.min.js"></script>
  <script src="/assets/js/respond.min.js"></script>
  <![endif]-->
	
	<script type="text/javascript">
		$(document).ready(function() {
			$(document).on("focus", ".form-control", function() {
				$(this).removeClass('error');
			});
			$(".toggle-password").click(function() {
				$(this).toggleClass("fa-eye-slash fa-eye");
				var input = $($(this).attr("toggle"));
				if (input.attr("type") == "password") {
					input.attr("type", "text");
				} else {
					input.attr("type", "password");
				}
			});
		});

		function onSubmitSignin() {
			// console.log('asd');
			flag = 1;
			$('.fa-spinner').removeClass('hide');
			$('.btn-site').addClass('disabled');
			if ($('#signin_username').val() == '') {
				flag = 0;
				$('#signin_username').addClass('error');
			}
			if ($('#signin_password').val() == '') {
				flag = 0;
				$('#signin_password').addClass('error');
			}
			// if ($('#signin_captcha').val() == '') {
			// 	flag = 0;
			// 	$('#signin_captcha').addClass('error');
			// }
			if (flag == 0) {
				$('.fa-spinner').addClass('hide');
				$('.btn-site').removeClass('disabled');
				return false;
			} else {
				$('.form-signin').submit();
			}
		}
	</script>
</body>

</html>
