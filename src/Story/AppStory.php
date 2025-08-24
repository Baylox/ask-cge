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
        UserStory::load(); // Load the user story
        BoardStory::load(); // Load the board story
        BoardLanesStory::load(); // Load the board lanes story
        BoardsLanesCardsStory::load(); // Load the boards, lanes, and cards story
        AdminBoardsStory::load(); // Load the admin boards story
    }
}
