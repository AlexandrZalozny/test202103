<?php
namespace App\Repository;

use App\Entity\Store;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Cache;
use Doctrine\Persistence\ManagerRegistry;

class StoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Store::class);
    }


    /**
     * @return Store[]
     */
    public function findByCoordinates($x,$y,$r)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT s
            FROM App\Entity\Store s
            WHERE POWER(POWER(:x - s.x, 2)  +  POWER(:y - s.y, 2), 0.5) <= :r
            '
        );

        $query->setParameter('x', $x)
        ->setParameter('y', $y)
        ->setParameter('r', $r)
            ->setCacheMode(Cache::MODE_GET)
            ->setCacheable(true);

        return $query->getArrayResult();
    }
}