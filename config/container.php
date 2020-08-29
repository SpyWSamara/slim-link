<?php

use App\Settings;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;

return [
    Settings::class => function (ContainerInterface $container) {
        return new Settings(require __DIR__.'/settings.php');
    },

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);

        return AppFactory::create();
    },

    ErrorMiddleware::class => function (ContainerInterface $container) {
        $app = $container->get(App::class);
        $settings = $container->get(Settings::class);

        return new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool) $settings['error.display_error_details'],
            (bool) $settings['error.log_errors'],
            (bool) $settings['error.log_error_details']
        );
    },
];
