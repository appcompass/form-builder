<?php

$module_class_name = '\P3in\TestModule';

$dependencies = [];

if (isset($path)) {

    require_once($path . '/TestModule.php');

    return P3in\TestModule::makeInstance($path);

}

throw new \Exception('Path not specified while trying to load <test> module.');