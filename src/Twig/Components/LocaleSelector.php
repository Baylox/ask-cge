<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

# usages
# [AsTwigComponent]

#[AsTwigComponent]
final class LocaleSelector
{
    # usages
    public function __construct(
        public array $managedLocales,
    ) {
        $this->managedLocales = $managedLocales;

    }
}
