<?php


namespace App\Entity;

enum BoardState: string{
    case Publishe = 'PUBLISHED';

    case Draft = 'Draft';
}
