@inject('template', 'scaffold.template')
@inject('module', 'scaffold.module')
@inject('actions', 'scaffold.actions')
@inject('widgets', 'scaffold.widget')

@extends($template->layout())

@section('scaffold.create')
    @include($template->view('create'))
@endsection

@section('scaffold.content')
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            @foreach($tabs = $widgets->tabs() as $slug => $tabTitle)
            <li role="presentation">
                <a href="#tab_{{ $slug }}" aria-controls="tab_{{ $slug }}" role="tab" data-toggle="tab">{{ $tabTitle }}</a>
            </li>
            @endforeach
        </ul>

        <div class="tab-content">
            @foreach($tabs as $slug => $tabTitle)
            <div role="tabpanel" class="tab-pane" id="tab_{{ $slug }}">
                <?php $widgets->setTab($tabTitle); ?>

                @foreach ($widgets->setPlacement('main-top')->filter() as $widget)
                    <div class="row no-margin">
                        <div class="col-lg-12">
                            {!! $widget->render() !!}
                        </div>
                    </div>
                @endforeach

                <div class="row no-margin">
                    <?php $sideWidgets = $widgets->setPlacement('sidebar')->filter() ?>

                    <div class="col-lg-{{ $sideWidgets ? 8 : 12 }}">
                        @foreach ($widgets->setPlacement('model')->filter() as $widget)
                            <div class="row no-margin">
                                {!! $widget->render() !!}
                            </div>
                        @endforeach
                    </div>

                    @if ($sideWidgets)
                        <div class="col-lg-4">
                            @foreach($sideWidgets as $widget)
                                <div class="widget">
                                    {!! $widget->render() !!}
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                @foreach ($widgets->setPlacement('main-bottom')->filter() as $widget)
                    <div class="row no-margin">
                        <div class="col-lg-12">
                            {!! $widget->render() !!}
                        </div>
                    </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
@append

@section('scaffold.js')
    <script>
        $(function () {
            var hash;
            var tabs = ['{!! join("', '", array_keys($tabs)) !!}'].map(function(tab) {
                return '#tab_' + tab;
            });
            if ((hash = location.hash) && tabs.indexOf(hash) != -1) {
                $('.nav-tabs a[href="' + hash + '"]').tab('show');
            } else {
                $('.nav-tabs a:first').tab('show');
            }
        })
    </script>
@append