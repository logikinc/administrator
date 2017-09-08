@section('scaffold.js')
    <script>
        $(function () {
            $.AdminArchitect.toggleCollection();
            $.AdminArchitect.handleBatchActions();
        });
    </script>
@append
