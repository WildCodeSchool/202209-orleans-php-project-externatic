<?php

namespace App\Repository;

use App\Entity\Offer;
use App\Entity\SearchOfferModule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Offer>
 *
 * @method Offer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offer[]    findAll()
 * @method Offer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferRepository extends ServiceEntityRepository
{
    public const DEGREE_TO_KM = 111;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offer::class);
    }

    public function save(Offer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Offer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByKeyWord(SearchOfferModule $search): array
    {
        $query = $this->createQueryBuilder('o');
        if ($search->getSearch() !== null) {
            $query->Where('o.title LIKE :val')
                ->setParameter('val', '%' . $search->getSearch() . '%');
        }
        if ($search->getLongitude() !== null && $search->getLongitude() !== null) {
            $range = $search->getRange() / self::DEGREE_TO_KM;
            $latMinRange = $search->getLatitude() - $range;
            $latMaxRange = $search->getLatitude() + $range;
            $lngMinRange = $search->getLongitude() - $range;
            $lngMaxRange = $search->getLongitude() + $range;

            $query->andWhere('o.latitude BETWEEN ' . $latMinRange . ' AND ' . $latMaxRange)
                ->andWhere('o.longitude BETWEEN ' . $lngMinRange . ' AND ' . $lngMaxRange)
                ->setMaxResults(50)
                ->orderBy('o.createdAt', 'DESC');
        }

        return $query->getQuery()->getResult();
    }

    public function findAllInProgress(): array
    {
        $query = $this->createQueryBuilder('o')
            ->leftJoin('o.applications', 'a')
            ->where('a.applicationStatus = :status ')
            ->setParameter('status', 'in-progress')
            ;
            return $query->getQuery()->getResult();
    }

    //    /**
    //     * @return Offer[] Returns an array of Offer objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Offer
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
