<?php

namespace AppBundle\Service\JsonApi\EventListener;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class JsonExceptionListener
{
    private $apiRoutePrefix;

    public function __construct($apiRoutePrefix)
    {
        $this->apiRoutePrefix = $apiRoutePrefix;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $route = $event->getRequest()->get('_route');
        if (strpos($route, $this->apiRoutePrefix) === 0) {
            $exception = $event->getException();
            $data = array(
                'error' => array(
                    'code' => $exception->getCode(),
                    'message' => $exception->getMessage()
                )
            );
            $response = new JsonResponse($data);
            $event->setResponse($response);
        }
    }
}

