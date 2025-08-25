<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;

#[AsEventListener]
final class AcceptLanguageListener
{

    public function __invoke(RequestEvent $event): void
    {
        // ...
    }
}
