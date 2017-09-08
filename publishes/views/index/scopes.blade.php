@if (count($scopes = $filter->scopes()))
    <div class="pull-left">
        @foreach($scopes as $scope)
            {!! link_to($filter->makeScopedUrl($slug = $scope->id()), $scope->title(), [
                'class' => 'btn btn-link',
                'style' => ($filter->scope() == $slug ? 'color: black' : '')
            ]) !!}
        @endforeach
    </div>
@endif
