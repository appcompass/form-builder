<?php

$module_class_name = "\P3in\PilotIoModule";

$dependencies = ['disks'];

if (isset($path)) {
    require_once($path . '/PilotIoModule.php');

    return $module_class_name::makeInstance($path);
}

throw new \Exception('Path not specified while trying to load <pilot-io> module.');
