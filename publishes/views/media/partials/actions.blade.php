<div class="box-tools pull-right">
    <button type="button" class="btn btn-box-tool text-black" ng-click="upload()">
        <i class="fa fa-upload"></i>&nbsp;{{ trans('administrator::media.buttons.upload') }}
    </button>
    <button type="button" class="btn btn-box-tool text-black" data-toggle="modal" data-target="#mkdir">
        <i class="fa fa-folder"></i>&nbsp;{{ trans('administrator::media.buttons.mkdir') }}
    </button>

    <span ng-if="selection.exists()">
        <small class="text-muted">&nbsp;|&nbsp;</small>

        <button type="button" class="btn btn-box-tool text-black" data-toggle="modal" data-target="#move">
            <i class="fa fa-share"></i>&nbsp;{{ trans('administrator::media.buttons.move') }}
        </button>

        <button type="button" class="btn btn-box-tool text-black" data-toggle="modal" data-target="#rename" ng-if="1 === selection.count()">
            <i class="fa fa-i-cursor"></i>&nbsp;{{ trans('administrator::media.buttons.rename') }}
        </button>

        <button type="button" class="btn btn-box-tool text-black" ng-click="remove()">
            <i class="fa fa-trash"></i>&nbsp;{{ trans('administrator::media.buttons.delete') }}
        </button>
    </span>
</div>