@inject('columns', 'scaffold.columns')
@inject('sortable', 'scaffold.sortable')

<th style="text-wrap: none; {{ ('id' == strtolower($column->id()) ? 'width: 50px;' : '') }}; vertical-align: top">
    @if ($sortable->canSortBy($column->id()))
        <a href="{{ $sortable->makeUrl($column->id()) }}">
            {{ $column->title() }}{!! ($sortable->element() == $column->id() ? ('asc' == $sortable->direction() ? '&uparrow;' : '&downarrow;') : '') !!}
        </a>
    @else
        {{ $column->title() }}
    @endif
</th>
