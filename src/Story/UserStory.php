<?php

namespace App\Story;

use Zenstruck\Foundry\Story;
use App\Factory\RoleFactory;
use App\Factory\AccountFactory;

final class UserStory extends Story
{
    public function build(): void
    {
        // Retrieve (or create if missing) roles only once
        $userRole  = RoleFactory::findOrCreate(['label' => 'ROLE_USER']);
        $adminRole = RoleFactory::findOrCreate(['label' => 'ROLE_ADMIN']);
        $superAdminRole = RoleFactory::findOrCreate(['label' => 'ROLE_SUPER_ADMIN']);

        // 20 user accounts linked to the user role
        AccountFactory::createMany(20, fn() => [
            'role' => $userRole,
        ]);

        // 1 admin account
        AccountFactory::createOne([
            'email' => 'admin@example.com',
            'role'  => $adminRole,
        ]);

        // 1 super admin account
        AccountFactory::createOne([
            'email' => 'superadmin@example.com',
            'role'  => $superAdminRole,
        ]);
    }
}
