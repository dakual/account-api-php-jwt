<?php
namespace App\Controller\Task;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controller\BaseController;

class GetAll extends BaseController
{
    public function __invoke(Request $request, Response $response): Response
    {    
      $result = array();
      $result["message"] = "hello world!";
      $result["jwt"]     = $request->getAttribute('jwt');

      return $this->jsonResponse($response, 'success', $result, 200);
    }
}