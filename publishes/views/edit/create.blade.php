@if (isset($item))
    @if ($actions->authorize('delete', $item))
        <div class="pull-right" style="margin-right: 15px; padding-top: 15px;">
            {!! link_to(route('scaffold.delete', ['module' => $module, 'id' => $item]), trans('administrator::buttons.delete'), ['class' => "btn btn-danger", 'onclick' => "return confirm('Are you sure?')"]) !!}
        </div>
    @endif
    @if ($actions->authorize('create'))
        <div class="pull-right" style="margin-right: 15px; padding-top: 15px;">
            {!! link_to(route('scaffold.create', ['module' => $module]), trans('administrator::buttons.create'), ['class' => "btn btn-warning"]) !!}
        </div>
    @endif
    @if ($actions->authorize('view', $item))
        <div class="pull-right" style="margin-right: 15px; padding-top: 15px;">
            {!! link_to(route('scaffold.view', ['module' => $module, 'id' => $item]), trans('administrator::buttons.view'), ['class' => "btn btn-primary"]) !!}
        </div>
    @endif
@endif
