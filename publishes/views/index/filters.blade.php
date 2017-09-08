@inject('module', 'scaffold.module')

@section('scaffold.filter')
    <?php
    $resetUrl = method_exists($module, 'defaultRoute') ? $module->defaultRoute() : route('scaffold.index', ['module' => $module]);
    ?>
    @if ($filter && count($elements = $filter->filters()))
        <div class="box-body">
            <form action="" data-id="filter-form" class="form">
                <input type="hidden" name="sort_by" value="{{ $sortable->element() }}"/>
                <input type="hidden" name="sort_dir" value="{{ $sortable->direction() }}"/>
                @if ($scope = $filter->scope())
                    <input type="hidden" name="scoped_to" value="{{ $scope }}"/>
                @endif

                @if ($magnet = app('scaffold.magnet'))
                    @foreach ($magnet->toArray() as $key => $value)
                        @if ($filter->has($key))
                            @continue;
                        @endif
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}"/>
                    @endforeach
                @endif

                <div class="row box-body">
                    <div class="col-md-12 col-lg-10">
                        @foreach($elements as $element)
                            <div class="form-group pull-left" style="width: 250px; margin-right: 20px;">
                                {!! Form::label($element->id(), $element->title()) !!}
                                {!! $element->getInput()->html() !!}
                            </div>
                        @endforeach
                    </div>

                    <div class="col-md-12 col-lg-2">
                        <button type="submit" class="btn btn-app btn-block" style="margin: 0;">
                            <i class="fa fa-search"></i>
                            {{ trans('administrator::buttons.search') }}
                        </button>
                        @if ($resetUrl != request()->fullUrl())
                            <br />
                            <a class="pull-right" href="{{ $resetUrl }}">{{ trans('administrator::buttons.clear_filters') }}</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
@endsection

@section('scaffold.js')
    @include($template->scripts('listeners'))
@stop

@endif
