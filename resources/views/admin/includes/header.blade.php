    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Login') }} - {{ __('admin/general.admin') }}</title>

    <link href="{{ asset('admins/css/bootstrap.min.css') }}" rel="stylesheet">
    	
    <!-- Toastr style -->
    <link href="{{ asset('plugins/toastr/toastr.min.css') }}" rel="stylesheet">

    <!-- Gritter -->
    <link href="{{ asset('plugins/gritter/jquery.gritter.css') }}" rel="stylesheet">
    
    <link href="{{ asset('admins/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('admins/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('fonts/stylesheet.css') }}" rel="stylesheet">
    <link href="{{asset('admins/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <!-- <link href="{{ asset('admins/css/adminstyle.css') }}" rel="stylesheet"> -->
<!--     
    <link href="{{asset('plugins/iCheck/custom.css')}}" rel="stylesheet">

    <link href="{{asset('admins/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{ asset('admins/css/adminstyle.css') }}" rel="stylesheet">

    <link href="{{ asset('plugins/select2/select2.min.css') }}"  rel="stylesheet">
    
    <link href="{{ asset('plugins/summernote/summernote.css') }}"  rel="stylesheet">
    <link href="{{ asset('plugins/summernote/summernote-bs3.css') }}"  rel="stylesheet"> -->


    
    
