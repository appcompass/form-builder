<?php

namespace P3in\Policies;

use Illuminate\Http\Request;
use P3in\Models\Permission;
use P3in\Models\PermissionsRequired;
use P3in\Models\PermissionsRequired\PermissionItems\Model;
use P3in\Models\PermissionsRequired\PermissionItems\Element;
use P3in\Models\PermissionsRequired\PermissionItems\Route;
use P3in\Models\User;

class ResourcesPolicy
{
    protected $controller;
    protected $request;
    protected $action = '';

    public function __construct(Request $request)
    {
        if (\App::runningInConsole()) {
            return true;
        }

        $this->controller = $request->route()->getAction()['controller'];

        if (preg_match('/@/', $this->controller)) {
            list($discard, $action) = explode('@', $this->controller);

            $this->action = '@' . $action;
        }
        // dd($this);
    }

    /**
     *  Check for root
     */
    public function before($user, $perm)
    {
        if ($user->isRoot()) {
            return true;
        }
    }

    /**
     *  @param method
     *  @param mixed arguments [ User, $model [string|object] ]
     */
    public function __call($method, $arguments)
    {
        $this->action = '@' . $method;

        $this->parseArgs($arguments);

        return $this->evaluate($this->user, PermissionsRequired::retrieve($this->permission_item));
    }

    /**
     *  Bind arguments to corresponding properties
     */
    public function parseArgs($arguments)
    {
        $this->user = $arguments[0];

        $name = is_object($arguments[1]) ? get_class($arguments[1]) : $arguments[1];

        $this->permission_item = new Model($name . $this->action);
    }

    /**
     *
     */
    private function evaluate(User $user, $perm = null)
    {
        if (is_null($perm)) {
            return true;
        } elseif (get_class($perm) === Permission::class) {
            return $user->hasPermission($perm->type);
        }

        return true;
    }
}
