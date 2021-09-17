<?php

namespace App\Repository;

use App\Entity\PermissionRule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PermissionRule|null find($id, $lockMode = null, $lockVersion = null)
 * @method PermissionRule|null findOneBy(array $criteria, array $orderBy = null)
 * @method PermissionRule[]    findAll()
 * @method PermissionRule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PermissionRuleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PermissionRule::class);
    }
}
