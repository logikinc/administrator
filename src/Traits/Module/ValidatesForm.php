<?php

namespace Terranet\Administrator\Traits\Module;

use function admin\db\scheme;
use Doctrine\DBAL\Schema\Column;

trait ValidatesForm
{
    /**
     * Define validation rules
     */
    public function rules()
    {
        return $this->scaffoldRules();
    }

    /**
     * Build a list of supposed validators based on columns and indexes information
     *
     * @return array
     */
    protected function scaffoldRules()
    {
        $rules = [];

        $eloquent = $this->model();
        $table = $eloquent->getTable();

        foreach (scheme()->columns($table) as $column) {
            $name = $column->getName();
            if ($name == $eloquent->getKeyName()) {
                continue;
            }

            if (! empty($columnRules = $this->proposeColumnRules($eloquent, $column))) {
                $rules[$name] = join("|", $columnRules);
            }
        }

        return $rules;
    }

    /**
     * Build a list of validators for a column
     *
     * @param        $eloquent
     * @param Column $column
     * @return array
     */
    protected function proposeColumnRules($eloquent, Column $column)
    {
        $rules = [];

        if ((($this->fillable($column->getName(), $eloquent) || $this->isForeignKey($column, $eloquent))
            && $column->getNotnull())) {
            // make required rule first
            array_unshift($rules, "required");
        }

        if ($this->isUnique($column, $eloquent)) {
            $rules[] = "unique";
        }

        if ('BooleanType' == ($classname = class_basename($column->getType()))) {
            $rules[] = "numeric";
            $rules[] = "boolean";

            if (app()->runningUnitTests()) {
                $rules = array_diff($rules, ['required']);
            }
        }

        if (in_array($classname, ['IntegerType', 'DecimalType'])) {
            $rules[] = "numeric";

            if ($column->getUnsigned()) {
                $rules[] = "unsigned";
            }
        }

        if ($this->isForeignKey($column, $eloquent)) {
            $rules[] = "foreign";
        }

        return array_map(function ($rule) use ($column, $eloquent) {
            $method = "make" . ucfirst($rule) . "Rule";

            return call_user_func_array([$this, $method], [$column, $eloquent]);
        }, $rules);
    }

    /**
     * Check if column fillable
     *
     * @param            $column
     * @param            $eloquent
     * @return bool
     */
    protected function fillable($column, $eloquent)
    {
        return in_array($column, $eloquent->getFillable());
    }

    /**
     * Check if column is a part of foreign keys
     *
     * @param $column
     * @param $eloquent
     * @return bool
     */
    protected function isForeignKey($column, $eloquent)
    {
        foreach ($foreign = scheme()->foreignKeys($eloquent->getTable()) as $foreign) {
            if (in_array($column->getName(), $foreign->getLocalColumns())) {
                return $foreign;
            }
        }

        return false;
    }

    /**
     * @param Column $column
     * @param        $eloquent
     * @return array
     */
    protected function isUnique(Column $column, $eloquent)
    {
        foreach (scheme()->indexes($eloquent->getTable()) as $indexName => $index) {
            if (in_array($column->getName(), $index->getColumns()) && $index->isUnique()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Make required rule
     *
     * @param Column $column
     * @param        $eloquent
     * @return string
     */
    protected function makeRequiredRule(Column $column, $eloquent)
    {
        return "required";
    }

    /**
     * Make numeric rule
     *
     * @param Column $column
     * @param        $eloquent
     * @return array
     */
    protected function makeNumericRule(Column $column, $eloquent)
    {
        return $column->getScale() ? "numeric" : "integer";
    }

    /**
     * Make unsigned rule
     *
     * @param Column $column
     * @param        $eloquent
     * @return array
     */
    protected function makeUnsignedRule(Column $column, $eloquent)
    {
        return "min:0";
    }

    /**
     * @return array
     */
    protected function makeBooleanRule()
    {
        return "in:0,1";
    }

    /**
     * Parse foreign keys for column presence
     *
     * @param Column $column
     * @param        $eloquent
     * @return array
     */
    protected function makeForeignRule(Column $column, $eloquent)
    {
        $foreign = $this->isForeignKey($column, $eloquent);
        $foreignTable = $foreign->getForeignTableName();
        $foreignKey = head($foreign->getForeignColumns());

        return "exists:{$foreignTable},{$foreignKey}";
    }

    protected function makeUniqueRule($column, $eloquent)
    {
        if (is_object($key = $this->routeParam('id')) && method_exists($key, "getKey")) {
            $key = $key->getKey();
        }

        return "unique:{$eloquent->getTable()},{$column->getName()}" . ($key ? ",{$key}" : "");
    }

    protected function routeParam($name, $default = null)
    {
        return \Route::current()->parameter($name, $default);
    }
}
