<?php

$module_class_name = '\P3in\WebsitesModule';

$dependencies = [];

if (isset($path)) {

    require_once($path . '/WebsitesModule.php');

    return $module_class_name::makeInstance($path);

}

throw new \Exception('Path not specified while trying to load <websites> module.');