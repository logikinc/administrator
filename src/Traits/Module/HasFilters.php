<?php

namespace Terranet\Administrator\Traits\Module;

use function admin\db\table_columns;
use function admin\db\table_indexes;
use Terranet\Administrator\Filters\FilterElement;
use Terranet\Administrator\Filters\Scope;
use Terranet\Administrator\Form\Collection\Mutable;
use Terranet\Administrator\Filters\InputFactory as FilterInputFactory;

trait HasFilters
{
    /**
     * Defined filters
     *
     * @var Mutable
     */
    protected $filters;

    /**
     * Defined scopes
     *
     * @var Mutable
     */
    protected $scopes;

    /**
     * Register a filter.
     *
     * @param FilterElement $filter
     * @return $this
     */
    public function addFilter(FilterElement $filter)
    {
        $this->filters->push($filter);

        return $this;
    }

    /**
     * Register a scope.
     *
     * @param Scope $scope
     * @return $this
     */
    public function addScope(Scope $scope)
    {
        $this->scopes->push($scope);

        return $this;
    }

    /**
     * Default list of filters
     *
     * @return mixed
     */
    public function filters()
    {
        return $this->scaffoldFilters();
    }

    /**
     * Default list of scopes
     */
    public function scopes()
    {
        return $this->scaffoldScopes();
    }

    protected function scaffoldFilters()
    {
        $this->filters = new Mutable;

        $columns = table_columns($this->model());
        $indexes = table_indexes($this->model());

        foreach ($indexes as $column) {
            $data = $columns[$column];

            switch (class_basename($data->getType())) {
                case 'StringType':
                    $this->addFilter(
                        $this->filterFactory($column, 'text')
                    );
                    break;

                case 'DateTimeType':
                    $this->addFilter(
                        $this->filterFactory($column, 'daterange')
                    );
                    break;

                case 'BooleanType':
                    $this->addFilter(
                        $this->filterFactory(
                            $column, 'select', '',
                            [
                                '' => '--Any--',
                                1 => 'Yes',
                                0 => 'No',
                            ])
                    );
                    break;
            }
        }

        return $this->filters;
    }

    /**
     * Find all public scopes in current model
     *
     * @return Mutable
     */
    protected function scaffoldScopes()
    {
        $this->scopes = new Mutable;

        if ($model = $this->model()) {
            $this->fetchModelScopes($model);

            $this->addSoftDeletesScopes($model);
        }

        return $this->scopes;
    }

    protected function filterFactory($name, $type = 'text', $label = '', array $options = [], callable $query = null)
    {
        $element = FilterElement::$type($name);

        $input = FilterInputFactory::make($name, $type);

        if (!is_null($query)) {
            $input->setQuery($query);
        }

        if ('select' == $type && is_array($options)) {
            $input->setOptions($options);
        }

        return $element->setInput($input);
    }

    /**
     * Parse the model for scopes
     *
     * @param $model
     */
    protected function fetchModelScopes($model)
    {
        $reflection = new \ReflectionClass($model);

        foreach ($reflection->getMethods() as $method) {
            if (preg_match('~^scope(.+)$~i', $method->name, $match)) {

                if ($this->isHiddenScope($name = $match[1])
                    || $this->isDynamicScope($method)
                    || $this->hasHiddenFlag($method->getDocComment())
                ) {
                    continue;
                }

                $scope = with(new Scope($name))->setQuery([$model, $name]);

                $this->addScope($scope);
            }
        }
    }

    /**
     * @param $method
     * @return int
     */
    protected function isDynamicScope($method)
    {
        return count($method->getParameters()) > 1;
    }

    /**
     * Exists in user-defined hiddenScopes property
     *
     * @param $name
     * @return bool
     */
    protected function isHiddenScope($name)
    {
        return property_exists($this, 'hiddenScopes') && in_array($name, $this->hiddenScopes);
    }

    /**
     * Marked with @hidden flag
     *
     * @param $docBlock
     * @return int
     */
    protected function hasHiddenFlag($docBlock)
    {
        return preg_match('~\@hidden~si', $docBlock);
    }

    /**
     * Add SoftDeletes scopes if model uses that trait
     *
     * @param $model
     */
    protected function addSoftDeletesScopes($model)
    {
        if (array_key_exists('Illuminate\Database\Eloquent\SoftDeletes', class_uses($model))) {
            foreach ($this->softDeletesScopes() as $method => $name) {
                $this->addScope(
                    with(new Scope($method))
                        ->setTitle($name)
                        ->setQuery([$model, $method])
                );
            }
        }
    }

    /**
     * @return array
     */
    protected function softDeletesScopes()
    {
        return ['onlyTrashed' => "Only Trashed", 'withTrashed' => "With Trashed"];
    }
}
