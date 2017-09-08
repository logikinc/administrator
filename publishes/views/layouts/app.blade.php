@inject('config', 'scaffold.config')
@inject('module', 'scaffold.module')
@inject('template', 'scaffold.template')
@inject('breadcrumbs', 'scaffold.breadcrumbs')
@inject('navigation', 'scaffold.navigation')
        <!DOCTYPE html>
<html>
<head ng-app="Architector">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>
        {{ strip_tags($config->get('title')) }}
        @if ($module && ($title = $module->title()))
        &raquo; {{ $title }}
        @endif
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

@include('administrator::partials.styles')

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
            display: none !important;
        }
    </style>

    @yield('scaffold.css')

    @yield('scaffold.headjs')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- header logo: style can be found in header.less -->
    <header class="main-header">
        <a href="{{ url(config('administrator.home_page') ?: route('scaffold.dashboard')) }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">
                <img src="{{ asset($config->get('paths.assets') . '/img/logo_50x50.png') }}" alt="">
            </span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">
                <img src="{{ asset($config->get('paths.assets') . '/img/logo_200x50.png') }}" alt="">
            </span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                {{--@include('administrator::partials.badges')--}}
                @include($template->menu('tools'))
            </div>
        </nav>
    </header>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            @include($template->menu('sidebar'))
        </section>
        <!-- /.sidebar -->
    </aside>

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

    <footer class="main-footer">
        @if ($version = $config->get('version'))
            <div class="pull-right hidden-xs">
                <b>Version</b> {{ $version }}
            </div>
        @endif
        <strong>
            Copyright &copy; 2014 - {{ date('Y') }}
            <a href="http://terranet.md" target="_blank">Terranet.md</a>.
        </strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->

@include('administrator::partials.scripts')

@yield('scaffold.js')
</body>
</html>
