<!-- Validation errors -->
@if (isset($errors) && $errors->count())
    @foreach($errors->all() as $error)
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ $error }}
    </div>
    @endforeach
@endif

<!-- Success messages -->
@if (Session::has('messages'))
    @foreach(Session::get('messages') as $message)
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ $message }}
        </div>
    @endforeach
@endif
