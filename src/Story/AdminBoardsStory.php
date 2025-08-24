<?php

namespace App\Story;

use Zenstruck\Foundry\Story;
use App\Factory\BoardFactory;
use App\Factory\AccountFactory;

final class AdminBoardsStory extends Story
{
    public function build(): void
    {
        $admin = AccountFactory::find(['email' => 'admin@example.com']);

        // Creates 10 different boards, each one associated only with the admin
        BoardFactory::new()->many(10)->create([
            'accounts' => [$admin], // Each board contains only the admin
        ]);
    }
}
