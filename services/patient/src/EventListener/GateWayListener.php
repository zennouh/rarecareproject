<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class GateWayListener
{
    #[AsEventListener('kernel.request')]
    public function onRequestEvent(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $path = $request->getPathInfo();

        if (str_starts_with($path, '/gateway')) {
            $event->stopPropagation();
        }
    }
}
