@inject('form', 'scaffold.form')
@inject('module', 'scaffold.module')
@inject('actions', 'scaffold.actions')
@inject('template', 'scaffold.template')

@extends($template->layout())

@section('scaffold.create')
    @include($template->edit('create'))
@endsection

@section('scaffold.content')
    {!! Form::model(isset($item) ? $item : null, ['method' => 'post', 'files' => true]) !!}
    <table class="table">
        @each($template->edit('row'), $form, 'field')

        @include($template->edit('actions'))
    </table>
    {!! Form::close() !!}
@stop

@include($template->edit('scripts'))
