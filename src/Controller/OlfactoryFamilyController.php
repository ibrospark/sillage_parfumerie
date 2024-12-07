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

        // Create a query builder for products by olfactory family
        $queryBuilder = $productRepository->createQueryBuilder('p')
            ->where('p.olfactoryFamily = :olfactoryFamily')
            ->setParameter('olfactoryFamily', $olfactoryFamily);

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
