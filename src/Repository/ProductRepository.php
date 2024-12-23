<?php

namespace App\Repository;

use App\Model\Search;
use App\Entity\Product;
use App\Entity\OlfactoryNote;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

namespace App\Repository;

use App\Model\Search;
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

    // Trouve la marque d'un produit à partir de son ID
    public function findBrandByProductId(int $productId)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.brand', 'b')
            ->addSelect('b')
            ->where('p.id = :id')
            ->setParameter('id', $productId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    // Récupère tous les produits
    public function findAllProducts(): array
    {
        return $this->findAll();
    }

    // Trouve un produit par son ID
    public function findProductById($id): ?Product
    {
        return $this->find($id);
    }

    // Trouve les produits d'une catégorie spécifique
    public function findByCategory($category): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.category = :val')
            ->setParameter('val', $category)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // Trouve les produits par leur famille olfactive
    public function findByOlfactoryFamily(int $olfactoryFamilyId): array
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.olfactoryFamily', 'olfactoryFamily') // Utilisation du nom complet
            ->andWhere('olfactoryFamily.id = :olfactoryFamilyId')
            ->setParameter('olfactoryFamilyId', $olfactoryFamilyId)
            ->getQuery()
            ->getResult();
    }

    // Récupère les produits ayant un prix supérieur à la valeur donnée
    public function findProductsAbovePrice($price): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.price > :val')
            ->setParameter('val', $price)
            ->orderBy('p.price', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // Trouve un produit par son nom
    public function findOneByName($name): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.name = :val')
            ->setParameter('val', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    // Compte tous les produits
    public function countAllProducts(): int
    {
        return (int) $this->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    // Récupère tous les produits triés par prix
    public function findAllOrderedByPrice(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.price', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // Récupère un nombre limité de produits
    public function findLimitedProducts($limit): array
    {
        return $this->createQueryBuilder('p')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    // Recherche des produits en fonction de plusieurs critères
    public function findByCriteria(array $criteria): array
    {
        $qb = $this->createQueryBuilder('p');

        foreach ($criteria as $field => $value) {
            $qb->andWhere("p.$field = :$field")
                ->setParameter($field, $value);
        }

        return $qb->getQuery()->getResult();
    }

    // Recherche des produits dont la description contient un terme spécifique
    public function findByDescriptionContains($searchTerm): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.description LIKE :searchTerm')
            ->setParameter('searchTerm', '%' . $searchTerm . '%')
            ->getQuery()
            ->getResult();
    }

    // Récupère les produits créés après une date donnée
    public function findProductsCreatedAfter(\DateTime $date): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.createdAt > :date')
            ->setParameter('date', $date)
            ->orderBy('p.createdAt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // Trouve des produits par leurs IDs
    public function findByIds(array $ids): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult();
    }

    // Récupère les produits selon leur statut
    public function findByStatus($status): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.status = :status')
            ->setParameter('status', $status)
            ->getQuery()
            ->getResult();
    }

    // Récupère les produits en stock (quantité > 0)
    public function findInStock(): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.stock > 0')
            ->getQuery()
            ->getResult();
    }

    // Récupère les produits avec pagination
    public function findPaginatedProducts($limit, $offset): array
    {
        return $this->createQueryBuilder('p')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    // Trouve les produits ayant une note moyenne supérieure ou égale à un seuil donné
    public function findByAverageRating($minRating): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.averageRating >= :minRating')
            ->setParameter('minRating', $minRating)
            ->getQuery()
            ->getResult();
    }

    // Trouve les produits ayant une note de fond spécifique
    public function findByBackgroundNote(OlfactoryNote $backgroundNote): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.background_note = :backgroundNote')
            ->setParameter('backgroundNote', $backgroundNote)
            ->getQuery()
            ->getResult();
    }

    // Recherche des produits en fonction de critères multiples via un objet Search
    public function findWithSearch(Search $search): array
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

    // Méthode simple pour rechercher des produits par nom
    public function searchProducts($query)
    {
        $qb = $this->createQueryBuilder('p');

        if ($query) {
            $qb->andWhere('p.name LIKE :query')
                ->setParameter('query', '%' . $query . '%');
        }

        return $qb->getQuery()->getResult();
    }
}
