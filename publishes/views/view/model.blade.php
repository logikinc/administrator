@inject('module', 'scaffold.module')

@if (isset($title))
    <h3 class="lead">{{ $title }}</h3>
@endif

<div class="box no-border">
    <div class="box-body no-padding">
        <table class="table table-striped">
            @foreach($module->viewColumns($item) as $element)
                @if ($element instanceof \Terranet\Administrator\Form\FormSection)
                  <tr>
                      <td colspan="2" class="bg-gray">{{ $element->title() }}</td>
                  </tr>
                @else
                    @if (! (is_array($value = $element->render($item)) || is_object($value)))
                        <tr>
                            <th style="width: 20%; min-width: 200px;">{{ $element->title() }}</th>
                            <td>{!! $value !!}</td>
                        </tr>
                    @endif
                @endif
            @endforeach
        </table>
    </div>
</div>