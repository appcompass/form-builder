<?php

$module_class_name = "\P3in\Plus3websiteModule";

$dependencies = ['websites', 'users'];

if (isset($path)) {

    require_once($path . '/Plus3websiteModule.php');

    return $module_class_name::makeInstance($path);

}

throw new \Exception('Path not specified while trying to load <Plus3people> module.');