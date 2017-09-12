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
use CyberWorks\Core\Middleware\API\UserIsValidAPIMiddleware;
use CyberWorks\Core\Middleware\GroupIsValidMiddleware;

$app->group("/auth", function() {
    $this->get('/login','AuthController:loginPage')->setName('auth.login');
    $this->post('/login', 'AuthController:login');

    $this->get('/register','AuthController:registerPage')->setName('auth.register');
    $this->post('/register', 'AuthController:register');

    $this->get('/password/reset', 'PasswordController:resetPasswordPage')->setName('auth.password.reset');
    $this->post('/password/reset', 'PasswordController:requestResetToken');

    $this->get('/password/reset/', 'PasswordController:resetPasswordTokenMissingPage')->setName('auth.password.reset.token.missing');

    $this->get('/password/reset/{token}', 'PasswordController:resetPasswordWithTokenPage')->setName('auth.password.reset.token');
    $this->post('/password/reset/{token}', 'PasswordController:resetPasswordWithToken');
})->add(new GuestMiddleware($app->getContainer()));

$app->group("", function() {
    $this->get('/', 'HomeController:index')->setName('dashboard');
    $this->get('/logout','AuthController:logout')->setName('auth.logout');
    $this->get('/metrics', 'HomeController:stats')->setName('dashboard.metrics');

    $this->get('/groups', 'GroupController:index')->add(new HasPermissionMiddleware($this->getContainer(), "can_edit_group_perms"))->setName('groups');

    $this->get('/group/new', 'GroupController:new')->add(new HasPermissionMiddleware($this->getContainer(), "can_make_groups"))->setName('group.new');
    $this->post('/group/new', 'GroupController:newGroup')->add(new HasPermissionMiddleware($this->getContainer(), "can_make_groups"));

    $this->get('/group/{id}', 'GroupController:group')->add(new HasPermissionMiddleware($this->getContainer(), "can_edit_group_perms"))->add(new GroupIsValidMiddleware($this->getContainer()));
    $this->post('/group/{id}', 'GroupController:updateGroup')->setName('group.update')->add(new HasPermissionMiddleware($this->getContainer(), "can_edit_group_perms"))->add(new GroupIsValidMiddleware($this->getContainer()));

    $this->get('/users', 'UserController:index')->add(new HasPermissionMiddleware($this->getContainer(), "can_edit_users"))->setName('users');

    $this->get('/user/new', 'UserController:new')->add(new HasPermissionMiddleware($this->getContainer(), "can_add_user"));
    $this->post('/user/new', 'UserController:newUser')->add(new HasPermissionMiddleware($this->getContainer(), "can_add_user"))->setName('user.new');

})->add(new AuthenticatedMiddleware($app->getContainer()));

$app->group("/api/internal", function() {
    $this->group("/metrics", function() {
        $this->get('/all', 'MetricsController:allMetrics')->setName('api.metrics.all');
    });
    $this->post('/groups', 'GroupController:table');
    $this->post('/users', 'UserController:table');
    $this->post('/user/update', 'UserController:updateUser')->add(new HasPermissionAPIMiddleware($this->getContainer(), "can_edit_users"))->add(new UserIsValidAPIMiddleware($this->getContainer()))->setName('user.update');
    $this->post('/user/update/password', 'UserController:changeUserPassword')->add(new HasPermissionAPIMiddleware($this->getContainer(), "can_edit_users"))->add(new UserIsValidAPIMiddleware($this->getContainer()))->setName('user.update');
})->add(new AuthenticatedMiddleware($app->getContainer()));

