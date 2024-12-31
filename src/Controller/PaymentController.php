<?php

namespace App\Controller;

use App\Service\PayDunyaService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
  private $payDunyaService;

  public function __construct(PayDunyaService $payDunyaService)
  {
    $this->payDunyaService = $payDunyaService;
  }

  #[Route('/pay', name: 'app_pay')]
  public function pay(): Response
  {
    try {
      $amount = 10000; // Montant en F
      $description = 'Achat de produit'; // Description du produit
      $storeName = 'Nom de la boutique'; // Nom de la boutique

      // Créer une facture et récupérer l'URL de paiement
      $currency = 'XOF'; // Devise
      $callbackUrl = $this->generateUrl('app_pay_confirm', [], true); // URL de callback

      $paymentUrl = $this->payDunyaService->createInvoice($amount, $description, $currency, $callbackUrl, $storeName);

      return $this->redirect($paymentUrl);
    } catch (\Exception $e) {
      return new Response("Erreur lors de la création du paiement : " . $e->getMessage());
    }
  }

  #[Route('/pay/confirm', name: 'app_pay_confirm')]
  public function confirm(Request $request): Response
  {
    try {
      $token = $request->get('token');

      // Confirmer le paiement
      $status = $this->payDunyaService->confirmPayment($token);

      if ($status === 'completed') {
        return new Response('Paiement réussi !');
      }

      return new Response('Le paiement est en attente ou a échoué.');
    } catch (\Exception $e) {
      return new Response("Erreur lors de la confirmation du paiement : " . $e->getMessage());
    }
  }
}
