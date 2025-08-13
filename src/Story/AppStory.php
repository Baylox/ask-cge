<?php

namespace App\Story;

use App\Entity\Board;
use Zenstruck\Foundry\Attribute\AsFixture;
use Zenstruck\Foundry\Story;
use App\Story\UserStory;

#[AsFixture(name: 'main')]
final class AppStory extends Story
{
    public function build(): void
    {
        UserStory::load();
        BoardStory::load();
        BoardLanesStory::load();
        BoardsLanesCardsStory::load();
    }
}
