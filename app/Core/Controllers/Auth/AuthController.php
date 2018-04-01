<?php

namespace CyberWorks\Core\Controllers\Auth;

use CyberWorks\Core\Controllers\Controller;
use Respect\Validation\Validator as v;
use CyberWorks\Core\Models\User;

class AuthController extends Controller
{
    public function loginPage($request, $response) {
        return $this->view->render($response, 'auth/login.twig');
    }

    public function login($request, $response) {
        $auth = $this->auth->attempt($request->getParam('username'), $request->getParam('password'), $this->container);

        if (!$auth) {
            $this->alerts->addMessage('error', 'Login Attempt Failed');
            return $response->withRedirect($this->router->pathFor('auth.login'));
        }

        return $response->withRedirect($this->router->pathFor('dashboard'));
    }

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param boole $img True to return a complete IMG tag False for just the URL
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @return String containing either just a URL or a complete image tag
     * @source https://gravatar.com/site/implement/images/php/
     */
    public function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";
        if ( $img ) {
            $url = '<img src="' . $url . '"';
            foreach ( $atts as $key => $val )
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }

    public function logout($request, $response) {
        $this->auth->logout();

        return $response->withRedirect($this->router->pathFor('auth.login'));
    }
}