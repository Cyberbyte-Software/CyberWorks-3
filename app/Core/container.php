<?php

$container['validator'] = function ($container) {
    return new CyberWorks\Core\Validation\Validator;
};
$container['HomeController'] = function ($container) {
    return new CyberWorks\Core\Controllers\HomeController($container);
};
$container['AuthController'] = function ($container) {
    return new CyberWorks\Core\Controllers\Auth\AuthController($container);
};
$container['MetricsController'] = function ($container) {
    return new CyberWorks\Core\Controllers\API\MetricsController($container);
};
$container['GroupController'] = function ($container) {
    return new CyberWorks\Core\Controllers\Auth\GroupController($container);
};
$container['UserController'] = function ($container) {
    return new CyberWorks\Core\Controllers\Auth\UserController($container);
};
$container['PasswordController'] = function ($container) {
    return new CyberWorks\Core\Controllers\Auth\PasswordController($container);
};
$container['PatchController'] = function ($container) {
    return new CyberWorks\Core\Controllers\PatchController($container);
};
