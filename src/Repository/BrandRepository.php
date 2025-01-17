<?php

namespace App\Repository;

use App\Entity\Brand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Brand>
 */
class BrandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Brand::class);
    }

    //    /**
    //     * @return Brand[] Returns an array of Brand objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }
    /**
     * Récupérer les produits d'une marque donnée.
     */


    /**
     * Filtrer les marques par types de visibilité (en utilisant LIKE).
     *
     * @param array $visibilityTypes
     * @return Brand[]
     */
    public function findByVisibilityTypes(array $visibilityTypes): array
    {
        $qb = $this->createQueryBuilder('b');

        // On ajoute une condition pour chaque type de visibilité
        foreach ($visibilityTypes as $index => $type) {
            $qb->orWhere('b.visibility_types LIKE :type' . $index)
                ->setParameter('type' . $index, '%' . $type . '%');
        }

        return $qb->getQuery()->getResult();
    }

    public function findProductsByBrand(int $brandId)
    {
        return $this->createQueryBuilder('b')
            ->leftJoin('b.products', 'p')
            ->addSelect('p')
            ->where('b.id = :brandId')
            ->setParameter('brandId', $brandId)
            ->getQuery()
            ->getOneOrNullResult();
    }
    //    public function findOneBySomeField($value): ?Brand
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
