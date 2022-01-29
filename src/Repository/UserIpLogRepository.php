<?php

namespace App\Repository;

use App\Entity\UserIpLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;


/**
 * @method UserIpLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserIpLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserIpLog[]    findAll()
 * @method UserIpLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserIpLogRepository extends ServiceEntityRepository
{
    public const PAGINATOR_PER_PAGE =2;

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

    public function findAllIp(int $id, int $offset): Paginator
//    public function findAllIp(int $id, int $limit_size): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT * FROM user_ip_log i  where i.user_id = ".$id
               ." LIMIT ".$offset.", 5";
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery([]);
        var_dump($sql);


        $query = $this->createQueryBuilder('c')
        ->andWhere('c.user = :id')
        ->setParameter('id', $id)
        ->setMaxResults(self::PAGINATOR_PER_PAGE)
        ->setFirstResult($offset)
        ->getQuery();
        var_dump($query->getSQL());
//        $resultSet = $stmt->executeQuery(['user_id' => $id, 'page_size'=>$page_size]);

        // returns an array of arrays (i.e. a raw data set)
//        return $resultSet->fetchAllAssociative();
      //  return $resultSet->fetchAllAssociative();
        return new Paginator($query);
    }
 /*   public function findAllIp(int $id): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT * FROM user_ip_log i WHERE i.user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['user_id' => $id]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
*/


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
