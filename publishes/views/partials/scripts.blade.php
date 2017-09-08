<script src="{{ asset($config->get('paths.assets') . '/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<script src="{{ asset($config->get('paths.assets') . '/plugins/jQueryUi/jquery-ui.min.js') }}"></script>
<script src="{{ asset($config->get('paths.assets') . '/plugins/jQueryUi/nested-sortable.js') }}"></script>
<script src="{{ asset($config->get('paths.assets') . '/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset($config->get('paths.assets') . '/plugins/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset($config->get('paths.assets') . '/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset($config->get('paths.assets') . '/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset($config->get('paths.assets') . '/plugins/selectize/js/standalone/selectize.js') }}"></script>
@if ('en' !== config('app.locale'))
    <script src="{{ asset($config->get('paths.assets') . '/plugins/datepicker/locales/bootstrap-datepicker.'.config("app.locale").'.js') }}"></script>
@endif
<script type="text/javascript" src="{{ asset($config->get('paths.assets') . '/plugins/fancybox/source/jquery.fancybox.pack.js?v=2.1.5') }}"></script>
<script src="{{ asset($config->get('paths.assets') . '/js/app.js') }}"></script>
<script src="{{ asset($config->get('paths.assets') . '/js/scripts.js') }}"></script>

<script src="{{ asset($config->get('paths.assets') . '/plugins/angular/angular.js') }}"></script>
<script src="{{ asset($config->get('paths.assets') . '/plugins/angular/angular-cookies.js') }}"></script>
<script src="{{ asset($config->get('paths.assets') . '/plugins/angular/angular-sanitize.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-file-upload/2.5.0/angular-file-upload.js"></script>

<?php
$files = array_merge(
    [
        $config->get('paths.assets') . '/js/angular/app.js',
        $config->get('paths.assets') . '/js/angular/helpers.js',
        $config->get('paths.assets') . '/js/angular/templates.js',
    ],
    glob($config->get('paths.assets') . '/js/angular/services/*.js'),
    glob($config->get('paths.assets') . '/js/angular/filters/*.js'),
    glob($config->get('paths.assets') . '/js/angular/directives/*.js'),
    glob($config->get('paths.assets') . '/js/angular/controllers/*.js')
);
?>
@foreach($files as $file)
    <script src="{{ asset($file) }}?{{ filemtime($file) }}"></script>
@endforeach