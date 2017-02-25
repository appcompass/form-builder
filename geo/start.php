<?php

$module_class_name = '\P3in\GeoModule';

$dependencies = [];

if (isset($path)) {
    require_once($path . '/GeoModule.php');

    return $module_class_name::makeInstance($path);
}

throw new \Exception('Path not specified while trying to load <geo> module.');
