<div class="translatable {{ ($locale->id() == $current->id() ? '' : 'hidden') }}" data-locale="{{ $locale->id() }}">
    {!! $input !!}
</div>