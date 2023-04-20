<?php
namespace App\Handler;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use Slim\Interfaces\ErrorHandlerInterface;
use Slim\Interfaces\CallableResolverInterface;
use Slim\Logger;

class ErrorHandler implements ErrorHandlerInterface {
  protected CallableResolverInterface $callableResolver;
  protected ResponseFactoryInterface $responseFactory;
  protected LoggerInterface $logger;

  public function __construct(
      CallableResolverInterface $callableResolver,
      ResponseFactoryInterface $responseFactory,
      ?LoggerInterface $logger = null
  ) {
      $this->callableResolver = $callableResolver;
      $this->responseFactory = $responseFactory;
      $this->logger = $logger ?: new Logger();
  }

  public function __invoke(
    Request $request,
    \Throwable $exception,
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails
  ): Response {
    $statusCode = $exception->getCode();
    $className  = new \ReflectionClass(get_class($exception));
    $payload = [
      'message' => $exception->getMessage(),
      'class'   => $className->getName(),
      'status'  => 'error',
      'code'    => $statusCode,
    ];
  
    $response = $this->responseFactory->createResponse();
    $response->getBody()->write(
        json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
    );
  
    return $response
      ->withStatus($statusCode)
      ->withHeader('Content-type', 'application/problem+json');
  }
}