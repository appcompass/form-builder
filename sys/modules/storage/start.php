<?php

$module_class_name = "\P3in\StorageModule";

$dependencies = ['test', 'blog'];

if (isset($path)) {
    require_once($path . '/StorageModule.php');

    return $module_class_name::makeInstance($path);
}

throw new \Exception('Path not specified while trying to load <storage> module.');
