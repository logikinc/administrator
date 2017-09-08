@inject('template', 'scaffold.template')
@inject('config', 'scaffold.config')

@extends($template->layout())

@section('scaffold.content')
    <script>
        window.mediaFiles = {!! json_encode($files) !!};
        window.XSRF_TOKEN = '{{ csrf_token() }}';
        window.UPLOADER_URL = '{{ route('scaffold.media.upload') }}';
        window.REQUEST_PATH = '{{ request('path', '') }}';
    </script>
    <div ng-controller="MediaController" ng-cloak>
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('administrator::media.title') }}</h3>
            @include('administrator::media.partials.actions')

            <div style="margin-top: 20px;">
                {!! $breadcrumbs !!}
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-9">
                    <div class="box box-primary">
                        @include('administrator::media.partials.files')

                        <div class="box-footer text-muted">
                            <i class="fa fa-info-circle"></i>&nbsp;
                            {{ trans('administrator::media.multiple_files_note') }}
                        </div>
                    </div>
                </div>

                <div class="col-xs-3">
                    @include('administrator::media.partials.folders')
                    @include('administrator::media.partials.dropzone')
                    @include('administrator::media.partials.file_info')
                </div>
            </div>
        </div>

        @include('administrator::media.partials.modals.mkdir')
        @include('administrator::media.partials.modals.rename')
        @include('administrator::media.partials.modals.move')
    </div>
@append
