<?php
namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controller\BaseController;
use Firebase\JWT\JWT;

class Login extends BaseController
{
  private $key = "secretkey";

  public function __invoke(Request $request, Response $response): Response
  {
    $data = (array) $request->getParsedBody();
    if (empty($data) || !isset($data['username']) || !isset($data['password'])) {
      throw new \App\Exception\Auth('Username and Password required!', 400);
    }
    $username = $data["username"];
    $password = $data["password"];

    $token = [
      "iss"  => "daghan",
      "aud"  => "http://example.com",
      "sub"  => 101,
      "iat"  => time(),
      "exp"  => time() + 60,
      "data" => [
        "id"        => 101,
        "email"     => "daghan@mail.com",
        "firstname" => "Daghan",
        "lastname"  => "Altunsoy",
        "roles"     => array("admin")
      ]
    ];

    $jwt = JWT::encode($token, $this->key, 'HS256');

    $data = array(
      'success' => true,
      'message' => "Login Successfull",
      "token"   => 'Bearer ' . $jwt
    );

    $response->getBody()->write(json_encode($data));
    return $response
      ->withHeader('content-type', 'application/json')
      ->withStatus(200);
  }

}