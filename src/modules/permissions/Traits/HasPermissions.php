<?php

namespace P3in\Traits;

use P3in\Models\Permission;
use P3in\Models\PermissionsRequired;
use P3in\Models\PermissionsRequired\PermissionItems\Element;
use P3in\Models\PermissionsRequired\PermissionItems\Model;

trait HasPermissions
{

    /**
     * get the required permission
     */
    public function getRequiredPermission($action = null)
    {
        return PermissionsRequired::retrieve($this->getElementPointer($action));

    }

    /**
     *
     */
    public static function getStaticRequiredPermission($action = null)
    {

        return PermissionsRequired::retrieve((new self)->getElementPointer($action));

    }

    /**
     * set a required permission for the owner
     */
    public function setRequiredPermission(Permission $permission, $action = null)
    {

        return PermissionsRequired::requirePermission($this->getElementPointer($action), $permission);

    }

    /**
     * set a required permission for the owner
     */
    public static function setStaticRequiredPermission(Permission $permission, $action = null)
    {

        return PermissionsRequired::requirePermission((new static())->getElementPointer($action), $permission);

    }

    //////////// PRIVATE

    private function getElementPointer($action = null)
    {

        $class = __CLASS__;

        if (null !== $this->getAttribute('id')) {

            $class = $class . '@' . $this->getAttribute('id');

        }

        $action = is_null($action) ? '' : '@' . $action;

        \Log::info($class);

        return new Model($class . $action);
    }

}