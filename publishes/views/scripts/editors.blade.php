@inject('form', 'scaffold.form')
@inject('config', 'scaffold.config')

<script>
    var Editors = {};
    Editors.init = {
        ckeditor : function() {
            $('[data-editor="ckeditor"]').ckeditor();
        },
        tinymce: function() {
            tinymce.init({
                selector: 'textarea[data-editor="tinymce"]',
                plugins: [
                    "advlist autolink lists link image charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste" // @excluded: "moxiemanager"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
            });
        }
    };
</script>

@if($form->hasEditors('ckeditor'))
    <script type="text/javascript" src="{{ asset($config->get('paths.assets') . '/plugins/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset($config->get('paths.assets') . '/plugins/ckeditor/adapters/jquery.js') }}"></script>
    <script>Editors.init.ckeditor();</script>
@endif

@if ($form->hasEditors('tinymce'))
    <script type="text/javascript" src="{{ asset($config->get('paths.assets') . '/plugins/tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset($config->get('paths.assets') . '/plugins/tinymce/jquery.tinymce.min.js') }}"></script>
    <script>Editors.init.tinymce();</script>
@endif
