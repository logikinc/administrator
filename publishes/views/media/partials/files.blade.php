<div class="box-body media-list" id="media-library">
    <div ng-if="!files.length" class="text-center">
        <h4>{{ trans('administrator::media.no_files_found') }}</h4>
    </div>
    <div class="item text-muted"
         ng-class="{'selected': selection.has(file)}"
         ng-repeat="file in files"
         ng-click="selection.toggle(file, $event)" ng-dblclick="open(file)"
    >
        <div class="icon">
            <i class="@{{ file.icon }}"></i>
        </div>
        <div class="details">
            <h4>@{{ file.basename }}</h4>
            <small ng-if="file.isFile">
                <span class="file_size">@{{ file.size }} Bytes</span>
            </small>
        </div>
    </div>
</div>