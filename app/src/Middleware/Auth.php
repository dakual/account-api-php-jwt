<?php
namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth
{
  private $key = "secretkey";
  
  public function __invoke(Request $request, RequestHandler $handler): Response
  {
    $jwtHeader = $request->getHeaderLine('Authorization');
    if (! $jwtHeader) {
      throw new \App\Exception\Auth('JWT Token required.', 400);
    }

    $jwt = explode('Bearer ', $jwtHeader);
    if (! isset($jwt[1])) {
      throw new \App\Exception\Auth('JWT Token invalid.', 400);
    }

    $decoded  = $this->checkToken($jwt[1]);
    $request  = $request->withAttribute("jwt", $decoded);
    $response = $handler->handle($request);

    return $response;
  }

  private function checkToken(string $token): object
  {
    try {
      // $decoded = json_decode(json_encode($decoded), true);
      return JWT::decode($token, new Key($this->key, 'HS256'));
    } catch (\Exception $ex) {
      throw new \App\Exception\Auth('Forbidden: you are not authorized.', 403);
    }
  }
}
