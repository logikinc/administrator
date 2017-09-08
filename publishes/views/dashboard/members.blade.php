<h3 class="panel-heading">{{ trans('administrator::dashboard.members.header') }}</h3>

<div class="panel-body">
    <table class="table table-striped">
        <tr>
            <th align="right">{{ trans('administrator::dashboard.members.header_total') }}:</th>
            <td width="20%">{{ $total }}</td>
        </tr>
        <tr>
            <th align="right">{{ trans('administrator::dashboard.members.header_signed_last_week') }}:</th>
            <td width="20%">{{ $signed['lastWeek'] }}</td>
        </tr>
        <tr>
            <th align="right">{{ trans('administrator::dashboard.members.header_signed_last_month') }}:</th>
            <td width="20%">{{ $signed['lastMonth'] }}</td>
        </tr>
    </table>
</div>

<h3 class="panel-heading">{{ trans('administrator::dashboard.members.header_members_per_day') }}</h3>
<div class="panel-body">
    <table class="table bordered">
        @foreach($signedStatistics as $date => $count)
            <tr>
                <td>{{ $date }}</td>
                <td width="20%">{{ $count }}</td>
            </tr>
        @endforeach
    </table>
</div>
