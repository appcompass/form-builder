<?php

$module_class_name = '\P3in\UsersModule';

$dependencies = [];

if (isset($path)) {
    require_once($path . '/UsersModule.php');

    return $module_class_name::makeInstance($path);
}

throw new \Exception('Path not specified while trying to load <users> module.');
