<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Selective\BasePath\BasePathMiddleware;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use App\Middleware\Auth;
use App\Controller;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath("/app/public");
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->add(new BasePathMiddleware($app));
$app->addErrorMiddleware(true, true, true);



$app->get('/', function (Request $request, Response $response, $args) {
  $response->getBody()->write("Account API v1.0");
  return $response;
});


$app->group('/api/v1', function (RouteCollectorProxy $group) {
  $group->get('/employees', Controller\HomeAction::class)->add(new Auth());
});


$app->run();
