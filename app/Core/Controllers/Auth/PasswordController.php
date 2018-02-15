<?php

namespace CyberWorks\Core\Controllers\Auth;

use CyberWorks\Core\Controllers\Controller;
use CyberWorks\Core\Models\User;
use Respect\Validation\Validator as v;
use PHPMailer;

class PasswordController extends Controller
{
    public function resetPasswordPage($request, $response) {
        return $this->view->render($response, 'auth/request_reset_password.twig');
    }
    public function requestResetToken($request, $response) {
        $validation = $this->validator->validate($request, [
                'email' => v::noWhitespace()->notEmpty()->email()->emailTaken()
            ]
        );

        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('auth.password.reset'));
        }

        $token = bin2hex(random_bytes(32));
        $user = User::where('email', $request->getParam('email'))->first();
        $user->password_reset_token = $token;
        $user->save();

        $mailer = new PHPMailer;
        $mailer->isSMTP();  // Set mailer to use SMTP
        $mailer->Host = $this->container->config->get('email.host');  // Specify main and backup SMTP servers
        $mailer->SMTPAuth = true; // Enable SMTP authentication
        $mailer->Username = $this->container->config->get('email.username'); // SMTP username
        $mailer->Password = $this->container->config->get('email.password'); // SMTP password
        $mailer->SMTPSecure = $this->container->config->get('email.encryption');  // Enable TLS encryption, `ssl` also accepted
        $mailer->Port = (int)$this->container->config->get('email.port');
        $domain = $this->container->config->get('email.domain');

        $mailer->setFrom('cyberworks@' . $domain, $domain);
        $mailer->addAddress($request->getParam('email'));
        $mailer->addReplyTo('no-reply@' . $domain, $domain);
        $mailer->isHTML(true);
        $uri = $request->getUri();
        $base = $uri->getBaseUrl();

        $mailer->Subject = 'Instructions for resetting the password for your account with CyberWorks';
        $mailer->Body    = "
        <p>Hi,</p>
        <p>            
        We have received a request for a password reset on the account associated with this email address.
        </p>
        <p>
        To confirm and reset your password, please click <a href=\"$base/auth/password/reset/$token\">here</a>.  If you did not initiate this request,
        please disregard this message.
        </p>";

        if(!$mailer->send()) {
            $this->alerts->addMessage("error", "We're having trouble with our mail servers at the moment.  Please try again later.");
            return $response->withRedirect($this->router->pathFor('auth.password.reset'));
        }

        $this->logger->info($request->getParam('email') . " Requested a password reset token!");
        $this->alerts->addMessage('success', 'Email Sent');

        return $response->withRedirect($this->router->pathFor('auth.password.reset'));
    }
    public function resetPasswordWithTokenPage($request, $response, $args) {
        return $this->view->render($response, 'auth/reset_password.twig', $args);
    }

    public function resetPasswordWithToken($request, $response, $args) {
        $req_validation = $this->validator->validate($request, [
            'email' => v::noWhitespace()->notEmpty()->email()->emailTaken()
        ]);

        if ($req_validation->failed()) {
            $this->alerts->addMessage("error", "Invalid Email");
            return $response->withRedirect($this->router->pathFor('auth.password.reset'));
        }

        $arg_validation = $this->validator->validateArgs($args, [
            'token' => v::noWhitespace()->notEmpty()->resetTokenValid()
        ]);

        if ($arg_validation->failed()) {
            $this->alerts->addMessage("error", "Invalid Reset Token");
            return $response->withRedirect($this->router->pathFor('auth.password.reset'));
        }

        $user = User::where('email', $request->getParam('email'))->where('password_reset_token', $args['token'])->first();
        if (!$user) {
            $this->alerts->addMessage("error", "Token Email Missmatch");
            return $response->withRedirect($this->router->pathFor('auth.password.reset'));
        }

        $user->password = password_hash($request->getParam('password'), PASSWORD_DEFAULT);
        $user->password_reset_token = null;
        $user->save();

        $this->logger->info($request->getParam('email') . " used a password reset token!");
        $this->auth->attempt($request->getParam('email'), $request->getParam('password'));

        return $response->withRedirect($this->router->pathFor('dashboard'));
    }

    public function resetPasswordTokenMissingPage($request, $response) {
        return $response->withRedirect($this->router->pathFor('auth.login'));
    }
}
