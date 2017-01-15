<?php

$module_class_name = '\P3in\GalleriesModule';

$dependencies = [];

if (isset($path)) {
    require_once($path . 'GalleriesModule.php');

    return P3in\GalleriesModule::makeInstance($path);
}

throw new \Exception('Path not specified while trying to load <test> module.');
