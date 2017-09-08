@section('scaffold.create')
    @if ($actions->authorize('create'))
        <div class="pull-right" style="margin-right: 15px; padding-top: 15px;">
            {!! link_to(route('scaffold.create', app('scaffold.magnet')->with(['module' => $module])->toArray()), trans('administrator::buttons.create'), ['class' => "btn btn-primary"]) !!}
        </div>
    @endif
@endsection
