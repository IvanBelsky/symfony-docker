<?php

namespace App\Repository;

use App\Entity\UserIpLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserIpLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserIpLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserIpLog[]    findAll()
 * @method UserIpLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserIpLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserIpLog::class);
    }

    // /**
    //  * @return UserIpLog[] Returns an array of UserIpLog objects
    //  */

    public function findIpLogById(int $value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.user = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllIp(int $id): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT * FROM user_ip_log i WHERE i.user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['user_id' => $id]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }



    /*
    public function findOneBySomeField($value): ?UserIpLog
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
