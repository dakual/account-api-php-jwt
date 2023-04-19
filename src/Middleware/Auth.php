<?php
namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Firebase\JWT\JWT;

class Auth
{
  public function __invoke(Request $request, RequestHandler $handler): Response
  {
    $jwtHeader = $request->getHeaderLine('Authorization');
    if (! $jwtHeader) {
      // return $this->error('JWT Token required.', 400);
      throw new \App\Exception\Auth('JWT Token required.', 400);
    }

    $jwt = explode('Bearer ', $jwtHeader);
    if (! isset($jwt[1])) {
      // return $this->error('JWT Token invalid.', 400);
      throw new \App\Exception\Auth('JWT Token invalid.', 400);
    }

    $response = $handler->handle($request);
    return $response;
  }

  private function checkToken(string $token): object
  {
    try {
      return JWT::decode($token, $this->key, 'HS256');
    } catch (\Exception $ex) {
      throw new \App\Exception\Auth('Forbidden: you are not authorized.', 403);
    }
  }
}

// use Psr\Http\Message\ServerRequestInterface;
// use Psr\Http\Server\RequestHandlerInterface;
// use Psr\Http\Message\ResponseInterface;
// use Psr\Http\Server\MiddlewareInterface;
// use Firebase\JWT\JWT;

// class Auth implements MiddlewareInterface
// {
//   private $key = "secretkey";

//   public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
//   {
//     // $response = new \Slim\Psr7\Response(302);
//     // $response = $response->withHeader('Location', '/login');

//     $jwtHeader = $request->getHeaderLine('Authorization');
//     if (! $jwtHeader) {
//       throw new Exception('JWT Token required.', 400);
//     }

//     $jwt = explode('Bearer ', $jwtHeader);
//     if (! isset($jwt[1])) {
//       throw new Exception('JWT Token invalid.', 400);
//     }

//     $response = $handler->handle($request);

//     return $response;
//   }

//   protected function checkToken(string $token): object
//   {
//     try {
//       return JWT::decode($token, $this->key, 'HS256');
//     } catch (Exception $ex) {
//       throw new Auth('Forbidden: you are not authorized.', 403);
//     }
//   }
// }