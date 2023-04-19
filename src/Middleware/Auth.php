<?php
namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Firebase\JWT\JWT;

class Auth implements MiddlewareInterface
{
  private $key = "secretkey";

  public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
  {
    // $response = new \Slim\Psr7\Response(302);
    // $response = $response->withHeader('Location', '/');
    print_r($request);
    
    $response = $handler->handle($request);

    return $response;
  }

  protected function checkToken(string $token): object
  {
    try {
      return JWT::decode($token, $this->key, 'HS256');
    } catch (Exception $ex) {
      throw new Auth('Forbidden: you are not authorized.', 403);
    }
  }
}