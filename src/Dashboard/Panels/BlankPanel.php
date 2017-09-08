<?php

namespace Terranet\Administrator\Dashboard\Panels;

use Terranet\Administrator\Dashboard\DashboardPanel;
use Terranet\Administrator\Traits\Stringify;

class BlankPanel extends DashboardPanel
{
    use Stringify;

    /**
     * Widget contents
     *
     * @return mixed
     */
    public function render()
    {
        return
        <<<OUT
            <h3 class="panel-heading">Welcome to Terranet/Administrator.</h3>
            <div class="panel-body">
                <p class="well">
                    This is the default dashboard page.
                    To add dashboard sections, checkout 'administrator::layouts/dashboard.blade.php'.
                </p>
            </div>
OUT;
    }
}
