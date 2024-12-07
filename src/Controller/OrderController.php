<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/account')]
final class OrderController extends AbstractController
{
    #[Route('/order', name: 'order.new', methods: ['GET', 'POST'])] // Route pour créer une nouvelle commande
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupérer les éléments du panier à partir de la session
        $cartItems = $request->getSession()->get('cart', []);

        if (empty($cartItems)) {
            // Gérer le cas où le panier est vide
            $this->addFlash('error', 'Votre panier est vide. Ajoutez des articles avant de passer une commande.');
            return $this->redirectToRoute('cart.index'); // Redirection vers la page du panier
        }

        $order = new Order(); // Création d'une nouvelle instance de Order
        $form = $this->createForm(OrderType::class, $order); // Création du formulaire

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer l'utilisateur connecté
            $user = $this->getUser();
            if ($user) {
                $order->setUser($user); // Associer l'utilisateur à la commande
            } else {
                // Gérer le cas où l'utilisateur n'est pas connecté
                $this->addFlash('error', 'Vous devez être connecté pour passer une commande.');
                return $this->redirectToRoute('app_login'); // Redirection vers la page de connexion
            }

            // Enregistrement de la date de création de la commande
            $order->setCreatedAt(new \DateTime());

            // Créer les OrderItems à partir des éléments du panier
            foreach ($cartItems as $cartItem) {
                $product = $cartItem['product'] ?? null; // Utilisez ?? pour obtenir null si la clé n'existe pas
                $quantity = $cartItem['quantity'] ?? 0; // Valeur par défaut à 0
                $price = $cartItem['price'] ?? 0.0; // Valeur par défaut à 0.0

                if ($product && $quantity > 0 && $price > 0) {
                    $orderItem = new OrderItem();
                    $orderItem->setProduct($product);
                    $orderItem->setQuantity($quantity);
                    $orderItem->setPrice($price);
                    $order->addItem($orderItem);
                } else {
                    // Gérer le cas où les données de panier sont incomplètes
                    $this->addFlash('error', 'Les éléments du panier sont incomplets.');
                    return $this->redirectToRoute('cart.index'); // Redirection vers la page du panier
                }
            }


            // Calculer le montant total de la commande
            $totalAmount = $this->calculateTotalAmount($order);
            if ($totalAmount <= 0) {
                $this->addFlash('error', 'Le montant total de la commande doit être supérieur à zéro.');
                return $this->render('order/new.html.twig', [
                    'form' => $form->createView(),
                ]);
            }
            $order->setTotalAmount($totalAmount); // Définir le montant total de la commande

            // Sauvegarder la commande dans la base de données
            $entityManager->persist($order);
            $entityManager->flush();

            // Vider le panier après la commande
            $request->getSession()->remove('cart');

            // Rediriger ou afficher un message de succès
            $this->addFlash('success', 'Votre commande a été passée avec succès.');
            return $this->redirectToRoute('order.success'); // Redirection vers la page de succès
        }

        // Rendu du formulaire pour la création de commande
        return $this->render('order/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/order/success', name: 'order.success', methods: ['GET'])] // Route pour afficher le succès de la commande
    public function success(): Response
    {
        return $this->render('order/success.html.twig'); // Rendu de la vue de succès
    }

    /**
     * Calcule le montant total de la commande.
     *
     * @param Order $order
     * @return float
     */
    private function calculateTotalAmount(Order $order): float
    {
        $total = 0;
        foreach ($order->getItems() as $item) {
            $total += $item->getPrice() * $item->getQuantity(); // Calculer le total pour chaque article
        }
        return $total; // Retourner le montant total
    }
}
