<?php
namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controller\BaseController;


class UserLogout extends BaseController
{
  
  public function __invoke(Request $request, Response $response): Response
  {

    $response->getBody()->write(json_encode($data));
    return $response
      ->withHeader('content-type', 'application/json')
      ->withStatus(200);
  }

}