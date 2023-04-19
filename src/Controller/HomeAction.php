<?php
namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controller\BaseController;

class HomeAction extends BaseController
{
    public function __invoke(Request $request, Response $response): Response
    {
      $result = array();
      $result["status"]  = "success";
      $result["message"] = "hello world!";

      $response->getBody()->write(json_encode($result));
      return $response
        ->withHeader('content-type', 'application/json')
        ->withStatus(200);
    }
}