<?php

namespace Terranet\Administrator\Services;

use Illuminate\Database\Eloquent\Model;
use Terranet\Administrator\Actions\RemoveSelected;
use Terranet\Administrator\Actions\SaveOrder;
use Terranet\Administrator\Contracts\Services\CrudActions as CrudActionsContract;
use Terranet\Administrator\Contracts\Services\Saver;
use Terranet\Administrator\Exception;
use Terranet\Administrator\Requests\UpdateRequest;
use Terranet\Administrator\Traits\ExportsCollection;
use Terranet\Rankable\Rankable;

class CrudActions implements CrudActionsContract
{
    use ExportsCollection;

    /**
     * @var
     */
    protected $module;

    protected static $responses = [];

    public function __construct($module)
    {
        $this->module = $module;
    }

    /**
     * Default custom list of actions.
     *
     * @return array
     */
    public function actions()
    {
        return [];
    }

    /**
     * Default list of batch actions.
     *
     * @return array
     */
    public function batchActions()
    {
        $actions = [RemoveSelected::class];

        if ($this->module->model() instanceof Rankable) {
            array_push($actions, SaveOrder::class);
        }

        return $actions;
    }

    /**
     * Update item callback.
     *
     * @param               $eloquent
     * @param UpdateRequest $request
     *
     * @return string
     *
     * @throws Exception
     *
     * @internal param $repository
     */
    public function save($eloquent, UpdateRequest $request)
    {
        $saver = app('scaffold.module')->saver();
        $saver = new $saver($eloquent, $request);

        if (!$saver instanceof Saver) {
            throw new Exception('Saver must implement ' . Saver::class . ' contract');
        }

        return $saver->sync();
    }

    /**
     * Destroy an attachment.
     *
     * @param   $item
     * @param   $attachment
     *
     * @return bool
     */
    public function detachFile(Model $item, $attachment)
    {
        try {
            $item->$attachment = STAPLER_NULL;
            $item->save();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Destroy item callback.
     *
     * @param $item
     *
     * @return string
     */
    public function delete(Model $item)
    {
        if (method_exists($item, 'trashed') && $item->trashed()) {
            return $item->forceDelete();
        }

        return $item->delete();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param string $method
     * @param        $item
     * @param null $module
     *
     * @return bool
     */
    public function authorize($method, $item = null, $module = null)
    {
        if (is_null($item)) {
            $item = app('scaffold.module')->model();
        }

        return $this->getCachedResponse($method, $item, $module);
    }

    /**
     * @param $method
     * @param $item
     * @param null $module
     *
     * @return bool|mixed
     */
    protected function getCachedResponse($method, $item, $module = null)
    {
        $method = 'can' . title_case($method);

        if (!$module) {
            $module = app('scaffold.module');
        }

        $key = $method . '_' . class_basename($item) . '_' . md5(serialize($item)) . '_' . class_basename($module);

        if ('testing' == app()->environment() || !array_key_exists($key, static::$responses)) {
            $response = true;

            $payload = [auth('admin')->user(), $item];

            # Check for custom action method.
            if (method_exists($this, $method)) {
                $response = call_user_func_array([$this, $method], $payload);
            }
            # Check for CRUD authorizations directly in Scaffolding Resource.
            else if ($this->module->hasMethod($method)) {
                $response = call_user_func_array([$this->module, $method], $payload);
            }

            static::$responses[$key] = $response;
        }

        return static::$responses[$key];
    }
}
