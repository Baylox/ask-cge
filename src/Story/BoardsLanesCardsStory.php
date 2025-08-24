<?php

namespace App\Story;

use App\Factory\BoardFactory;
use App\Factory\LaneFactory;
use App\Factory\CardFactory;
use Zenstruck\Foundry\Story;

final class BoardsLanesCardsStory extends Story
{

     // This method creates 2 boards, each containing 3 lanes.
    public function build(): void
    {
        $boards = BoardFactory::createMany(2);

        foreach ($boards as $board) {
            $lanes = LaneFactory::createMany(3, ['board' => $board]);

            // For each lane, it generates between 3 and 7 associated cards.
            foreach ($lanes as $lane) {
                $count = random_int(3, 7);
                CardFactory::createMany($count, ['lane' => $lane]);
            }
        }
    }
}
