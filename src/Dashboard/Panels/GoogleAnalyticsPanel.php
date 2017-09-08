<?php

namespace Terranet\Administrator\Dashboard\Panels;

use Carbon\Carbon;
use Spatie\Analytics\AnalyticsServiceProvider;
use Spatie\Analytics\Period;
use Terranet\Administrator\Dashboard\DashboardPanel;
use Terranet\Administrator\Traits\Stringify;

class GoogleAnalyticsPanel extends DashboardPanel
{
    use Stringify;

    /**
     * Widget contents
     *
     * @return mixed string|View
     */
    public function render()
    {
        if (!$this->dependencyInstalled()) {
            return $this->abortMessage();
        }

        $period = $this->period();

        $dailyStats = \Analytics::fetchTotalVisitorsAndPageViews($period);


        $visitors = $dailyStats->sum('visitors');
        $pageViews = $dailyStats->sum('pageViews');
        $maxVisitors = $dailyStats->max('visitors');

        $labels = $this->dateLabels($dailyStats);

        return view(app('scaffold.template')->dashboard('google_analytics'))->with(compact(
            'dailyStats', 'labels', 'visitors', 'pageViews', 'maxVisitors'
        ));
    }

    /**
     * @return string
     */
    protected function abortMessage()
    {
        return
            <<<OUT
<h3 class="panel-heading">Google Analytics.</h3>
<div class="panel-body">
    <p class="well">
        Spatie Google Analytics module missing, install it by running:        
        <code>composer require spatie/laravel-analytics</code>.
        <br /><br />
        Then follow the <a href="https://github.com/spatie/laravel-analytics" target="_blank">Setup Instructions</a>.
    </p>
</div>
OUT;
    }

    /**
     * @return bool
     */
    protected function dependencyInstalled()
    {
        return array_has(
            app()->getLoadedProviders(),
            AnalyticsServiceProvider::class
        );
    }

    /**
     * @param $dailyStats
     * @return mixed
     */
    protected function dateLabels($dailyStats)
    {
        return $dailyStats->pluck('date')->map(function (Carbon $carbon) {
            return $carbon->formatLocalized('%a, %e %B %Y');
        })->toArray();
    }

    /**
     * @return Period
     */
    protected function period()
    {
        $end = Carbon::today();
        $start = Carbon::parse($end)->subMonthNoOverflow();

        $period = Period::create($start, $end);

        return $period;
    }
}