<?php

namespace App\Story;

use Zenstruck\Foundry\Story;
use App\Factory\BoardFactory;
use App\Factory\AccountFactory;

final class BoardStory extends Story
{
    public function build(): void
    {
        AccountFactory::createMany(10); 
        BoardFactory::createMany(5);
        BoardFactory::new()->withAccounts(3)->create();
    }
}