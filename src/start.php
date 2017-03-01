<?php

$module_class_name = "\P3in\CmsModule";

$dependencies = ['disks'];

if (isset($path)) {
    require_once($path . '/CmsModule.php');

    return $module_class_name::makeInstance($path);
}

throw new \Exception('Path not specified while trying to load <cms> module.');
