<?php

namespace P3in\Traits;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Permission;
use P3in\Models\PermissionsRequired;
use P3in\Models\PermissionsRequired\PermissionItems\Element;

trait HasPermissions
{

    /**
     * get the required permission
     */
    public function getRequiredPermission()
    {
        if ($this instanceof Model) {

            return PermissionsRequired::retrieve($this->getElementPointer());

        }

        return;
    }

    /**
     * set a required permission for the owner
     */
    public function setRequiredPermission(Permission $permission)
    {
        if ($this instanceof Model) {

            return PermissionsRequired::requirePermission($this->getElementPointer(), $permission);

        }

    }

    //////////// PRIVATE

    private function getElementPointer()
    {
        $class = get_class($this);

        $id = $this->id;

        return new Element($class . '@' . $id);
    }

}