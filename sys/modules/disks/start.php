<?php

$module_class_name = "\P3in\DisksModule";

$dependencies = ['test', 'blog'];

if (isset($path)) {
    require_once($path . '/DisksModule.php');

    return $module_class_name::makeInstance($path);
}

throw new \Exception('Path not specified while trying to load <disks> module.');
