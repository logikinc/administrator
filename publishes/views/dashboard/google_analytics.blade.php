<div class="box no-border">
    <div class="box-header">
        <h3 class="less">Audience Overview &raquo; Last Month</h3>
    </div>
    <div class="box-body">
        <div class="col-xs-10">
            <canvas id="dailyStats-chart" style="width: auto;"></canvas>
        </div>
        <div class="col-xs-2">
            <div class="pad box-pane-right bg-blue">
                <div class="description-block margin-bottom">
                    <div class="sparkbar pad" data-color="#fff">
                        <i class="ion ion-person-stalker" style="font-size: 34px;"></i>
                    </div>
                    <h5 class="description-header">{{ $visitors }}</h5>
                    <span class="description-text">Visitors</span>
                </div>
                <div class="description-block margin-bottom">
                    <div class="sparkbar pad" data-color="#fff">
                        <i class="ion ion-eye" style="font-size: 34px;"></i>
                    </div>
                    <h5 class="description-header">{{ $pageViews }}</h5>
                    <span class="description-text">Page views</span>
                </div>
                <div class="description-block">
                    <div class="sparkbar pad" data-color="#fff">
                        <i class="ion ion-arrow-graph-up-right" style="font-size: 34px;"></i>
                    </div>
                    <h5 class="description-header">{{ $maxVisitors }}</h5>
                    <span class="description-text">Max visitors / Day</span>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scaffold.js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script>
        $(function () {
            var data = {
                labels: ['{!! implode("', '", $labels) !!}'],
                datasets: [
                    {
                        label: 'Visitors',
                        backgroundColor: "rgba(60,141,188,0.4)",
                        borderColor: "rgba(60,141,188,1)",
                        borderWidth: 1,
                        pointRadius: 1,
                        data: [ {!! join(', ', $dailyStats->pluck('visitors')->toArray()) !!} ]
                    },
                    {
                        label: 'Page Views',
                        backgroundColor: "rgba(34,45,50,0.4)",
                        borderColor: "rgba(34,45,50,1)",
                        borderWidth: 1,
                        pointRadius: 1,
                        data: [ {!! join(', ', $dailyStats->pluck('pageViews')->toArray()) !!} ]
                    }
                ]
            };

            new Chart($("#dailyStats-chart"), {
                type: 'line',
                data: data,
                options: {
                    legend: {
                        display: false
                    },
                    scales: {
                        xAxes: [{
                            type: 'time'
                        }]
                    }
                }
            });
        })
    </script>
@append