<h1>{{ $module->title() }} @yield('total')</h1>

@if ($breadcrumbs)
    {!! $breadcrumbs->render() !!}
@endif
