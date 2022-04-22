<?php

namespace App\Repository;

use App\Entity\Entreprises;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Entreprises|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entreprises|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entreprises[]    findAll()
 * @method Entreprises[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrepriseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entreprises::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Entreprises $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Entreprises $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function search($_zNom, $_zEmail)
    {
        $query = $this->createQueryBuilder('e')
            ->andWhere('e.name = :name')
            ->andWhere('e.email = :email')
            ->setParameter('name', $_zNom)
            ->setParameter('email', $_zEmail)
            ->orderBy('e.id', 'asc')
            ->setMaxResults(10);
       // dump($_zNom, $_zEmail);
       // dump($query->getQuery()->getSQL()); die;
        return $query
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Entreprises[] Returns an array of Entreprises objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Entreprises
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
