<?php

namespace App\Repository;

use App\Entity\Account;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Account>
 */
class AccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Account::class);
    }

    public function autocompleteUsernames(string $userInput): array
    {
        $queryBuilder = $this->createQueryBuilder('user');

        $results = $queryBuilder
            ->select('user.email')
            ->andWhere('user.email LIKE :pattern')
            ->setParameter('pattern', $userInput . '%')
            ->getQuery()
            ->getSingleColumnResult();

        return $results;
    }
}
