<?php

$module_class_name = '\P3in\BlogModule';

$dependencies = [];

if (isset($path)) {
    require_once($path . '/BlogModule.php');

    return P3in\BlogModule::makeInstance($path);
}

throw new \Exception('Path not specified while trying to load <blog> module.');
