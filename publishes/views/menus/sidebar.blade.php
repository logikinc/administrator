<?php
$user = auth('admin')->user();
$pict = asset($config->get('paths.assets') . '/img/admin.png');
?>

<div class="user-panel">
    <div class="pull-left image">
        @if (app('scaffold.config')->get('gravatar', true) && Gravatar::exists($user->email))
            <img src="{{ Gravatar::get($user->email, ['size' => 160, 'fallback' => $pict]) }}"
                 alt="{{ $user->name }}" class="img-circle" />
        @else
            <img src="{{ $pict }}" class="img-circle" alt="{{ $user->name }}">
        @endif
    </div>
    <div class="pull-left info">
        <p>{{ $user->name }}</p>
        <i class="fa fa-circle text-success"></i> Online
    </div>
</div>

<form action="#" method="get" class="sidebar-form">
    <div class="input-group">
        <input type="text" id="q" name="q" class="form-control" placeholder="Search..."/>
        <span class="input-group-btn">
            <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
        </span>
    </div>
</form>

{!! $navigation->render('sidebar', '\Terranet\Administrator\Navigation\Presenters\Bootstrap\SidebarMenuPresenter') !!}

@section('scaffold.js')
    <script>
        // implement search feature
    </script>
@append
