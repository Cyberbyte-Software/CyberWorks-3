<?php

use Respect\Validation\Validator as v;
use Illuminate\Translation\Translator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;

session_start();

if (!file_exists(__DIR__. '/../vendor/autoload.php')) {
    echo 'You need to run composer install first. Or use a bundled release. ';
    echo 'See the <a href="https://github.com/Cyberbyte-Studios/CyberWorks-3/wiki/Installation#composer">install wiki</a> for more details' ;
    die();
}

require __DIR__ . '/../vendor/autoload.php';

use Noodlehaus\Config;

if (!file_exists(__DIR__. '/../config/config.php')) {
    die('You need to run <a href="installer.php">installer.php</a> first');
}

if (file_exists(__DIR__. '/../public/installer.php')) {
    die('You need to delete installer.php first');
}

$config = Config::load(__DIR__. '/../config/config.php');

$app = new \Slim\App($config->get('slim'));

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;

$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule) {
  return $capsule;
};

$container['auth'] = function ($container) {
    return new CyberWorks\Core\Auth\Auth($container);
};

$container['alerts'] = function ($container) {
    return new \Slim\Flash\Messages;
};
$container['config'] = function ($container) {
    return Noodlehaus\Config::load(__DIR__. '/../config/config.php');
};

$container['translator'] = function ($container) {
    $locale = $container->config->get('lang');

    $translator = new Translator(new FileLoader(new Filesystem(), __DIR__ . '/../resources/lang'), $locale);
    $translator->setLocale($locale);
    $translator->setFallback('en');

    return $translator;
};

$container['view'] = function ($container) {
  $view = new \Slim\Views\Twig(
      __DIR__ . '/../resources/views',
      [
          'cache' => false,
      ]
  );

  $view->addExtension(new \Slim\Views\TwigExtension(
      $container->router,
      $container->request->getUri()
  ));

  $view->addExtension(new \CyberWorks\Extension\TranslationExtension(
      $container->translator
  ));

  $view->getEnvironment()->addGlobal('auth', [
      'authenticated' => $container->auth->isAuthed(),
      'user' => $container->auth->user(),
      'group' => $container->auth->primaryGroup(),
      'isSuperUser' => $container->auth->isSuperUser(),
      'permissions' => $container->auth->permissions()
  ]);

  $view->getEnvironment()->addGlobal('alerts', $container->alerts);


  return $view;
};

/* Setup Bindings */
include __DIR__ . '/../app/Core/container.php';
include __DIR__ . '/../app/Life/container.php';

$container['csrf'] = function($container) {
  return new \Slim\Csrf\Guard;
};

$container['slave'] = function ($container) {
    $config = $container->config;
    return new CyberWorks\Core\Auth\IPSSlave($config->get('ips.master_url'), $config->get('ips.master_key'), $config->get('ips.base_url'), $config->get('ips.api_key'));
};
$container['logger'] = function ($container) {
    $logger = new \Monolog\Logger('cyberworks');
    $logger->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__ . '/../logs/cyberworks.log', \Monolog\Logger::INFO));

    return $logger;
};

$app->add(new CyberWorks\Core\Middleware\ValidationErrorsMiddleware($container));
$app->add(new CyberWorks\Core\Middleware\OldInputMiddleware($container));
$app->add(new CyberWorks\Core\Middleware\csrf\CSRFViewMiddleware($container));
$app->add(new CyberWorks\Core\Middleware\csrf\CSRFHeaderMiddleware($container));
$app->add($container->csrf);
v::with('CyberWorks\\Core\\Validation\\Rules\\');

require __DIR__ . '/../app/routes.php';