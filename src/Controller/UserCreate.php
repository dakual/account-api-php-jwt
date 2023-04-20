<?php
namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controller\BaseController;

class UserCreate extends BaseController
{
  public function __invoke(Request $request, Response $response): Response
  {
    return $response;
  }
}