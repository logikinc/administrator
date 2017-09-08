@inject('config', 'scaffold.config')
@inject('template', 'scaffold.template')
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ strip_tags($config->get('title')) }} &raquo; {{ trans('administrator::module.login') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset($config->get('paths.assets') . '/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
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
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            {!! $config->get('title') !!}
        </div><!-- /.login-logo -->


        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>

            @include($template->partials('messages'))

            {!! Form::open() !!}
                <div class="form-group has-feedback">
                    {!! Form::text($identity = $config->get('auth.identity', 'username'), null, ['class' => 'form-control', 'placeholder' => trans('administrator::module.credentials.' . $identity)]) !!}
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    {!! Form::password($credential = $config->get('auth.credential', 'password'), ['class' => 'form-control', 'placeholder' => trans('administrator::module.credentials.' . $credential)]) !!}
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input name="remember_me" type="hidden" value="0" />
                                <input type="checkbox" name="remember_me" value="1" /> {{ trans('administrator::buttons.remember_me') }}
                            </label>
                        </div>
                    </div><!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('administrator::buttons.sign_in') }}</button>
                    </div><!-- /.col -->
                </div>
            {!! Form::close() !!}
        </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="{{ asset($config->get('paths.assets') . '/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{ asset($config->get('paths.assets') . '/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset($config->get('paths.assets') . '/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>
</html>
