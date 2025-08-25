<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;

/*
 * This listener is responsible for setting the locale based on the Accept-Language header
 * sent by the client. It runs after the default locale (priority 15).
 */
#[AsEventListener(priority: 32)] // 32 to run after the default locale is set
final class AcceptLanguageListener
{
    public const MANAGED_LOCALES = ['en', 'fr'];

    public function __invoke(RequestEvent $event): void
    {
        $request = $event->getRequest();

        // Detect the best language from the user's Accept-Language header
        $preferredLocale = $request->getPreferredLanguage(self::MANAGED_LOCALES);

        if ($preferredLocale) {
            // Apply the detected locale to the current request
            $request->setLocale($preferredLocale);
        }
    }
}

