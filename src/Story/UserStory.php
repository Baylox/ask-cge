<?php

namespace App\Story;

use Zenstruck\Foundry\Story;
use App\Factory\RoleFactory;
use App\Factory\AccountFactory;

final class UserStory extends Story
{
    // Build method to seed initial data for testing or development
    public function build(): void
    {
        // Create 'ROLE_USER' role
        RoleFactory::createOne(['label' => 'ROLE_USER']);
        
        // Create accounts, each associated with the 'ROLE_USER' role
        AccountFactory::createMany(5, fn() => [
            'role' => RoleFactory::findOrCreate(['label' => 'ROLE_USER']),
        ]);
    }
}
