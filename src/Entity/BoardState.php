<?php


namespace App\Entity;

enum BoardState: string{
    case Published = 'PUBLISHED';

    case Draft = 'DRAFT';
}
