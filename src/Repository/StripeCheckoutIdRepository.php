<?php

namespace App\Repository;

use App\Entity\StripeCheckoutId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StripeCheckoutId>
 *
 * @method StripeCheckoutId|null find($id, $lockMode = null, $lockVersion = null)
 * @method StripeCheckoutId|null findOneBy(array $criteria, array $orderBy = null)
 * @method StripeCheckoutId[]    findAll()
 * @method StripeCheckoutId[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StripeCheckoutIdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StripeCheckoutId::class);
    }

    public function save(StripeCheckoutId $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(StripeCheckoutId $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return StripeCheckoutId[] Returns an array of StripeCheckoutId objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StripeCheckoutId
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
