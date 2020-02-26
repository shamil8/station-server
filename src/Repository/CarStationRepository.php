<?php

namespace App\Repository;

use App\Entity\CarStation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CarStation|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarStation|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarStation[]    findAll()
 * @method CarStation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarStationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarStation::class);
    }

    // /**
    //  * @return CarStation[] Returns an array of CarStation objects
    //  */
    public function getCarStation($currentPage)
    {
        $pageSize = 3;
        return $this->createQueryBuilder('c')
            ->select('c.id, c.quantity, c.date, car.mark, car.number, car.type, s.name, s.address')
            ->join('c.cars', 'car')
            ->join('c.stations', 's')
            ->setFirstResult($pageSize * ($currentPage-1))
            ->setMaxResults($pageSize)
            ->getQuery()
            ->getResult()
        ;
    }


    public function getCount()
    {
        return $this->createQueryBuilder('c')
            ->select('count(c.id)')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
