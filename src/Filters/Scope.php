<?php

namespace Terranet\Administrator\Filters;

use Terranet\Administrator\Traits\Collection\ElementContainer;

class Scope extends ElementContainer
{
    protected $query;


    /**
     * @param mixed $query
     * @return $this
     */
    public function setQuery(callable $query = null)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return string
     */
    public function translationKey()
    {
        $key = sprintf('administrator::scopes.%s.%s', $this->module()->url(), $this->id);

        if (!$this->translator()->has($key)) {
            $key = sprintf('administrator::scopes.%s.%s', 'global', $this->id);
        }

        return $key;
    }
}