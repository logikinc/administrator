<div class="box box-primary" ng-show="selection.exists() && !selection.multiple()">
    <div class="box-header">
        <h3 class="box-title">{{ trans('administrator::media.file_info') }}</h3>
    </div>

    <div class="box-body">
        <div style="display:flex; flex-direction: row; justify-content: center; align-items: flex-start;">
            <img class="img-responsive" ng-src="@{{ selection.info('url') }}" ng-if="selection.info('isImage')"/>
        </div>

        <h3 class="profile-username text-center">
            <div ng-if="!selection.info('isImage')">
                <i class="@{{ selection.info('icon') }}" style="font-size:3em;"></i>
                <br/><br/>
            </div>
            @{{ selection.info('basename') }}
        </h3>

        <ul class="list-group list-group-unbordered media-file-info">
            <li class="list-group-item">
                <b>{{ trans('administrator::media.info.url') }}</b>
                <a target="_blank" class="pull-right" ng-href="@{{ selection.info('url') }}">download</a>
            </li>
            <li class="list-group-item">
                <b>{{ trans('administrator::media.info.size') }}</b>
                <span class="pull-right">@{{ selection.info('size') }}</span>
            </li>
            <li class="list-group-item">
                <b>{{ trans('administrator::media.info.created_at') }}</b>
                <span class="pull-right">
                <span class="label label-primary">@{{ selection.info('createdAt') }}</span>
            </span>
            </li>
            <li class="list-group-item">
                <b>{{ trans('administrator::media.info.updated_at') }}</b>
                <span class="pull-right">
                    <small class="label label-primary">@{{ selection.info('updatedAt') }}</small>
                </span>
            </li>
        </ul>
    </div>
</div>