<?php
namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controller\BaseController;
use App\Repository\UserRepository;
use App\Entity\UserEntity;
use Firebase\JWT\JWT;

class UserLogin extends BaseController
{
  private $key;
  private UserRepository $repository;

  public function __construct()
  {
    $this->key = getenv('JWT_KEY');
    $this->repository = new UserRepository();
  }

  public function __invoke(Request $request, Response $response): Response
  {
    $data = (array) $request->getParsedBody();
    if (empty($data) || !isset($data['username']) || !isset($data['password'])) {
      throw new \App\Exception\Auth(
        'Login failed: Username and Password required!', 400
      );
    }
    $username = $data["username"];
    $password = $data["password"];

    $user = $this->repository->loginUser($username, $password);
    if (! password_verify($password, $user->password)) {
      throw new \App\Exception\Auth(
        'Login failed: Username or password incorrect!', 400
      );
    }
    
    $token = [
      "iss"  => "daghan",
      "aud"  => "http://example.com",
      "sub"  => $user->id,
      "iat"  => time(),
      "exp"  => time() + 60 // (7 * 24 * 60 * 60),
    ];

    $jwt = JWT::encode($token, $this->key, 'HS256');

    $data = array(
      'success' => true,
      'message' => 'Login Successfull',
      'token'   => 'Bearer ' . $jwt
    );

    $response->getBody()->write(json_encode($data));
    return $response
      ->withHeader('content-type', 'application/json')
      ->withStatus(200);
  }
}