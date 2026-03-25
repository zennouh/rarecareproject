<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

final class GateWayListener
{
    #[AsEventListener(event: 'kernel.request')]
    public function onRequestEvent(RequestEvent $event): void
    {

        if (!$event->isMainRequest()) {
            throw new AccessDeniedHttpException(
                'Access to patient service is not allowed through this port.'
            );
        }

        $request = $event->getRequest();
        $port = $request->getPort();
        $host = $request->getHost();
        // dd($port);
        if ($host !== 'patients') {
            throw new AccessDeniedHttpException(
                'Access to patient service is not allowed through this port.'
            );
        }
    }
}
