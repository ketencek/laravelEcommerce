<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//TR" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="tr" xml:lang="tr">

<head>
    <meta name="language" content="tr" />
    <title> Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!--<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">-->
    <?php //  include_partial('global/favicon'); 
    ?>
    <link rel='stylesheet' href='{{ asset("admins/css/layout.min.css")}}' type='text/css' media='all' />
    @stack('styles')

    <link rel='dns-prefetch' href='//fonts.googleapis.com' />
    <link rel='stylesheet' href='{{ asset("admins/css/style.min.css")}}' type='text/css' media='all' />
    <script type="text/javascript" src="{{ asset('admins/js/jq-bt.min.js')}}"></script>

    <script type="text/javascript">
        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        function setCookie(name, value, expirydays) {
            var d = new Date();
            d.setTime(d.getTime() + (expirydays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = name + "=" + value + "; " + expires + ";path=/";
        }
    </script>
</head>

<?php $shrink = (isset($_COOKIE['leftpanel_shrink']) && $_COOKIE['leftpanel_shrink'] == 'yes') ? "shrink_panel" : "" ?>

<body class="left_panel loading_smooth <?php echo $shrink ?>">
    @include('admin.includes.sidebar')

    <div class="admin_panel_body">
    <div class="language_type hide">{{ config('settingconfig.admin_default_language') }}</div>
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
    @include('admin.includes.footer')
    <script>
        var language_date_format = "{{(session('date_format')=='m-d-Y'?'mm-dd-yyyy':'dd-mm-yyyy')}}";
    </script>

    @stack('scripts')
    @stack('subModule-scripts')
    @stack('subscript')
    <script src="{{ asset('admins/js/script.min.js') }}"></script>
    <script>
        @if(session('success'))
            notify('{{ session("success") }}', 'success')
        @endif
    </script>
</body>

</html>