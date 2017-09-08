<tr>
    <td colspan="2" class="text-center">
        <input type="submit" name="save"        value="{{ trans('administrator::buttons.save') }}" class="btn btn-primary" />
        <input type="submit" name="save_return" value="{{ trans('administrator::buttons.save_return') }}" class="btn btn-primary" />
        @if ($actions->authorize('create'))
            <input type="submit" name="save_create" value="{{ trans('administrator::buttons.save_create') }}" class="btn btn-primary " />
        @endif
    </td>
</tr>
