<?php

namespace App\Repository;

use App\Model\FilterProduct;
use App\Entity\Product;
use App\Entity\OlfactoryNote;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

namespace App\Repository;

use App\Model\FilterProduct;
use App\Entity\Product;
use App\Entity\OlfactoryNote;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }


    public function findByVisibilityTypes(array $visibilityTypes): array
    {
        $qb = $this->createQueryBuilder('p');

        // On ajoute une condition pour chaque type de visibilité
        foreach ($visibilityTypes as $index => $type) {
            $qb->orWhere('p.visibility_types LIKE :type' . $index)
                ->setParameter('type' . $index, '%' . $type . '%');
        }

        return $qb->getQuery()->getResult();
    }

    // Recherche des produits en fonction de critères multiples via un objet Search
    public function multipleFilterProduct(FilterProduct $search): array
    {
        $query = $this->createQueryBuilder('p')
            ->select('p');

        // Recherche par chaîne de texte
        if (!empty($search->getString())) {
            $query->andWhere('p.name LIKE :string')
                ->setParameter('string', "%" . $search->getString() . "%");
        }

        // Filtre par catégorie
        if (!empty($search->getCategories())) {
            $query->andWhere('p.category IN (:categories)')
                ->setParameter('categories', $search->getCategories());
        }

        // Filtre par notes olfactives
        if (!empty($search->getOlfactoryNotes())) {
            $query->andWhere('p.olfactoryNote IN (:olfactoryNotes)')
                ->setParameter('olfactoryNotes', $search->getOlfactoryNotes());
        }

        // Filtre par familles olfactives
        if (!empty($search->getOlfactoryFamilies())) {
            $query->andWhere('p.olfactoryFamily IN (:olfactoryFamilies)')
                ->setParameter('olfactoryFamilies', $search->getOlfactoryFamilies());
        }

        // Filtre par marques
        if (!empty($search->getBrands())) {
            $query->andWhere('p.brand IN (:brands)')
                ->setParameter('brands', $search->getBrands());
        }

        // Filtre par gamme de prix
        if ($search->getMinPrice() !== null) {
            $query->andWhere('p.price >= :minPrice')
                ->setParameter('minPrice', $search->getMinPrice());
        }

        if ($search->getMaxPrice() !== null) {
            $query->andWhere('p.price <= :maxPrice')
                ->setParameter('maxPrice', $search->getMaxPrice());
        }

        // // Filtre pour les produits en vedette
        // if ($search->isFeatured()) {
        //     $query->andWhere('p.featured = :featured')
        //         ->setParameter('featured', true);
        // }

        return $query->getQuery()->getResult();
    }
}
