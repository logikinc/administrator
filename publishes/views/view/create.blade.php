@if ($actions->authorize('delete', $item))
    <div class="pull-right" style="margin-right: 15px; padding-top: 15px;">
        {!! link_to(route('scaffold.delete', ['module' => $module, 'id' => $item]), trans('administrator::buttons.delete'), ['class' => "btn btn-danger", 'onclick' => "return confirm('Are you sure?')"]) !!}
    </div>
@endif
@if ($actions->authorize('update', $item))
    <div class="pull-right" style="margin-right: 15px; padding-top: 15px;">
        {!! link_to(route('scaffold.edit', ['module' => $module, 'id' => $item]), trans('administrator::buttons.edit'), ['class' => "btn btn-primary"]) !!}
    </div>
@endif
