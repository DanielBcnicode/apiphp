<?php

namespace App\Api\Infrastructure\Persistence\Doctrine\Repositories;

use App\Api\Domain\Entities\Cart;
use App\Api\Domain\Repositories\CartRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;

/**
 * @method Cart|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cart|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cart[]    findAll()
 * @method Cart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartDoctrineRepository extends ServiceEntityRepository implements CartRepository
{
    private ManagerRegistry $manager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
        $this->manager = $registry;
    }

    public function findById(Uuid $uuid): ?Cart
    {
        return $this->find($uuid);
    }

    public function save(Cart $Cart)
    {
        $this->manager->getManager()->persist($Cart);
        $this->manager->getManager()->flush();
    }
}
