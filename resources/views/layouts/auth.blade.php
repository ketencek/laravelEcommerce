<!DOCTYPE html>
<html>
<head>
    @include('admin.includes.header')
    @stack('styles')
    <style>

    
    </style>
</head>

<body class="mini-navbar">
    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom admin_navbar">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="javascript:void(0);"><i class="fa fa-bars"></i>  </a>
                        <div class="adminlogo">
                            <a href="{{url('admin')}}">
                                <img src="{{asset('admins/img/v-desk-logo.png')}}">
                                <h1 style="display: inline;vertical-align: middle;color: #2E6A07;">{{ __('admin/general.validi_logo') }}</h1>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        @yield('content')
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="footer">
                        <div>
                            {{ "© ".__("admin/general.copyright")." ".date("Y") }} Validi
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @include('admin.includes.footer')
    
    @stack('scripts')
    @stack('subModule-scripts')
</body>
</html>


