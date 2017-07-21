<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 19/07/2017
 * Time: 03:24
 */
use CyberWorks\Core\Middleware\GuestMiddleware;
use CyberWorks\Core\Middleware\AuthenticatedMiddleware;
use CyberWorks\Core\Middleware\Permissions\API\HasPermissionAPIMiddleware;
use CyberWorks\Core\Middleware\Permissions\HasPermissionMiddleware;

$app->group("/auth", function() {
    $this->get('/login','AuthController:loginPage')->setName('auth.login');
    $this->post('/login', 'AuthController:login');
})->add(new GuestMiddleware($app->getContainer()));

$app->group("", function() {
    $this->get('/', 'HomeController:index')->setName('dashboard');
    $this->get('/logout','AuthController:logout')->setName('auth.logout');
    $this->get('/metrics', 'HomeController:stats')->setName('dashboard.metrics');
    $this->get('/logs/player', 'LogController:playerIndex')->add(new HasPermissionMiddleware($this->getContainer(), "can_view_logs"))->setName('logs.player');
})->add(new AuthenticatedMiddleware($app->getContainer()));

$app->group("/api", function() {
    $this->post('/logs/player', 'LogController:playerTable')->add(new HasPermissionAPIMiddleware($this->getContainer(), "can_view_logs"))->setName('api.logs.player');

    $this->group("/metrics", function() {
        $this->get('/all', 'MetricsController:allMetrics')->setName('api.metrics.all');
    });
})->add(new AuthenticatedMiddleware($app->getContainer()));