<?php

use Slim\App;

return function (App $app) {
    $app->get('/', \App\Action\HomeAction::class)->setName('home');
    $app->post('/new', \App\Action\NewLinkAction::class)->setName('new-link');
    $app->get('/{slug:[\w\-]+}', \App\Action\HandleLinkAction::class)->setName('handle-link');
};
