<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ResponseListener
{
    public function onKernelResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();

        $response->headers->set('x-task', '1');
    }
}

