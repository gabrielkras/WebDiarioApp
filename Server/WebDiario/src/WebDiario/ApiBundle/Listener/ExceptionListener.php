<?php

namespace WebDiario\ApiBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use WebDiario\ApiBundle\Helpers\ApiProblem;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getException();
        // Get requested resource
        $uri = $event->getRequest()->getRequestUri();

        if(strpos($uri,"/api") !== false)
        {
            if((get_class($exception) == "WebDiario\\ApiBundle\\Helpers\\ApiProblemException"))
            {
                $apiProblem = $exception->getApiProblem();
                $response = $apiProblem->getResponse();
                $event->setResponse($response);
            }
            else if((get_class($exception) === "Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException") ||
                (get_class($exception) === "Symfony\\Component\\HttpKernel\\Exception\\HttpException") ||
                (get_class($exception) === "Symfony\\Component\\HttpKernel\\Exception\\MethodNotAllowedHttpException"))
            {
                $apiProblem = ApiProblem::createApiProblemByCode($exception->getStatusCode());
                $apiProblem->set('message', $exception->getMessage());
                $response = $apiProblem->getResponse();
                $event->setResponse($response);
            }
            else
            {
                $apiProblem = ApiProblem::createApiProblemByCode(ApiProblem::TYPE_INTERNAL_SERVER_ERROR);
                $apiProblem->set('message', $exception->getMessage());
                $response = $apiProblem->getResponse();
                $event->setResponse($response);
            }
        }
        return;
    }
}