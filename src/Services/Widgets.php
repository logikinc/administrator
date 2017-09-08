<?php

namespace Terranet\Administrator\Services;

use Terranet\Administrator\Contracts\Services\Widgetable;
use Terranet\Administrator\Services\Widgets\EloquentWidget;

class Widgets
{
    /**
     * @var array
     */
    protected $widgets;

    protected $tab;

    protected $placement;

    /**
     * Widget constructor.
     *
     * @param array $widgets
     */
    public function __construct(array $widgets = [])
    {
        $this->widgets = $widgets;
    }

    public function setTab($tab)
    {
        $this->tab = $tab;

        return $this;
    }

    public function setPlacement($placement)
    {
        $this->placement = $placement;

        return $this;
    }

    public function add(Widgetable $widget)
    {
        array_push($this->widgets, $widget);

        return $this;
    }

    /**
     * Fetch widgets
     *
     * @return array
     */
    public function filter()
    {
        $widgets = $this->applyFilters();

        usort($widgets, function ($w1, $w2) {
            return $w1->getOrder() < $w2->getOrder() ? -1 : 1;
        });

        return $widgets;
    }

    protected function applyFilters()
    {
        return array_filter($this->widgets, function ($widget) {
            return ($widget->getPlacement() == $this->placement && $widget->getTab() == $this->tab);
        });
    }

    public function tabs()
    {
        // eloquent tab should be always first
        $this->sortTabs();

        return array_build($this->widgets, function ($i, $widget) {
            return [str_slug($tab = $widget->getTab()), $tab];
        });
    }

    private function sortTabs()
    {
        usort($this->widgets, function ($a, $b) {
            if ($a instanceof EloquentWidget) {
                return -1;
            }

            if ($b instanceof EloquentWidget) {
                return -1;
            }

            return $a->getTab() < $b->getTab() ? -1 : 1;
        });
    }
}
