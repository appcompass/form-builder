<?php

$module_class_name = '\P3in\AddressesModule';

$dependencies = [];

if (isset($path)) {
    require_once($path . '/AddressesModule.php');

    return $module_class_name::makeInstance($path);
}

throw new \Exception('Path not specified while trying to load <addresses> module.');
