<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Selective\BasePath\BasePathMiddleware;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use App\Controller;
use App\Handler\ErrorHandler;

require __DIR__ . '/../vendor/autoload.php';


$app = AppFactory::create();
$app->setBasePath("/app/public");
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->add(new BasePathMiddleware($app));
// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorHandler    = new ErrorHandler($app->getCallableResolver(), $app->getResponseFactory());
$errorMiddleware->setDefaultErrorHandler($errorHandler);

$app->get('/', function (Request $request, Response $response, $args) {
  $response->getBody()->write("Accoun Api v1.0");
  return $response
    ->withHeader('content-type', 'application/json')
    ->withStatus(200);
});

$app->get('/login', Controller\User::class);

$app->group('/api/v1', function (RouteCollectorProxy $group) {
  $group->get('/employees', Controller\HomeAction::class);
})->add(new App\Middleware\Auth());


$app->run();
