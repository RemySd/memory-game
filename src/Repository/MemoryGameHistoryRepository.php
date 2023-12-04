<?php

namespace App\Repository;

use App\Entity\MemoryGameHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MemoryGameHistory>
 *
 * @method MemoryGameHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method MemoryGameHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method MemoryGameHistory[]    findAll()
 * @method MemoryGameHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemoryGameHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MemoryGameHistory::class);
    }

//    /**
//     * @return MemoryGameHistory[] Returns an array of MemoryGameHistory objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MemoryGameHistory
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
