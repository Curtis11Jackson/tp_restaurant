<?php

namespace App\Repository;

use App\Entity\Menus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Menus|null find($id, $lockMode = null, $lockVersion = null)
 * @method Menus|null findOneBy(array $criteria, array $orderBy = null)
 * @method Menus[]    findAll()
 * @method Menus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Menus::class);
    }


    public function findMenuById($id){

        $qb = $this->createQueryBuilder('m')
            ->select('m');


        $qb->where('m.id = :id')->setParameter('id', $id);

        $data = $qb->getQuery()->getResult();

        return $data;
    }

    
    public function DeleteMenu($id) {
        $qb = $this->createQueryBuilder('m')
            ->select('m');

    $qb->delete()
        ->where('m.id = :id')
        ->setParameter('id',$id);


        $data = $qb->getQuery()->getResult();

        return $data;

    }

}
