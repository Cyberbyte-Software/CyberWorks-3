<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 19/07/2017
 * Time: 03:47
 */
$container['PlayerController'] = function ($container) {
    return new CyberWorks\Life\Controllers\PlayerController($container);
};
$container['VehicleController'] = function ($container) {
    return new CyberWorks\Life\Controllers\VehicleController($container);
};
$container['NoteController'] = function ($container) {
    return new CyberWorks\Life\Controllers\Admin\NoteController($container);
};
$container['LifeMetricsController'] = function ($container) {
    return new CyberWorks\Life\Controllers\LifeMetricsController($container);
};
$container['GangController'] = function ($container) {
    return new CyberWorks\Life\Controllers\GangController($container);
};
$container['ContainerController'] = function ($container) {
    return new CyberWorks\Life\Controllers\ContainerController($container);
};
$container['HouseController'] = function ($container) {
    return new CyberWorks\Life\Controllers\HouseController($container);
};
$container['LifeLogController'] = function ($container) {
    return new CyberWorks\Life\Controllers\Admin\LifeLogController($container);
};