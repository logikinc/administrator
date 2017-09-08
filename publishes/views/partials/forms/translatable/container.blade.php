<div class="translatable-block">
    <div class="translatable-items pull-left" style="width: 80%; margin-right: 20px;">
        @foreach($inputs as $input)
            {!! $input !!}
        @endforeach
    </div>
    <div class="box-tools pull-left locale-switcher" data-toggle="tooltip" data-original-title="Switch locale">
        <div class="btn-group" data-toggle="btn-toggle">
        @foreach(\localizer\locales() as $locale)
            <button type="button"
                    class="btn btn-default btn-sm {{ ($locale->id() == $current->id() ? 'active' : '') }}"
                    data-locale="{{ $locale->id() }}">
                {{ $locale->iso6391() }}
            </button>
        @endforeach
        </div>
    </div>
    <div class="clearfix"></div>
</div>