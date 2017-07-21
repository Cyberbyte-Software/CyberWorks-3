<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 14/06/2017
 * Time: 11:26
 */

namespace CyberWorks\Core\Controllers\Auth;

use CyberWorks\Core\Controllers\Controller;

class AuthController extends Controller
{
    public function loginPage($request, $response) {
        return $this->view->render($response, 'auth/login.twig');
    }

    public function login($request, $response) {
        $auth = $this->auth->attempt($request->getParam('username'), $request->getParam('password'), $this->conainter);

        if (!$auth) {
            $this->alerts->addMessage('error', 'Login Attempt Failed');
            return $response->withRedirect($this->router->pathFor('auth.login'));
        }

        return $response->withRedirect($this->router->pathFor('dashboard'));
    }

    public function logout($request, $response) {
        $this->auth->logout();

        return $response->withRedirect($this->router->pathFor('auth.login'));
    }
}