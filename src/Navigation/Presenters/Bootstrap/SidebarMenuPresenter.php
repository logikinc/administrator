<?php

namespace Terranet\Administrator\Navigation\Presenters\Bootstrap;

use Pingpong\Menus\Presenters\Presenter;

class SidebarMenuPresenter extends Presenter
{
    /**
     * Get open tag wrapper.
     *
     * @return string
     */
    public function getOpenTagWrapper()
    {
        return '<ul class="sidebar-menu">';
    }

    /**
     * Get close tag wrapper.
     *
     * @return string
     */
    public function getCloseTagWrapper()
    {
        return '</ul>';
    }

    /**
     * Get menu tag without dropdown wrapper.
     *
     * @param \Pingpong\Menus\MenuItem $item
     *
     * @return string
     */
    public function getMenuWithoutDropdownWrapper($item)
    {
        if (!$item->getChilds() && array_key_exists('dropdown', $item->getProperties())) {
            return '';
        }

        $item = $this->handleItemsCount($item);

        return '<li' . $this->getActiveState($item) . '>' .
            '<a href="' . $item->getUrl() . '" ' . $item->getAttributes() . '>' .
            $item->getIcon() . ' <span>' . $item->title . '</span>' .
            '</a>' .
            '</li>' . PHP_EOL;
    }

    /**
     * {@inheritdoc}.
     */
    public function getActiveState($item, $state = ' class="active"')
    {
        return $item->isActive() ? $state : null;
    }

    /**
     * {@inheritdoc}.
     */
    public function getDividerWrapper()
    {
        return '<li class="divider"></li>';
    }

    /**
     * {@inheritdoc}.
     */
    public function getHeaderWrapper($item)
    {
        return '<li class="dropdown-header">' . $item->title . '</li>';
    }

    /**
     * Get multilevel menu wrapper.
     *
     * @param \Pingpong\Menus\MenuItem $item
     *
     * @return string`
     */
    public function getMultiLevelDropdownWrapper($item)
    {
        return $this->getMenuWithDropDownWrapper($item);
    }

    /**
     * {@inheritdoc}.
     */
    public function getMenuWithDropDownWrapper($item)
    {
        $key = str_random();

        return '
		<li class="' . $this->getActiveStateOnChild($item) . ' treeview">
			<a href="#' . $key . '">
				' . $item->getIcon() . ' <span>' . $item->title . '</span> <i class="fa fa-angle-left pull-right"></i>
			</a>
            <ul class="treeview-menu">
                ' . $this->getChildMenuItems($item) . '
            </ul>
		</li>
		' . PHP_EOL;
    }

    /**
     * Get active state on child items.
     *
     * @param        $item
     * @param string $state
     *
     * @return null|string
     */
    public function getActiveStateOnChild($item, $state = 'active')
    {
        return $item->hasActiveOnChild() ? $state : null;
    }

    /**
     * Appends Items count to a title if needed.
     *
     * @param $item
     */
    protected function handleItemsCount($item)
    {
        if ($item->route
            && 'scaffold.index' === array_get($item->route, 0)
            && $module = array_get($item->route, '1.module')
        ) {
            $module = app('scaffold.module.' . $module);

            if ($count = $module->appendCount()) {
                $item->title .= ' (' . $count . ')';
            }
        }

        return $item;
    }
}
