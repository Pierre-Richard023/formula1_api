<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event): void
    {
//        $exception = $event->getThrowable();
//        $statusCode = 500;
//        $message = 'An error occurred';
//
//        if ($exception instanceof NotFoundHttpException) {
//            $statusCode = 404;
//            $message = 'Resource not found';
//        } elseif ($exception instanceof HttpExceptionInterface) {
//            $statusCode = $exception->getStatusCode();
//            $message = $exception->getMessage();
//        }
//
//        $response = new JsonResponse([
//            'status' => $statusCode,
//            'message' => $message,
//        ], $statusCode);
//
//        $event->setResponse($response);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
