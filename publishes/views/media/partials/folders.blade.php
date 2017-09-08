<div class="box box-primary" ng-show="!selection.exists() && directories.length">
    <div class="box-header">
        <h3 class="box-title">{{ trans('administrator::media.folders') }}</h3>
    </div>
    <div class="box-body box-profile">
        <ul class="list-unstyled">
            <li ng-repeat="dir in directories" ng-if="dir">
                <a ng-if="dir !== '../'" class="pull-right" ng-click="remove(dir)"><i class="fa fa-trash"></i></a>
                <div class="pull-left">
                    <i class="fa fa-folder-open-o"></i>
                    <a style="margin-left: 10px; cursor: pointer;" ng-if="dir" ng-click="open(dir)">@{{ dir.filename || dir }}</a>
                </div>
                <div class="clearfix"></div>
            </li>
        </ul>
    </div>
</div>