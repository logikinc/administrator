@if (! empty($errors))
<ul class="errors">
    @foreach($errors as $error)
        <li>{{ $error }}</li>
    @endforeach
</ul>
@endif