<?php

namespace App\EventListener;

use App\Services\EnveService;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Validator\Exception\ValidationFailedException;

#[AsEventListener(event: KernelEvents::EXCEPTION)]

final class ExceptionListener
{
    public function __construct(
        #[Autowire(env: 'APP_ENV')]
        private readonly string
        $environment
    ) {}

    public function __invoke(ExceptionEvent $event): void
    {
        $statusCode = 500;
        $exception = $event->getThrowable();
        $previousException = $exception->getPrevious();




        if ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();
        }

        if ($previousException instanceof ValidationFailedException) {
            $errors = [];
            foreach ($previousException->getViolations() as $violation) {
                $errors[] = [
                    'property' => $violation->getPropertyPath(),
                    'message' => $violation->getMessage(),
                    'invalidValue' => $violation->getInvalidValue(),
                ];
            }
            $response = EnveService::response(
                [
                    'status' => 'validation_error',
                    'errors' => $errors
                ],
                [
                    'status' => 'validation_error',
                    'errors' => $errors
                ],
                $this->environment,
                422
            );

            $event->setResponse($response);
            return;
        }

        $responseDataDev = [
            'success' => false,
            "message" => $exception->getMessage(),
            "file" => $exception->getFile(),
            "line" => $exception->getLine(),
        ];

        $responseDataProd = [
            'success' => false,
            "message" => 'An error occurred. Please try again later.',
        ];

        $response = EnveService::response(
            $responseDataDev,
            $responseDataProd,
            $this->environment,
            $statusCode
        );
        $event->setResponse($response);
    }
}
