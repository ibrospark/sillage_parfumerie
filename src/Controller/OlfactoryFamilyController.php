<?php

namespace App\Controller;

use App\Entity\OlfactoryFamily;
use App\Form\OlfactoryFamilyType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\OlfactoryFamilyRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/olfactoryfamily')]
final class OlfactoryFamilyController extends AbstractController
{
    #[Route(name: 'olfactoryfamily.index', methods: ['GET'])]
    public function indexPublic(OlfactoryFamilyRepository $olfactoryFamilyRepository): Response
    {
        return $this->render('olfactory_family/index.html.twig', [
            'olfactory_families' => $olfactoryFamilyRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'olfactoryfamily.show', methods: ['GET'])]
    public function show(OlfactoryFamily $olfactoryFamily, ProductRepository $productRepository, PaginatorInterface $paginator, Request $request): Response
    {
        // Get the current page number from the request (default is 1)
        $page = $request->query->getInt('page', 1);
        $limit = 24; // Number of items per page


        $queryBuilder = $productRepository->createQueryBuilder('p')
            ->innerJoin('p.olfactoryFamily', 'o')  // Jointure avec la table "product_category"
            ->where('o.id = :olfactoryFamilyId')
            ->setParameter('olfactoryFamilyId', $olfactoryFamily->getId());
        // Fetch paginated results
        $pagination = $paginator->paginate(
            $queryBuilder, // QueryBuilder
            $page, // Current page number
            $limit // Number of items per page
        );

        return $this->render('olfactory_family/show.html.twig', [
            'olfactory_family' => $olfactoryFamily,
            'pagination' => $pagination, // Pass paginated products
            'title_page' => 'Nos familles olfactives',
        ]);
    }
}
