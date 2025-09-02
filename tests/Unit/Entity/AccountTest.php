<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Account;
use App\Entity\Board;
use App\Entity\Role;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

#[CoversClass(Account::class)]
final class AccountTest extends TestCase
{
    public function testUserIdentifierReturnsEmail(): void
    {
        $a = new Account();
        $a->setEmail('user@example.com');

        self::assertSame('user@example.com', $a->getUserIdentifier());
        self::assertSame('user@example.com', $a->getEmail());
    }

    public function testPasswordDefaultsToEmptyString(): void
    {
        $a = new Account();
        self::assertSame('', $a->getPassword());

        $a->setPassword('hash');
        self::assertSame('hash', $a->getPassword());
    }

    public function testGetRolesDefaultsToRoleUser(): void
    {
        $a = new Account();
        $roles = $a->getRoles();

        self::assertContains('ROLE_USER', $roles);
        self::assertCount(1, $roles); // only ROLE_USER
    }

    public function testGetRolesIncludesCustomRoleAndRoleUser(): void
    {
        $a = new Account();

        // Stub Role::getLabel() to return a custom role
        $role = $this->createStub(Role::class);
        $role->method('getLabel')->willReturn('ROLE_ADMIN');

        $a->setRole($role);

        $roles = $a->getRoles();
        self::assertContains('ROLE_ADMIN', $roles);
        self::assertContains('ROLE_USER', $roles);
        self::assertSame($roles, array_unique($roles));
    }

    public function testAddRemoveBoardNoDuplicates(): void
    {
        $a = new Account();
        $b = new Board();

        $a->addBoard($b);
        $a->addBoard($b); // musn't duplicate the board

        self::assertTrue($a->getBoards()->contains($b));
        self::assertCount(1, $a->getBoards());

        $a->removeBoard($b);
        self::assertFalse($a->getBoards()->contains($b));
        self::assertCount(0, $a->getBoards());
    }

    public function testEmailValidationConstraints(): void
    {
        $validator = Validation::createValidatorBuilder()->enableAttributeMapping()->getValidator();

        $a = new Account();
        $a->setEmail('not-an-email');

        // NotBlank + Email should fail here
        $violations = $validator->validate($a);
        self::assertGreaterThan(0, $violations->count());

        $a->setEmail('user@example.com');
        $violations = $validator->validate($a);
        self::assertSame(0, $violations->count());
    }
}
