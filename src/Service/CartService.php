<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    // Retirez la session du constructeur

    public function add(int $id, SessionInterface $session): void
    {
        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $session->set('cart', $cart);
    }

    public function remove(int $id, SessionInterface $session): void
    {
        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);
    }

    public function updateQuantity(int $id, int $quantity, SessionInterface $session): void
    {
        $cart = $session->get('cart', []);

        if (isset($cart[$id])) {
            if ($quantity > 0) {
                $cart[$id] = $quantity;
            } else {
                unset($cart[$id]);
            }
        }

        $session->set('cart', $cart);
    }

    public function getFullCart(SessionInterface $session, ProductRepository $productRepository): array
    {
        $cart = $session->get('cart', []);
        $cartWithData = [];
        $totalQuantity = 0;

        foreach ($cart as $id => $quantity) {
            $product = $productRepository->find($id);

            if (!$product) {
                continue;
            }

            $cartWithData[] = [
                'product' => $product,
                'quantity' => $quantity,
            ];
            $totalQuantity += $quantity;
        }

        return [$cartWithData, $totalQuantity];
    }


    public function getTotal(SessionInterface $session, ProductRepository $productRepository): float
    {
        $total = 0;
        // Obtenez le panier complet avec les données des produits
        list($cartWithData,) = $this->getFullCart($session, $productRepository);

        // Calculez le total
        foreach ($cartWithData as $item) {
            $total += $item['product']->getRegularPrice() * $item['quantity'];
        }

        return $total;
    }

    public function clear(SessionInterface $session): void
    {
        $session->remove('cart');
    }
}
