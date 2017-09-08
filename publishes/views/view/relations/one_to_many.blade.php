@if ($collection->count())
<h3 class="lead">{{ $title }}</h3>
<table class="table">
    <tr>
        @foreach($titles = array_keys(\admin\helpers\eloquent_attributes($collection->first())) as $key)
        <th>{{ \admin\helpers\str_humanize($key) }}</th>
        @endforeach
    </tr>
    @foreach($collection as $item)
    <tr>
        @foreach($titles as $key)
        <td>{!! \admin\helpers\eloquent_attribute($item, $key) !!}</td>
        @endforeach
    </tr>
    @endforeach
</table>
@endif