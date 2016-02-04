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

        return true;

    }

    /**
     *  Applies to the store
     */
    public function store(User $user, $model)
    {

        // dd(\App::make('request')->getUserResolver()());
        // dd(\App::make('request')->getRouteResolver()()->uri());
        // dd(get_class($model));

        if (is_object($model)) {

            \Log::info(get_class($model));

        }

        return true;

    }

    /**
     *
     */
    public function edit(User $user, $model)
    {

        // $controller = \Request::route()->getAction()['controller'];
        //
        // dd($this->controller);
        //
        return $this->evaluate($user, PermissionsRequired::retrieve(new Controller($this->controller)));

        // $req_perm = PermissionsRequired::retrieve(new Controller($this->controller));

        // if ($req_perm->count() AND $user->hasPermission($req_perm->type)) {

            // return true;

        // }

        // return false;

    }

    private function evaluate(User $user, $perm = null )
    {

        if (is_null($perm)) {

            return true;

        } else if (get_class($perm) === Permission::class) {

            return $user->hasPermission($perm->type);

        }

        return true;


    }

    public function update(User $user, $model)
    {

        // dd($model);

    }

    /**
     *
     */
    // public function ()
    // {

    // }

}