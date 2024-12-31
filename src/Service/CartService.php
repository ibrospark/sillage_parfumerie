<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{

    public function add(int $id, int $quantity = 1, SessionInterface $session): void
    {
        // Récupère le panier actuel depuis la session (s'il n'existe pas, un tableau vide est utilisé)
        $cart = $session->get('cart', []);

        // Si le produit est déjà dans le panier, on augmente sa quantité
        if (!empty($cart[$id])) {
            $cart[$id] += $quantity;  // Incrémente la quantité existante
        } else {
            // Sinon, on ajoute le produit avec la quantité spécifiée
            $cart[$id] = $quantity;
        }

        // Mise à jour du panier dans la session
        $session->set('cart', $cart);
    }

    // Suppression d'un produit du panier
    public function remove(int $id, SessionInterface $session): void
    {
        $cart = $session->get('cart', []);

        // Vérification si le produit est dans le panier
        if (!empty($cart[$id])) {
            // Suppression du produit
            unset($cart[$id]);
        }

        // Mise à jour du panier dans la session
        $session->set('cart', $cart);
    }

    // Mise à jour de la quantité d'un produit dans le panier
    public function updateQuantity(int $id, int $quantity, SessionInterface $session): void
    {
        $cart = $session->get('cart', []);

        // Vérification si le produit existe déjà dans le panier
        if (isset($cart[$id])) {
            if ($quantity > 0) {
                // Si la quantité est positive, on met à jour
                $cart[$id] = $quantity;
            } else {
                // Sinon, on supprime le produit du panier
                unset($cart[$id]);
            }
        }

        // Mise à jour du panier dans la session
        $session->set('cart', $cart);
    }

    // Récupère les produits et leurs quantités dans le panier avec les données complètes des produits
    public function getFullCart(SessionInterface $session, ProductRepository $productRepository): array
    {
        $cart = $session->get('cart', []);
        $cartWithData = [];
        $totalQuantity = 0;

        // Parcours de chaque produit dans le panier pour récupérer les informations du produit
        foreach ($cart as $id => $quantity) {
            $product = $productRepository->find($id);

            // Si le produit n'existe pas dans la base de données, on le saute
            if (!$product) {
                continue;
            }

            // Ajout des informations du produit et de la quantité dans le panier
            $cartWithData[] = [
                'product' => $product,
                'quantity' => $quantity,
            ];
            $totalQuantity += $quantity;
        }

        return [$cartWithData, $totalQuantity];
    }

    // Calcule le total du panier
    public function getTotal(SessionInterface $session, ProductRepository $productRepository): float
    {
        $total = 0;
        // Récupère les données complètes du panier
        list($cartWithData,) = $this->getFullCart($session, $productRepository);

        // Calcule le total en fonction du prix régulier des produits et de la quantité
        foreach ($cartWithData as $item) {
            $total += $item['product']->getRegularPrice() * $item['quantity'];
        }

        return $total;
    }

    // Vide le panier de la session
    public function clear(SessionInterface $session): void
    {
        $session->remove('cart');
    }
}
