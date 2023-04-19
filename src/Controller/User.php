<?php
namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controller\BaseController;
use Firebase\JWT\JWT;

class User extends BaseController
{
  private $key = "secretkey";

  public function __invoke(Request $request, Response $response): Response
  {
    // $username = $request->getParsedBody('username');
    // $password = $request->getParsedBody('password');

    $token = [
      "iss" => "utopian",
      "iat" => time(),
      "exp" => time() + 60,
      "data" => [
        "user_id" => 101
      ]
    ];

    $jwt = JWT::encode($token, $this->key, 'HS256');
    
    // $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
    // print_r($decoded);

    $data = array(
      'success' => true,
      'message' => "Login Successfull",
      "jwt" => $jwt
    );

    $response->getBody()->write(json_encode($data));
    return $response
      ->withHeader('content-type', 'application/json')
      ->withStatus(200);
  }

}