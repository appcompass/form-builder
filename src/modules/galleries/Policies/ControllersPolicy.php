<?php

namespace P3in\Policies;

use P3in\Models\Permission;
use P3in\Models\PermissionsRequired;
use P3in\Models\PermissionsRequired\PermissionItems\Controller;
use P3in\Models\PermissionsRequired\PermissionItems\Element;
use P3in\Models\PermissionsRequired\PermissionItems\Route;
use P3in\Models\User;

class ControllersPolicy
{

    protected $controller;

    public function __construct()
    {

        $this->controller = \Request::route()->getAction()['controller'];

    }

    /**
     *  Applies to index method
     */
    public function index(User $user)
    {

        return $this->evaluate($user, PermissionsRequired::retrieve(new Controller($this->controller)));

    }

    /**
     *  Applies to the store
     */
    public function store(User $user, $model)
    {

        return $this->evaluate($user, PermissionsRequired::retrieve(new Controller($this->controller)));

    }

    /**
     *
     */
    public function edit(User $user, $model)
    {

        return $this->evaluate($user, PermissionsRequired::retrieve(new Controller($this->controller)));

    }

    /**
     *
     */
    public function update(User $user, $model)
    {

        return $this->evaluate($user, PermissionsRequired::retrieve(new Controller($this->controller)));

    }

    /**
     *
     */
    private function evaluate(User $user, $perm = null )
    {

        if (is_null($perm)) {

            return true;

        } else if (get_class($perm) === Permission::class) {

            return $user->hasPermission($perm->type);

        }

        return true;


    }
}