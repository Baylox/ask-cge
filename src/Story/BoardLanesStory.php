<?php

namespace App\Story;

use App\Factory\BoardFactory;
use App\Factory\LaneFactory;
use Zenstruck\Foundry\Story;

final class BoardLanesStory extends Story
{
    public function build(): void
    {
        $boards = BoardFactory::createMany(3); // returns a list of Proxy<Board>

        // For each board create associated lanes
        foreach ($boards as $board) {
            LaneFactory::createMany(3, ['board' => $board]);
        }
    }
}
