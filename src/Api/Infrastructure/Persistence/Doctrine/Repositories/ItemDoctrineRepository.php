<?php

declare(strict_types=1);

namespace App\Api\Infrastructure\Persistence\Doctrine\Repositories;

use App\Api\Domain\Repositories\ItemRepository;
use App\Api\Domain\Entities\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;

/**
 * @method Item|null find($id, $lockMode = null, $lockVersion = null)
 * @method Item|null findOneBy(array $criteria, array $orderBy = null)
 * @method Item[]    findAll()
 * @method Item[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemDoctrineRepository extends ServiceEntityRepository implements ItemRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }

    public function findById(Uuid $machineId): ?Item
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.id = :val')
            ->setParameter('val', $machineId)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function findAllByCart(Uuid $cartId): ?array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.cart_id = :val')
            ->setParameter('val', $cartId)
            ->getQuery()
            ->getResult()
            ;
    }
}
