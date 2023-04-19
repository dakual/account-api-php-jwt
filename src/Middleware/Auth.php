<?php
namespace App\Middleware;

use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Server\RequestHandlerInterface;
use \Psr\Http\Message\ResponseInterface;
use \Psr\Http\Server\MiddlewareInterface;

class Auth implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
      // $response = new \Slim\Psr7\Response(302);
      // $response = $response->withHeader('Location', '/');

      $response = $handler->handle($request);

      return $response;
    }
}