<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProductRepository;

#[Route('/cart')]
class CartController extends AbstractController
{
    #[Route(name: 'cart.index')]
    public function index(CartService $cartService, SessionInterface $session, ProductRepository $productRepository): Response
    {
        list($cart, $totalQuantity) = $cartService->getFullCart($session, $productRepository);
        $totalPrice = $cartService->getTotal($session, $productRepository);

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'totalQuantity' => $totalQuantity,
            'totalPrice' => $totalPrice,
        ]);
    }

    #[Route('/add/{id}', name: 'cart.add')]
    public function add(int $id, CartService $cartService, SessionInterface $session): RedirectResponse
    {
        $cartService->add($id, $session);
        return $this->redirectToRoute('cart.index');
    }

    #[Route('/remove/{id}', name: 'remove.cart_item')]
    public function remove(int $id, CartService $cartService, SessionInterface $session): RedirectResponse
    {
        $cartService->remove($id, $session);
        return $this->redirectToRoute('cart.index');
    }

    #[Route('/clear', name: 'remove.cart')]
    public function clear(CartService $cartService, SessionInterface $session): RedirectResponse
    {
        $cartService->clear($session);
        return $this->redirectToRoute('cart.index');
    }
}
