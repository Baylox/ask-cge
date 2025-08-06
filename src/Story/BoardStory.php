<?php

namespace App\Story;

use Zenstruck\Foundry\Story;
use App\Factory\BoardFactory;
use App\Factory\AccountFactory;

final class BoardStory extends Story
{
    public function build(): void
    {
        BoardFactory::new()->withAccounts(3)->create();
    }
}