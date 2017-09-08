@inject('config', 'scaffold.config')
@inject('module', 'scaffold.module')
@inject('template', 'scaffold.template')
@inject('breadcrumbs', 'scaffold.breadcrumbs')
@inject('navigation', 'scaffold.navigation')
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ strip_tags($config->get('title')) }}
    @if ($module && ($title = $module->title()))
        &raquo; {{ $title }}
    @endif
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset($config->get('paths.assets') . '/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- date picker -->
    <link rel="stylesheet" href="{{ asset($config->get('paths.assets') . '/plugins/datepicker/datepicker3.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet"
          href="{{ asset($config->get('paths.assets') . '/plugins/daterangepicker/daterangepicker-bs3.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset($config->get('paths.assets') . '/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="{{ asset($config->get('paths.assets') . '/css/skins/skin-blue.min.css') }}">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset($config->get('paths.assets') . '/plugins/iCheck/square/blue.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="{{ asset($config->get('paths.assets') . '/plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') }}" type="text/css" media="screen" />

    <style>
        [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
            display: none !important;
        }
    </style>

    @yield('scaffold.headjs')
</head>
<body class="skin-blue layout-top-nav">
<div class="wrapper">
    <!-- Right side column. Contains the navbar and content of the page -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @if ($module)
            <section class="content-header">
                @yield('scaffold.create')

                <div style="float:none; clear: left;">
                    @include($template->partials('breadcrumbs'))
                </div>

            </section>
            @endif

            @include($template->partials('messages'))

                    <!-- Main content -->
            <section class="content">

                <div class="box">
                    @yield('scaffold.filter')

                    <div class="box-body">
                        @yield('scaffold.content')
                    </div>

                    <div class="box-footer">
                        @yield('scaffold.content-footer')
                    </div>
                </div>
                <!-- /.box -->
            </section><!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="{{ asset($config->get('paths.assets') . '/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{ asset($config->get('paths.assets') . '/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
{{--<script src="{{ asset($config->get('paths.assets') . '/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>--}}
{{--<!-- FastClick -->--}}
{{--<script src="{{ asset($config->get('paths.assets') . '/plugins/fastclick/fastclick.min.js') }}"></script>--}}
<!-- date-range-picker -->
<script src="{{ asset($config->get('paths.assets') . '/plugins/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset($config->get('paths.assets') . '/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- date-picker -->
<script src="{{ asset($config->get('paths.assets') . '/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
@if ('en' !== config('app.locale'))
<script src="{{ asset($config->get('paths.assets') . '/plugins/datepicker/locales/bootstrap-datepicker.'.config("app.locale").'.js') }}"></script>
@endif
<!-- AdminLTE App -->
<script src="{{ asset($config->get('paths.assets') . '/js/app.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
@append

@yield('scaffold.js')
</body>
</html>
