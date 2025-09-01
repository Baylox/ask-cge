<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Hero
{
    public string $title = 'Le gestionnaire visuel ultra-rapide';
    public ?string $subtitle = 'Organise tes tâches, gère tes projets, collabore en équipe.';
    public string $bg = 'assets/images/hero/task-dark-hero-01.svg';
    public ?string $ctaHref = "about";
    public ?string $ctaLabel = "En savoir plus";
    public string $size = 'sm';

    public function heightClass(): string
    {
        return match ($this->size) {
            'xs' => 'min-h-[30vh]',
            'sm' => 'min-h-[40vh]',
            'md' => 'min-h-[56vh]',
            'lg' => 'min-h-[70vh]',
            'full' => 'min-h-[90vh]',
            default => 'min-h-[40vh]',
        };
    }
}
