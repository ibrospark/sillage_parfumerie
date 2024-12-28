<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ProductRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CartService;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/account')]
final class OrderController extends AbstractController
{
    #[Route('/order', name: 'order.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CartService $cartService, SessionInterface $session, ProductRepository $productRepository): Response
    {
        // Récupérer les éléments du panier à partir de la session
        $cartItems = $request->getSession()->get('cart', []);
        if (empty($cartItems)) {
            $this->addFlash('error', 'Votre panier est vide. Ajoutez des articles avant de passer une commande.');
            return $this->redirectToRoute('cart.index');
        }

        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer l'utilisateur connecté
            $user = $this->getUser();
            if (!$user) {
                $this->addFlash('error', 'Vous devez être connecté pour passer une commande.');
                return $this->redirectToRoute('app_login');
            }

            $order->setUser($user);
            $order->setCreatedAt(new \DateTime());

            // Ajouter les items à la commande
            foreach ($cartItems as $cartItem) {
                $product = $cartItem['product'] ?? null;
                $quantity = $cartItem['quantity'] ?? 0;
                $price = $cartItem['price'] ?? 0.0;

                if ($product && $quantity > 0 && $price > 0) {
                    $orderItem = new OrderItem();
                    $orderItem->setProduct($product);
                    $orderItem->setQuantity($quantity);
                    $orderItem->setPrice($price);
                    $order->addItem($orderItem);
                }
            }

            // Calcul du montant total
            $totalAmount = $this->calculateTotalAmount($order);
            if ($totalAmount <= 0) {
                $this->addFlash('error', 'Le montant total de la commande doit être supérieur à zéro.');
                return $this->render('order/new.html.twig', [
                    'form' => $form->createView(),
                ]);
            }

            $order->setTotalAmount($totalAmount);

            // Sauvegarder la commande dans la base de données
            $entityManager->persist($order);
            $entityManager->flush();

            // Vider le panier après la commande
            $request->getSession()->remove('cart');

            // Afficher un message de succès et rediriger
            $this->addFlash('success', 'Votre commande a été passée avec succès.');
            return $this->redirectToRoute('order.success');
        }

        list($cart, $totalQuantity) = $cartService->getFullCart($session, $productRepository);
        $totalPrice = $cartService->getTotal($session, $productRepository);

        return $this->render('order/new.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart,
            'totalQuantity' => $totalQuantity,
            'totalPrice' => $totalPrice,
        ]);
    }

    #[Route('/order/success', name: 'order.success', methods: ['GET'])]
    public function success(): Response
    {
        return $this->render('order/success.html.twig');
    }

    private function calculateTotalAmount(Order $order): float
    {
        $total = 0;
        foreach ($order->getItems() as $item) {
            $total += $item->getPrice() * $item->getQuantity();
        }
        return $total;
    }
}
