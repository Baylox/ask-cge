<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Hero
{
    public string $title = 'Le gestionnaire visuel ultra-rapide';
    public ?string $subtitle = 'Organise tes tâches, gère tes projets, collabore en équipe.';
    public string $bg = null;
    public ?string $ctaHref = null;
    public ?string $ctaLabel = null;
}
